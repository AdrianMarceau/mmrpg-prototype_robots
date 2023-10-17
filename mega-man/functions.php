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
                    $this_robot->set_quote('battle_victory', 'Hey Bass, um.. Don\'t you ever get tired of losing?');
                    break;
                }
                case 'proto-man': {
                    $this_robot->set_quote('battle_victory', ' I\’m guessing you\'re not really planning on giving me your shield this time, huh?');
                    break;
                }
                case 'roll': {
                    $this_robot->set_quote('battle_victory', 'Roll, you\'ve gotten so strong.. I\'m glad you\'ve always got my back!');
                    break;
                }
                case 'enker': {
                    $this_robot->set_quote('battle_victory', 'Enker.. You\’re so much more than your purpose. Don\’t you understand that?');
                    break;
                }
                case 'doc-robot': {
                    $this_robot->set_quote('battle_victory', 'Man.. That\'s a face that gives me bad memories.');
                    break;
                }
                case 'king': {
                    $this_robot->set_quote('battle_victory', 'I\'m sorry, King... This isn\'t what you deserve.');
                    break;
                }
                case 'buster-rod-g': {
                    $this_robot->set_quote('battle_victory', 'Hey, stop, we don\'t have time for this! We\'re trying to save the world, man!');
                    break;
                }
                case 'terra': {
                    $this_robot->set_quote('battle_victory', 'With my family by my side.. I\'ll never lose to you again, Terra!');
                    break;
                }
                case 'terra': {
                    $this_robot->set_quote('battle_victory', 'Slur.. what are you fighting for? What is all this destruction worth?');
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
