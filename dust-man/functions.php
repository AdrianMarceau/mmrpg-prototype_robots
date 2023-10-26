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
                    $this_robot->set_quote('battle_victory', 'Oh… Proto Man. I\’m sorry it came to this.');
                    break;
                }
                case 'roll': {
                    $this_robot->set_quote('battle_victory', 'You’re a cleaning robot, too? Your face looks kinda weird..');
                    break;
                }
                case 'plant-man': {
                    $this_robot->set_quote('battle_victory', 'AhhCHOOOO!! Pollen season gets worse and worse every year… ');
                    break;
                }
                case 'junk-man': {
                    $this_robot->set_quote('battle_victory', 'Please don\’t get offended when I say this but… You\’re trash.');
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
