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

        // Update this robot's quotes to be more dynamic with the battle context
        $start_quote = "You've only found that many robots? I already have more!";
        $taunt_quote = "Don't just stand there! Attack me with all you've got!";
        $victory_quote = "Wonderful! I can't wait to add you to my collection!";
        $defeat_quote = "I can't believe I lost to a robot like you!";
        if ($this_robot->player->player_side === 'right'
            && !empty($this_battle->values['battle_players']['this_player'])){
            $human_player_info = $this_battle->values['battle_players']['this_player'];
            $human_robots_unlocked = mmrpg_prototype_robots_unlocked($human_player_info['player_token']);
            $human_robots_unlocked_text = $human_robots_unlocked.' '.($human_robots_unlocked === 1 ? 'robot' : 'robots');
            $start_quote = 'You\'ve only collected '.$human_robots_unlocked_text.' so far? I own an army compared to you!';
        }
        $this_robot->set_quote('battle_start', $start_quote);
        $this_robot->set_quote('battle_taunt', $taunt_quote);
        $this_robot->set_quote('battle_victory', $victory_quote);
        $this_robot->set_quote('battle_defeat', $defeat_quote);

        // Return true on success
        return true;

    },
    'robot_function_onability' => function($objects){

        // Extract all objects into the current scope
        extract($objects);
        //error_log($this_robot->robot_token.' robot_function_onability()');

        // Collect the target robot's weaknesses and a list of this robot's current abilities
        $target_weaknesses = $target_robot->robot_weaknesses;
        $this_abilities = $this_robot->robot_abilities;
        //error_log($this_robot->robot_token.' vs. '.$target_robot->robot_token);
        //error_log(' - '.$this_robot->robot_name.'\'s abilities: '.print_r($this_abilities, true));
        //error_log(' - '.$target_robot->robot_name.'\'s weaknesses: '.print_r($target_weaknesses, true));

        // Loop through this robot's abilities, collect info, and then check if either type matches either of the target's weaknesses
        $filtered_abilities = array();
        foreach ($this_abilities AS $ability_token){
            $ability_info = rpg_ability::get_index_info($ability_token);
            $ability_is_weakness = false;
            if (!empty($ability_info['ability_type']) && in_array($ability_info['ability_type'], $target_weaknesses)){ $ability_is_weakness = true; }
            if (!empty($ability_info['ability_type2']) && in_array($ability_info['ability_type2'], $target_weaknesses)){ $ability_is_weakness = true; }
            if ($ability_is_weakness){
                $filtered_abilities[] = $ability_token;
                break;
            }
        }

        // If matching abilities were found change this robot's focus to active
        $this_robot->values['robot_focus'] = 'auto';
        $this_robot->values['robot_focus_targets'] = array();
        if (!empty($filtered_abilities)){
            //error_log('$filtered_abilities[0] = '.print_r($filtered_abilities[0], true));
            $temp_ability_info = rpg_ability::get_index_info($filtered_abilities[0]);
            $temp_robot_focus = $target_robot->robot_position;
            $temp_robot_focus_targets[] = $target_robot->robot_id;
            $other_active_robots = $target_player->get_robots_active();
            foreach ($other_active_robots AS $key => $robot){
                if (!empty($temp_ability_info['ability_type'])
                    && $robot->has_weakness($temp_ability_info['ability_type'])){
                    $temp_robot_focus_targets[] = $robot->robot_id;
                    //error_log('-> '.$robot->robot_string.' is weak to '.$temp_ability_info['ability_type']);
                }
                if (!empty($temp_ability_info['ability_type2'])
                    && $robot->has_weakness($temp_ability_info['ability_type2'])){
                    $temp_robot_focus_targets[] = $robot->robot_id;
                    //error_log('-> '.$robot->robot_string.' is weak to '.$temp_ability_info['ability_type2']);
                }
            }
            $temp_robot_focus_targets = array_unique($temp_robot_focus_targets);
            if (count($temp_robot_focus_targets) > 1){ $temp_robot_focus = 'auto'; }
            $this_robot->values['robot_focus'] = $temp_robot_focus;
            $this_robot->values['robot_focus_targets'] = $temp_robot_focus_targets;
            //error_log('$temp_robot_focus = '.print_r($temp_robot_focus, true));
            //error_log('$temp_robot_focus_targets = '.print_r($temp_robot_focus_targets, true));
        }

        // If matching abilities were found we can return them, otherwise allow normal selection logic
        $return_abilities = !empty($filtered_abilities) ? $filtered_abilities : '';
        // If there was nothing to return, maybe recovery weapon energy via a forced Buster Charge
        if (empty($return_abilities) && $this_robot->robot_weapons < ($this_robot->robot_base_weapons / 2)){ $return_abilities = 'buster-charge'; }

        // If matching abilities were found return them, otherwise allow normal selection logic
        return $return_abilities;

    }
);
?>
