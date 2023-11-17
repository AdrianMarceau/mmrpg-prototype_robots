<?
$functions = array(
    'robot_function' => function($objects){

        // Extract all objects into the current scope
        extract($objects);

        // Return true on success
        return true;

    },
    'rpg-ability_trigger-damage_after' => function($objects){
        //error_log('rpg-ability_trigger-damage_after() for '.$objects['this_robot']->robot_string);

        // Extract all objects into the current scope
        extract($objects);

        // Check to make sure the robot's second form can activate
        $trigger_second_form = false;
        //error_log('$this_robot->robot_energy = '.print_r($this_robot->robot_energy, true));
        //error_log('$this_robot->robot_base_energy = '.print_r($this_robot->robot_base_energy, true));
        if ($this_robot->robot_energy <= ($this_robot->robot_base_energy / 2)
            && $this_robot->robot_image === $this_robot->robot_token){
            $trigger_second_form = true;
        }
        //error_log('$trigger_second_form = '.($trigger_second_form ? 'true' : 'false'));

        // If this robot is at low energy and has not transformed yet
        if ($trigger_second_form){

            // Set the robot's image to its second form
            $new_robot_image = $this_robot->robot_token.'_alt';
            $this_robot->set_image($new_robot_image);
            $this_robot->set_base_image($new_robot_image);
            //error_log('transforming '.$this_robot->robot_string.' into '.$this_robot->robot_token);

            // Restore the robot's energy to max and double its base energy
            $double_stats = array('energy', 'attack', 'defense', 'speed');
            foreach ($double_stats AS $stat_key => $stat_token){
                //error_log('double '.$this_robot->robot_string.' '.$stat_token.' stats');
                $stat_prop_name = 'robot_'.$stat_token;
                $stat_prop_base_name = 'robot_base_'.$stat_token;
                $stat_prop_backup_name = $stat_prop_base_name.'_backup';
                $func_name = 'set_'.$stat_token;
                $base_func_name = 'set_base_'.$stat_token;
                //error_log('$stat_prop_name = '.print_r($stat_prop_name, true));
                //error_log('$stat_prop_base_name = '.print_r($stat_prop_base_name, true));
                //error_log('$stat_prop_backup_name = '.print_r($stat_prop_backup_name, true));
                //error_log('$func_name = '.print_r($func_name, true));
                //error_log('$base_func_name = '.print_r($base_func_name, true));
                $new_stat_value = $this_robot->$stat_prop_base_name * 2;
                //error_log('$this_robot->'.$stat_prop_base_name.' = '.print_r($this_robot->$stat_prop_base_name, true));
                //error_log('$new_stat_value = '.print_r($new_stat_value, true));
                $this_robot->set_value($stat_prop_backup_name, $new_stat_value);
                $this_robot->$func_name($new_stat_value);
                $this_robot->$base_func_name($new_stat_value);
                //error_log('$this_robot->'.$stat_prop_name.' = '.print_r($this_robot->$stat_prop_name, true));
            }

        }


        // Return true on success
        return true;

    },
);
?>
