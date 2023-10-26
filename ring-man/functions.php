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
                    $this_robot->set_quote('battle_victory', 'Face it, bomber: you were always destined to lose to me!');
                    break;
                }
                case 'proto-man': {
                    $this_robot->set_quote('battle_victory', 'From the minute you were born, fate decided your life was forfeit, Proto Man.');
                    break;
                }
                case 'skull-man': {
                    $this_robot->set_quote('battle_victory', 'Your skill means nothing when fate is on your side!');
                    break;
                }
                case 'saturn': {
                    $this_robot->set_quote('battle_victory', 'For such a bad guy.. your fashion style\'s not that bad.');
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
