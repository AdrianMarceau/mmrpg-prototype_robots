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
        $is_damaged = $this_robot->robot_energy < $this_robot->robot_base_energy ? true : false;
        $is_still_alive = $this_robot->robot_energy > 0 && $this_robot->robot_status !== 'disabled' ? true : false;
        $has_weapon_energy = $this_robot->robot_weapons >= ($this_robot->robot_base_weapons / 3) ? true : false;
        //error_log('$is_damaged = '.($is_damaged ? 'true' : 'false'));
        //error_log('$is_still_alive = '.($is_still_alive ? 'true' : 'false'));
        //error_log('$has_weapon_energy = '.($has_weapon_energy ? 'true' : 'false'));

        // If the robot is disabled we can't do anything
        if (!$is_still_alive){ return false; }

        // If the robot has been damaged at all, we can automatically heal it back to full
        $new_abilities = array();
        if ($is_damaged && $is_still_alive && $has_weapon_energy){
            // Change this robot's list of abilities to only overdrives
            $types = rpg_type::get_index();
            foreach ($types AS $type){
                if ($type['type_token'] === 'copy'){ continue; }
                if ($type['type_class'] !== 'normal'){ continue; }
                $new_abilities[] = $type['type_token'].'-overdrive';
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
