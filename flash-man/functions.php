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

        // Collect the context variable for the battle for reference
        $context = $this_battle->values['context']; // player, chapter, phase, etc.

        // Return true on success
        return true;

    },
    'robot_function_ontargetchange' => function($objects){

        // Extract all objects into the current scope
        extract($objects);

        // Update this robot's taunt quote based on the robot being faced
        $target_robot_info = rpg_robot::get_index_info($target_robot->robot_token);

        // Otherwise if this is ANY OTHER TIME we can define our quotes based on specific characters
        if (true) {
            switch ($target_robot->robot_token){
                case 'bass': {
                    $this_robot->set_quote('battle_victory', ' I should let you stay frozen forever - you\’d be more useful to Wily, that way.');
                    break;
                }
                case 'quick-man': {
                    $this_robot->set_quote('battle_victory', 'Your speed means nothing if it\’s time you\’re running from!');
                    break;
                }
                case 'time-man': {
                    $this_robot->set_quote('battle_victory', 'Don’t lecture ME on the importance of time!');
                    break;
                }
                case 'star-man': {
                    $this_robot->set_quote('battle_victory', 'Please, please, I\’ll take any role you have in your films! I\’ll do anything! I\’ll even wear a wig!');
                    break;
                }
                case 'terra': {
                    $this_robot->set_quote('battle_victory', 'GIVE ME YOUR HAIR!');
                    break;
                }
            }
        }

        // Return true on success
        return true;

    }
);
$functions['robot_function_onturnstart'] = function($objects) use ($functions){
    //error_log('onturnstart for robot w/ target '.$objects['target_robot']->robot_string);
    return $functions['robot_function_ontargetchange']($objects, true);
};
?>
