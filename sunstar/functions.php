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
                    $this_robot->set_quote('battle_victory', '.. Mega Man. Know that this is the only peace I can give you.');
                    break;
                }
                case 'pharaoh-man': {
                    $this_robot->set_quote('battle_victory', 'I acknowledge your tribute - and so you shall die first.');
                    break;
                }
                case 'duo': {
                    $this_robot->set_quote('battle_victory', 'There is no justice. No chaos. Only light – then eternal nothingness. ');
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
