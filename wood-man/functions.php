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
                    $this_robot->set_quote('battle_victory', 'All you care for is violence. You don\’t belong in this beautiful world.');
                    break;
                }
                case 'cut-man': {
                    $this_robot->set_quote('battle_victory', 'That\’s what you get for trying to cut down my friends!');
                    break;
                }
                case 'burner-man': {
                    $this_robot->set_quote('battle_victory', 'And don\’t try to bring your flames near my forest again!');
                    break;
                }
                case 'slash-man': {
                    $this_robot->set_quote('battle_victory', 'I suppose.. even crude, wild creatures like yourself are worth protecting as part of nature.');
                    break;
                }
                case 'plant-man': {
                    $this_robot->set_quote('battle_victory', 'That was excruciating! I don\’t like hurting plants, even if it\’s the awful-smelling Rafflesia!');
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
