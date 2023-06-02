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
        
        // If this robot has the signature ability equipped, update the sprite image
        $base_image_token = $this_robot->robot_base_image;
        $alt_image_token = $this_robot->robot_base_image.'_alt';
        if ($this_robot->has_ability('crystal-frag') 
            && $this_robot->robot_image !== $alt_image_token){
            $this_robot->set_image($alt_image_token); 
        } elseif (!$this_robot->has_ability('crystal-frag') 
            && $this_robot->robot_image !== $base_image_token){
            $this_robot->set_image($base_image_token); 
        }

        // Return true on success
        return true;

    },
    'robot_function_onbattlestart' => function($objects){

        // Extract all objects into the current scope
        extract($objects);
        
        // Generate crystal blockade at battle start if signature ability equipped
        if ($this_robot->has_ability('crystal-frag')){

            // Define this ability's attachment token and info
            $static_attachment_key = $this_robot->get_static_attachment_key();
            $this_attachment_info = rpg_ability::get_static_attachment('crystal-frag', 'crystal-frag', $static_attachment_key);
            $this_attachment_token = $this_attachment_info['attachment_token'];

            // Predefine attachment create and destroy text for later
            $this_create_text = $this_robot->print_name().' protected '.$this_robot->get_pronoun('reflexive').' with a '.rpg_type::print_span('crystal', 'Crystal Frag').'!';
            $this_create_text .= '<br /> The fragment blocks all damage <em>once</em> before fading!';

            // Check if the attachment exists yet, and if not add it now
            $attachment_already_exists = $this_battle->has_attachment($static_attachment_key, $this_attachment_token);
            if (!$attachment_already_exists){ 
                $this_robot->set_frame('summon');
                $this_battle->set_attachment($static_attachment_key, $this_attachment_token, $this_attachment_info);                   
                $this_battle->events_create($this_robot, false,
                    $this_robot->print_name_s().' Skill',
                    $this_create_text,
                    array(
                        'event_flag_camera_action' => true,
                        'event_flag_camera_side' => $this_robot->player->player_side,
                        'event_flag_camera_focus' => $this_robot->robot_position,
                        'event_flag_camera_depth' => $this_robot->robot_key
                        )
                  );
                $this_robot->reset_frame();
            }
        
        }

        // Return true on success
        return true;

    },
    'robot_function_onendofturn' => function($objects){

        // Extract all objects into the current scope
        extract($objects);
        
        // Generate crystal blockade at end of turn if signature ability equipped
        if ($this_robot->has_ability('crystal-frag')){

            // Define this ability's attachment token and info
            $static_attachment_key = $this_robot->get_static_attachment_key();
            $this_attachment_info = rpg_ability::get_static_attachment('crystal-frag', 'crystal-frag', $static_attachment_key);
            $this_attachment_token = $this_attachment_info['attachment_token'];

            // Predefine attachment create and destroy text for later
            $this_create_text = $this_robot->print_name().' protected '.$this_robot->get_pronoun('reflexive').' with a '.rpg_type::print_span('crystal', 'Crystal Frag').'!';
            $this_create_text .= '<br /> The fragment blocks all damage <em>once</em> before fading!';

            // Check if the attachment exists yet, and if not add it now
            $attachment_already_exists = $this_battle->has_attachment($static_attachment_key, $this_attachment_token);
            if (!$attachment_already_exists){ 
                $this_robot->set_frame('summon');
                $this_battle->set_attachment($static_attachment_key, $this_attachment_token, $this_attachment_info);                   
                $this_battle->events_create($this_robot, false,
                    $this_robot->print_name_s().' Skill',
                    $this_create_text,
                    array(
                        'event_flag_camera_action' => true,
                        'event_flag_camera_side' => $this_robot->player->player_side,
                        'event_flag_camera_focus' => $this_robot->robot_position,
                        'event_flag_camera_depth' => $this_robot->robot_key
                        )
                  );
                $this_robot->reset_frame();
            }
        
        }

        // Return true on success
        return true;

    }
);
?>
