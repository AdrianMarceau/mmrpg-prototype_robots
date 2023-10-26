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
                case 'mega-man': {
                    $this_robot->set_quote('battle_victory', 'Sorry, bro - that\’s how I rock\’n\’roll!');
                    break;
                }
                case 'bass': {
                    $this_robot->set_quote('battle_victory', 'HAH! Winning battles is my forte!... Why are you not laughing?');
                    break;
                }
                case 'guts-man': {
                    $this_robot->set_quote('battle_victory', 'Don\'t plan your strategy around rock-paper-scissors, bro!');
                    break;
                }
                case 'metal-man': {
                    $this_robot->set_quote('battle_victory', 'How can you be my improvement when your puns aren\’t even funny?');
                    break;
                }
                case 'blade-man': {
                    $this_robot->set_quote('battle_victory', 'Man.. I\’m getting old, huh? ');
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
