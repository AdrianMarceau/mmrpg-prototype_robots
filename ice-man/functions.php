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
                    $this_robot->set_quote('battle_victory', 'Hey-hey, I beat Mega Man! Would you guys believe it?');
                    break;
                }
                case 'roll': {
                    $this_robot->set_quote('battle_victory', 'Ooo! Roll, I\’m sorry - I didn’t mean to hurt you!');
                    break;
                }
                case 'heat-man': {
                    $this_robot->set_quote('battle_victory', 'Can you leave now? You\’re making my parka stuffy.');
                    break;
                }
                case 'freeze-man': {
                    $this_robot->set_quote('battle_victory', 'I appreciate the attention, really, though you can slow it down with the fan mail… ');
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
