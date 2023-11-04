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
                case 'punk': {
                    $this_robot->set_quote('battle_victory', 'If there\’s something you gotta know, it\’s that I steer clear of reckless little punks!');
                    break;
                }
                case 'burst-man': {
                    $this_robot->set_quote('battle_victory', 'You and those stupid soapy bombs, always have to watch not to slip and crash on ‘em..');
                    break;
                }
                case 'quick-man': {
                    $this_robot->set_quote('battle_victory', 'Gotta admit, you\’ve always been good at racing! Now, battling, that\’s a different story..');
                    break;
                }
                case 'nitro-man': {
                    $this_robot->set_quote('battle_victory', 'A \‘bot who can transform into a vehicle….Yeah, that\’s awfully original.');
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
