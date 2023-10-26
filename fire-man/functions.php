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
                    $this_robot->set_quote('battle_victory', 'Now, where\’s your fire?! You used to burn so much brighter!!');
                    break;
                }
                case 'bomb-man': {
                    $this_robot->set_quote('battle_victory', 'There\'s no games to playin\’ with fire, pal. You gotta use it responsibly.');
                    break;
                }
                case 'heat-man': {
                    $this_robot->set_quote('battle_victory', 'You ain\’t got no fire in your flames! Burn passionately and your flames will do the same!');
                    break;
                }
                case 'pharaoh-man': {
                    $this_robot->set_quote('battle_victory', 'Ain’t no point taking heat from the sun when the strongest fires come from your soul!');
                    break;
                }
                case 'toad-man': {
                    $this_robot->set_quote('battle_victory', 'There ain\'t a rain out there that can put out my fire!!');
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
