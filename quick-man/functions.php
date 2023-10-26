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
                    $this_robot->set_quote('battle_victory', 'And you think you\’re the one to kill Mega Man? Hilarious.');
                    break;
                }
                case 'mega-man': {
                    $this_robot->set_quote('battle_victory', 'Versatility, adaptability, strategy… Those mean nothing if you can\'t keep up with your opponent, blue boy!');
                    break;
                }
                case 'turbo-man': {
                    $this_robot->set_quote('battle_victory', 'Turbo Man! How about we go for a quick race sometime?');
                    break;
                }
                case 'nitro-man': {
                    $this_robot->set_quote('battle_victory', 'You’re a lot like Turbo Man... Clearly not as fast, though.');
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
