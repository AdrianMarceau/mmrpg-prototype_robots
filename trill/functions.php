<?
$functions = array(
    'robot_function' => function($objects){

        // Extract all objects into the current scope
        extract($objects);

        // Return true on success
        return true;

    },
    'robot_function_onendofturn' => function($objects){

        // Extract all objects into the current scope
        extract($objects);
        
        // Define the list of stats and their associated alt images
        $stats_to_alts = array(
            'energy' => '', 
            'attack' => '_alt', 
            'defense' => '_alt2', 
            'speed' => '_alt3'
        		);
        
        // Collect the robot's stats and rank them so we know which alt to use
				$ranked_stats = array(
            'energy' => $this_robot->robot_energy, 
            'attack' => $this_robot->robot_attack, 
            'defense' => $this_robot->robot_defense, 
            'speed' => $this_robot->robot_speed
        		);       
        asort($ranked_stats);
        $ranked_stats = array_reverse($ranked_stats, true);
        $max_value = reset($ranked_stats);
        $best_stats = array();
        foreach($ranked_stats as $stat => $value){
            if ($value == $max_value){ $best_stats[] = $stat; } 
            else { break; }
        }
				$best_stat = $best_stats[array_rand($best_stats)];
        $best_stat_alt_token = $stats_to_alts[$best_stat];
        
        // Define the new image given the best stat and update if necessary
        $current_image = $this_robot->robot_image;
        $required_image = $this_robot->robot_token.$best_stat_alt_token;
        if ($current_image !== $required_image){
            $event_options = array(
            	'event_flag_camera_action' => true,
            	'event_flag_camera_side' => $this_player->player_side,
            	'event_flag_camera_focus' => $this_robot->robot_position,
            	'event_flag_camera_depth' => $this_robot->robot_key
            	);
            $this_robot->set_frame('summon');
            $this_battle->events_create(false, false, '', '', $event_options);
            $this_robot->set_frame('defend');
        	  $this_robot->set_image($required_image);
            $this_battle->events_create(false, false, '', '', $event_options);
            $this_robot->reset_frame();
        }
        
        // Return true on success
        return true;

    }
);
?>
