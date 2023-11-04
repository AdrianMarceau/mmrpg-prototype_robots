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
                case 'proto-man': {
                    $this_robot->set_quote('battle_victory', 'Hehehe.. I\’d divine your future, but your fate is obvious.');
                    break;
                }
                case 'bright-man': {
                    $this_robot->set_quote('battle_victory', 'Curse you and your high-and-mighty science! If people want to give me money, let them!');
                    break;
                }
                case 'freeze-man': {
                    $this_robot->set_quote('battle_victory', 'If you weren\’t so fixated on your stupid sentai poses, you would\’ve made such a great apprentice.');
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
