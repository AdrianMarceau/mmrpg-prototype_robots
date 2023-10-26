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
                    $this_robot->set_quote('battle_victory', ' Shame, your fighting is just as dull as that whistle composition of yours.');
                    break;
                }
                case 'guts-man': {
                    $this_robot->set_quote('battle_victory', 'Y-You...You have the voice of an angel! Please! I beg you to sing in one of my pieces!');
                    break;
                }
                case 'spring-man': {
                    $this_robot->set_quote('battle_victory', 'Your hopping was amazing! I think it\’d be best if I took a few notes…');
                    break;
                }
                case 'snake-man': {
                    $this_robot->set_quote('battle_victory', 'AHHH! GET THIS GUY AWAY FROM ME ALREADY!');
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
