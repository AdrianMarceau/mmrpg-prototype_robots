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
                case 'gemini-man': {
                    $this_robot->set_quote('battle_victory', 'Nice shooting, Gemini! But, uh, let me give it a whirl next time?');
                    break;
                }
                case 'tengu-man': {
                    $this_robot->set_quote('battle_victory', 'Oh, so high and mighty with your stupid jet engine! WELL, PROPELLERS ARE COOL TOO!!!');
                    break;
                }
                case 'jupiter': {
                    $this_robot->set_quote('battle_victory', 'Propeller scum, am I? If it means being like you - then I\’m proud of my propeller! ');
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
