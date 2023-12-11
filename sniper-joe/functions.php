<?
$functions = array(
    'robot_function' => function($objects){

        // Extract all objects into the current scope
        extract($objects);

        // Return true on success
        return true;

    },
    'robot_function_onload' => function($objects){

        // Extract all objects into the current scope
        extract($objects);

        // Check if the auto-shield has already been summoned
        $this_attachment_token = $this_robot->robot_token.'_auto-shield';
        $is_shielded = $this_robot->has_attachment($this_attachment_token) ? true : false;
        if (!$is_shielded && !$this_robot->get_flag('auto-shield-applied')){
        
            // Define this ability's attachment token
            $this_effect_multiplier = 1 - (99.99 / 100);
            $this_attachment_info = array(
                'class' => 'ability',
                'ability_token' => 'ability',
                'attachment_damage_input_breaker' => $this_effect_multiplier,
                'attachment_create' => array(
                    'trigger' => 'special',
                    'kind' => '',
                    'percent' => true,
                    'frame' => 'taunt',
                    'rates' => array(100, 0, 0),
                    'success' => array(-1, 0, 0, 0,
                        $this_robot->print_name().'\'s shield resists all damage!<br /> '.
                        'Defenses are bolstered right now!'
                        ),
                    'failure' => array(-1, 0, 0, 0,
                        $this_robot->print_name().'\'s shield resists all damage!<br /> '.
                        'Defenses are bolstered right now!'
                        )
                    ),
                'attachment_destroy' => array(
                    'trigger' => 'special',
                    'kind' => '',
                    'type' => '',
                    'percent' => true,
                    'modifiers' => false,
                    'frame' => 'defend',
                    'rates' => array(100, 0, 0),
                    'success' => array(-1, 0, 0, 0,
                        $this_robot->print_name().'\'s shield faded away!<br /> '.
                        'Looks like '.$this_robot->get_pronoun('subject').'\'s no longer protected...'
                        ),
                    'failure' => array(-1, 0, 0, 0,
                        $this_robot->print_name().'\'s shield faded away!<br /> '.
                        'Looks like '.$this_robot->get_pronoun('subject').'\'s no longer protected...'
                        )
                    ),
                'ability_frame' => 0,
                'ability_frame_animate' => array(0),
                'ability_frame_offset' => array('x' => 0, 'y' => 0, 'z' => 0)
                );

            // Attach this auto attachment to the curent robot
            $this_robot->set_attachment($this_attachment_token, $this_attachment_info);
            $this_robot->set_flag('auto-shield-applied', true);
            
        }

        // Return true on success
        return true;

    },
    'robot_function_check-shield' => function($objects){
        //error_log('robot_function_check-shield() for '.$objects['this_robot']->robot_string);

        // Extract all objects into the current scope
        extract($objects);
        
        // Otherwise if already summoned, see if we should remove it
        $this_attachment_token = $this_robot->robot_token.'_auto-shield';
        $is_shielded = $this_robot->has_attachment($this_attachment_token) ? true : false;
        if ($is_shielded){
        
            // Check if the shield has been broken by an ability
            $shields_down = false;
            $shield_breakers_regex = '/^([a-z0-9]+)-buster$/i';
            $shield_breakers_extra = array('mega-slide', 'mega-ball', 'bass-baroque', 'proto-strike', 'charge-kick');
            $shield_breakers_types = array('explode', 'impact');
            if (!empty($this_robot->history)){
                //error_log('Checking '.$this_robot->robot_string.'\'s history for shield breakers '.print_r($this_robot->history, true));
                $damaged_by_abilities = array();
                $damaged_by_types = array();
                $relevant_history = array('triggered_damage', 'triggered_breaks');
                foreach ($relevant_history AS $history_prefix){
                    if (!empty($this_robot->history[$history_prefix.'_by'])){
                        $damaged_by_abilities = $this_robot->history[$history_prefix.'_by'];
                        foreach ($damaged_by_abilities AS $ability_token){
                            if (preg_match($shield_breakers_regex, $ability_token)
                                    || in_array($ability_token, $shield_breakers_extra)){
                                    $shields_down = true;
                                break;
                            }
                        }
                    }
                    if (!empty($this_robot->history[$history_prefix.'_types'])){
                        $damaged_by_types = $this_robot->history[$history_prefix.'_types'];
                        foreach ($damaged_by_types AS $type_list){
                            if (empty($type_list)){ continue; }
                            if (isset($type_list[0]) && in_array($type_list[0], $shield_breakers_types)){
                                    $shields_down = true;
                            } elseif (isset($type_list[1]) && in_array($type_list[1], $shield_breakers_types)){
                                    $shields_down = true;
                            }
                        }
                    }
                }
            }
            
            // Remove this auto attachment from the robot
        	if ($shields_down){
                
                // Unset the attachment from the current robot and save
                $backup_attachment_info = $this_robot->robot_attachments[$this_attachment_token];
                unset($this_robot->robot_attachments[$this_attachment_token]);
                $this_robot->update_session();    
                
                // Update the current robot into their alt outfit
                $this_robot->robot_image = $this_robot->robot_base_image.'_alt';
                $this_robot->update_session();

                // Generate an event to show nothing happened
                $event_header = $this_robot->robot_name.'&#39;s Shield';
                $event_body = array_pop($backup_attachment_info['attachment_destroy']['success']);
                $this_battle->queue_sound_effect('shields-down');
                $this_battle->events_create($this_robot, $this_robot, $event_header, $event_body);
                
                // Call the global stat boost function with customized options                
                rpg_ability::ability_function_stat_break($this_robot, 'defense', 1, false, array(
                    'success_frame' => 9,
                    'failure_frame' => 9,
                    'extra_text' => false
                    ));
                                                
            }
            
        }

        // Return true on success
        return true;

    },
    'rpg-skill_disable-skill_before' => function($objects){

        // Extract all objects into the current scope
        extract($objects);

        // We need to remove the attachment and convert this robot to their sheilds-down image
        $this_attachment_token = $this_robot->robot_token.'_auto-shield';
        $is_shielded = $this_robot->has_attachment($this_attachment_token) ? true : false;
        if ($is_shielded){

            // Unset the attachment from the current robot and save
            $backup_attachment_info = $this_robot->get_attachment($this_attachment_token);
            $this_robot->unset_attachment($this_attachment_token);

            // Update the current robot into their alt outfit
            $base_image_token = $this_robot->robot_token;
            $alt_image_token = $this_robot->robot_token.'_alt';
            $this_robot->set_image($alt_image_token);

            // Generate an event to show nothing happened
            $event_header = $this_robot->robot_name.'&#39;s Shield';
            $event_body = array_pop($backup_attachment_info['attachment_destroy']['success']);
            $this_battle->queue_sound_effect('shields-down');
            $this_battle->events_create($this_robot, $this_robot, $event_header, $event_body);

            // Call the global stat boost function with customized options
            rpg_ability::ability_function_stat_break($this_robot, 'defense', 1, false, array(
                'success_frame' => 9,
                'failure_frame' => 9,
                'extra_text' => false
                ));

        }

        // Return true on success
        return true;

    }
);
$functions['robot_function_ondamage'] = function($objects) use ($functions){
    //error_log('robot_function_ondamage() for '.$objects['this_robot']->robot_string);
    return $functions['robot_function_check-shield']($objects, true);
};
$functions['rpg-ability_stat-break_after'] = function($objects) use ($functions){
    //error_log('rpg-ability_stat-break_after() for '.$objects['this_robot']->robot_string);
    return $functions['robot_function_check-shield']($objects, true);
};
?>
