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
                    $this_robot->set_quote('battle_victory', 'Hey dude, I don\’t care about Slur or whatever! It\’s my union break!');
                    break;
                }
                case 'crash-man': {
                    $this_robot->set_quote('battle_victory', '“Similar design” or not, there\’s a difference between haphazard destruction and hard work!');
                    break;
                }
                case 'stone-man': {
                    $this_robot->set_quote('battle_victory', 'I\'ve broken through all sorts of rocks; a robot made of it is nothing but child\’s play!');
                    break;
                }
                case 'time-man': {
                    $this_robot->set_quote('battle_victory', 'Quit worrying about your schedules or whatever! The trick to free time is to just rush everything!');
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
