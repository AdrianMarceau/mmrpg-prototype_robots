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
                    $this_robot->set_quote('battle_victory', 'Surely you knew about my extraordinary mastery over flames, but nobody ever foresees my prowess in close combat!');
                    break;
                }
                case 'proto-man': {
                    $this_robot->set_quote('battle_victory', 'Your time has run out - the sand claims all things.');
                    break;
                }
                case 'drill-man': {
                    $this_robot->set_quote('battle_victory', 'You need to learn some patience, Drill Man, during both excavations and combat!');
                    break;
                }
                case 'king': {
                    $this_robot->set_quote('battle_victory', 'You may be a king, but I am a pharaoh!');
                    break;
                }
                case 'splash-woman': {
                    $this_robot->set_quote('battle_victory', 'I-I\’m terribly sorry about all this. Would you allow me to make it up to you, my desert rose?');
                    break;
                }
                case 'solar-man': {
                    $this_robot->set_quote('battle_victory', 'The sun is not simply ours to use - every ray of light is a precious blessing.');
                    break;
                }
                case 'sunstar': {
                    $this_robot->set_quote('battle_victory', 'Alas, it cannot be! The very Sun God himself!');
                    break;
                }
                case 'commando-man': {
                    $this_robot->set_quote('battle_victory', 'You use the sands to host your weapons, but the desert belongs to me!');
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
