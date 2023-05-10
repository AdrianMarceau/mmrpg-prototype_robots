<?
$functions = array(
    'robot_function' => function($objects){

        // Extract all objects into the current scope
        extract($objects);

        // Return true on success
        return true;

    },
    'robot_function_ondamage' => function($objects){

        // Extract all objects into the current scope
        extract($objects);

        // Check if the robot has been damaged at all
        $is_damaged = $this_robot->robot_energy < $this_robot->robot_base_energy ? true : false;
        $is_still_alive = $this_robot->robot_energy > 0 && $this_robot->robot_status !== 'disabled' ? true : false;
        
        // If the robot has been damaged at all, we can automatically heal it back to full
        if ($is_damaged && $is_still_alive){
            
            // Do the windup animation for the recovery
            $this_robot->set_frame('base2');
            $this_battle->events_create(false, false, '', '');            
            $this_robot->set_frame('defend');
            $this_battle->events_create($this_robot, false, 
							$this_robot->print_name_s().' Skill', 
              'The '.$this_robot->print_name().' pulls itself back together&hellip;'
              );

            // Increase this robot's life energy stat
            $this_skill = $this_robot->get_skill_object(null);
            $this_skill->recovery_options_update(array(
                'kind' => 'energy',
                'percent' => true,
                'modifiers' => false,
                'frame' => 'taunt',
                'success' => array(9, 0, 0, -9999, $this_robot->print_name_s().' life energy was restored!'),
                'failure' => array(9, 0, 0, -9999, $this_robot->print_name_s().' life energy was not affected&hellip;')
                ));
            $energy_recovery_amount = ceil($this_robot->robot_base_energy - $this_robot->robot_energy);
            $this_robot->trigger_recovery($this_robot, $this_skill, $energy_recovery_amount);
            
        }

        // Return true on success
        return true;

    }
);
?>
