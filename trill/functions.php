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

        // Check to see which battle strategy we should use
        $battle_strategy = $this_robot->robot_energy < $this_robot->robot_base_energy ? 'offensive' : 'defensive';

        // If the robot has NOT taken damage, we will not use offensive moves
        if ($battle_strategy === 'offensive'){

            // return empty to allow normal ability logic
            return '';

        } elseif ($battle_strategy === 'defensive'){

            // manually define which abilities are allowed (start with global support)
            $allowed_abilities = array();
            $allowed_abilities = array_merge($allowed_abilities, rpg_ability::get_global_support_abilities());
            return $allowed_abilities;

        }

        // Return true on success
        return true;

    },
    'robot_function_onstatchange' => function($objects, $show_event = true){

        // Extract all objects into the current scope
        extract($objects);

        // If this robot's base image is already an alt, this will not trigger
        if (strstr($this_robot->robot_base_image, '_')){ return false; }

        // Define the list of stats and their associated alt images
        $stats_to_alts = array(
            'energy' => '',
            'attack' => '_alt',
            'defense' => '_alt2',
            'speed' => '_alt3'
            );

        // Gather the robot's stats
        $best_stat = 'energy';
        $other_stats = array(
            'attack' => $this_robot->robot_attack,
            'defense' => $this_robot->robot_defense,
            'speed' => $this_robot->robot_speed
            );

        // Calculate the maximum value among the stats
        $max_value = max($other_stats);

        // Manually count how many times the max value occurs. If it only occurs once, it's a definitive highest stat
        $max_value_count = 0;
        foreach ($other_stats as $stat_value){ if ($stat_value === $max_value){ $max_value_count++; } }
        if ($max_value_count === 1) { $best_stat = array_search($max_value, $other_stats); }
        $best_stat_alt_token = $stats_to_alts[$best_stat];

        // Define the new image given the best stat and update if necessary
        $current_image = $this_robot->robot_image;
        $required_image = $this_robot->robot_pseudo_token.$best_stat_alt_token;
        if ($current_image !== $required_image){
            if ($show_event){
                $event_options = array(
                    'event_flag_camera_action' => true,
                    'event_flag_camera_side' => $this_player->player_side,
                    'event_flag_camera_focus' => $this_robot->robot_position,
                    'event_flag_camera_depth' => $this_robot->robot_key
                    );
                $this_robot->set_frame('summon');
                $this_battle->events_create(false, false, '', '', $event_options);
                $this_battle->queue_sound_effect('beeping-sound');
                $this_robot->set_frame('defend');
                $this_robot->set_image($required_image);
                $this_battle->events_create(false, false, '', '', $event_options);
                $this_robot->reset_frame();
            } else {
                $this_robot->set_image($required_image);
            }
        }

        // Return true on success
        return true;

    }
);
$functions['robot_function_onbattlestart'] = function($objects) use ($functions){
    return $functions['robot_function_onstatchange']($objects, true);
};
$functions['robot_function_onendofturn'] = function($objects) use ($functions){
    return $functions['robot_function_onstatchange']($objects, true);
};
$functions['rpg-ability_stat-boost_after'] = function($objects) use ($functions){
    return $functions['robot_function_onstatchange']($objects, false);
};
$functions['rpg-ability_stat-break_after'] = function($objects) use ($functions){
    return $functions['robot_function_onstatchange']($objects, false);
};
?>
