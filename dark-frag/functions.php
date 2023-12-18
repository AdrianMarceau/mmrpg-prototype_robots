<?
$functions = array(
    'robot_function' => function($objects){

        // Extract all objects into the current scope
        extract($objects);

        // Return true on success
        return true;

    },
    'robot_function_ondamage' => function($objects){
        //error_log('robot_function_ondamage() for '.$objects['this_robot']->robot_string);

        // Extract all objects into the current scope
        extract($objects);

        // Check if the robot has been damaged at all
        $is_badly_damaged = $this_robot->robot_energy <= ($this_robot->robot_base_energy / 3) ? true : false;
        $is_still_alive = $this_robot->robot_energy > 0 && $this_robot->robot_status !== 'disabled' ? true : false;
        $has_weapon_energy = $this_robot->robot_weapons >= ($this_robot->robot_base_weapons / 3) ? true : false;
        //error_log('$is_badly_damaged = '.($is_badly_damaged ? 'true' : 'false'));
        //error_log('$is_still_alive = '.($is_still_alive ? 'true' : 'false'));
        //error_log('$has_weapon_energy = '.($has_weapon_energy ? 'true' : 'false'));

        // If the robot is disabled we can't do anything
        if (!$is_still_alive){ return false; }

        // If the robot has been damaged at all, we can automatically heal it back to full
        $new_abilities = array();
        $base_abilities = $this_robot->get_abilities();
        //error_log('$base_abilities = '.print_r($base_abilities, true));
        if ($is_badly_damaged && $is_still_alive && $has_weapon_energy){
            // Change this robot's list of abilities to only overdrives
            $types = rpg_type::get_index();
            foreach ($types AS $type){
                if ($type['type_token'] === 'copy'){ continue; }
                if ($type['type_class'] !== 'normal'){ continue; }
                $new_abilities[] = $type['type_token'].'-overdrive';
            }
            shuffle($new_abilities);
            $new_abilities = array_slice($new_abilities, 0, MMRPG_SETTINGS_BATTLEABILITIES_PERROBOT_MAX);
            // If the original ability set had "copy-style", make sure we only replace those AFTER copy style
            if (!empty($base_abilities)){
                //error_log('has base abilities');
                $copy_style_index = array_search('copy-style', $base_abilities);
                //error_log('$copy_style_index = '.$copy_style_index);
                if ($copy_style_index !== false){
                    //error_log('has copy style');
                    $keep_base_abilities = array_slice($base_abilities, 0, $copy_style_index + 1);
                    //error_log('$keep_base_abilities = '.print_r($keep_base_abilities, true));
                    $new_abilities = array_values(array_merge($keep_base_abilities, $new_abilities));
                    $new_abilities = array_slice($new_abilities, 0, MMRPG_SETTINGS_BATTLEABILITIES_PERROBOT_MAX);
                    //error_log('$new_abilities = '.print_r($new_abilities, true));
                }
            }
        } else {
            // Change this robot's list of abilities to only charge
            $new_abilities = $this_robot->get_base_abilities();
        }
        //error_log('$new_abilities = '.print_r($new_abilities, true));
        if (!empty($new_abilities)){
            $this_robot->set_abilities($new_abilities);
            //error_log('$this_robot->get_abilities() = '.print_r($this_robot->get_abilities(), true));
        }

        // Return true on success
        return true;

    }
);
?>
