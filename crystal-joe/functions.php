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
        $base_image_token = $this_robot->robot_token;
        $alt_image_token = $this_robot->robot_token.'_alt';
        if ($this_robot->has_ability('crystal-frag') 
            && $this_robot->robot_image !== $alt_image_token){
            $this_robot->set_image($alt_image_token); 
        } elseif (!$this_robot->has_ability('crystal-frag') 
            && $this_robot->robot_image === $alt_image_token){
            $this_robot->set_image($base_image_token); 
        }

        // Return true on success
        return true;

    },
    'robot_function_onbattlestart' => function($objects){

        // Extract all objects into the current scope
        extract($objects);
        
        // Generate crystal blockade at battle start if signature ability equipped
        if ($this_robot->has_skill('custom-skill')
            && $this_robot->has_ability('crystal-frag')){

            // Define this ability's attachment token and info
            $attachment_key = 0;
            $attachment_ability = 'crystal-frag';
            $attachment_object = 'crystal-frag';
            $this_attachment_info = rpg_ability::get_static_attachment($attachment_ability, $attachment_object, $attachment_key);
            $this_attachment_token = $this_attachment_info['attachment_token'];

            // Check if the attachment exists yet, and if not add it now
            $attachment_already_exists = $this_robot->has_attachment($this_attachment_token);
            if (!$attachment_already_exists){
                //$this_battle->events_create(false, false, 'debug', 'onbattlestart');
                $this_robot->set_attachment($this_attachment_token, $this_attachment_info);
                if ($this_robot->robot_position === 'active'){
                	$this_robot->set_frame('summon');
                    $this_battle->events_create(false, false, '', '',
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
        
        }

        // Return true on success
        return true;

    },
    'robot_function_onendofturn' => function($objects){

        // Extract all objects into the current scope
        extract($objects);
        
        // Generate crystal blockade at end of turn if signature ability equipped
        if ($this_robot->has_skill('custom-skill')
            && $this_robot->has_ability('crystal-frag')){

            // Define this ability's attachment token and info
            $attachment_key = 0;
            $attachment_ability = 'crystal-frag';
            $attachment_object = 'crystal-frag';
            $this_attachment_info = rpg_ability::get_static_attachment($attachment_ability, $attachment_object, $attachment_key);
            $this_attachment_token = $this_attachment_info['attachment_token'];

            // Check if the attachment exists yet, and if not add it now
            $attachment_already_exists = $this_robot->has_attachment($this_attachment_token);
            if (!$attachment_already_exists){
                //$this_battle->events_create(false, false, 'debug', 'onendofturn');
                $this_robot->set_attachment($this_attachment_token, $this_attachment_info);
                if ($this_robot->robot_position === 'active'){
                	$this_robot->set_frame('summon');
                    $this_battle->events_create(false, false, '', '',
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
        
        }

        // Return true on success
        return true;

    },
    'rpg-skill_disable-skill_before' => function($objects){

        // Extract all objects into the current scope
        extract($objects);

        // If the robot has the attachment, we need to remove it
        $attachment_key = 0;
        $attachment_ability = 'crystal-frag';
        $attachment_object = 'crystal-frag';
        $this_attachment_info = rpg_ability::get_static_attachment($attachment_ability, $attachment_object, $attachment_key);
        $this_attachment_token = $this_attachment_info['attachment_token'];
        if ($this_robot->has_attachment($this_attachment_token)){
            $this_robot->unset_attachment($this_attachment_token);
        }

        // If this robot has the signature ability equipped, update the sprite image
        $base_image_token = $this_robot->robot_token;
        $alt_image_token = $this_robot->robot_token.'_alt';
        if ($this_robot->robot_image === $alt_image_token){
            $this_robot->set_image($base_image_token);
        }

        // Return true on success
        return true;

    }
);
?>
