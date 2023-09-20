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

    }
);
?>
