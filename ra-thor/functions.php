<?
$functions = array(
    'robot_function' => function($objects){

        // Extract all objects into the current scope
        extract($objects);

        // Return true on success
        return true;

    },
    'robot_function_onability' => function($objects){

        // Extract all objects into the current scope
        extract($objects);

        // Define a quick function for returning if a given we have the necessary weapon energy for an ability
        $this_robot_info = $this_robot->export_array();
        $has_weapon_energy = function($ability_token) use ($this_battle, $this_player, $this_robot, $this_robot_info){
            $temp_ability_info = rpg_ability::get_index_info($ability_token);
            $temp_required_energy = rpg_robot::calculate_weapon_energy_static($this_robot_info, $temp_ability_info);
            return $this_robot->robot_weapons >= $temp_required_energy;
            };

        // If we don't have a Ra Mini-Moon but we do have Lunar Memory A, we should use the ability to summon one
        $possible_ability_token = 'lunar-memory';
        $static_attachment_key = $this_robot->get_static_attachment_key();
        $this_attachment_info = rpg_ability::get_static_attachment($possible_ability_token, $possible_ability_token, $static_attachment_key);
        $this_attachment_token = $this_attachment_info['attachment_token'];
        $attachment_already_exists = $this_battle->has_attachment($static_attachment_key, $this_attachment_token);
        if (!$attachment_already_exists
            && $this_robot->has_ability($possible_ability_token)
            && $has_weapon_energy($possible_ability_token)
            ){
            return $possible_ability_token;
            }

        // If we need healing and we have Shield Eater R, we should use the ability to absorb shields for healing
        $possible_ability_token = 'shield-eater';
        if ($this_robot->robot_energy < $this_robot->robot_base_energy
            && $this_robot->has_ability($possible_ability_token)
            && $has_weapon_energy($possible_ability_token)
            ){
            return $possible_ability_token;
            }

        // Otherwise, if we have the option to attack with our signature move, we should
        $possible_ability_token = 'barrier-drive';
        if ($this_robot->has_ability($possible_ability_token)
            && $has_weapon_energy($possible_ability_token)
            ){
            return $possible_ability_token;
            }

        // Otherwise if we need to recharge our weapons and we can we should do that
        $possible_ability_token = 'buster-charge';
        if ($this_robot->has_ability($possible_ability_token)
            && $this_robot->robot_weapons < ($this_robot->robot_base_weapons / 3)
            ){
            return $possible_ability_token;
            }

        // Otherwise return empty to allow normal ability logic
        return '';

    },
    'robot_function_onbattlestart' => function($objects){

        // Extract all objects into the current scope
        extract($objects);

        // Generate moon blockade at battle start if signature ability equipped
        if ($this_robot->has_ability('lunar-memory')){

            // Define this ability's attachment token and info
            $static_attachment_key = $this_robot->get_static_attachment_key();
            $this_attachment_info = rpg_ability::get_static_attachment('lunar-memory', 'lunar-memory', $static_attachment_key);
            $this_attachment_token = $this_attachment_info['attachment_token'];

            // If this robot already has a super block in place, make sure we adjust the position a bit
            if ($this_battle->has_attachment($static_attachment_key, 'ability_super-arm_super-block_'.$static_attachment_key)){
                $this_attachment_info['ability_frame_offset']['x'] += 12;
            }

            // Check if the attachment exists yet, and if not add it now
            $attachment_already_exists = $this_battle->has_attachment($static_attachment_key, $this_attachment_token);
            if (!$attachment_already_exists){
                //$this_battle->events_create(false, false, 'debug', 'onbattlestart');
                $this_battle->set_attachment($static_attachment_key, $this_attachment_token, $this_attachment_info);
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

    }
);
?>
