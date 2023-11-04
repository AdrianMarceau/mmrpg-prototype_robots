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
                    $this_robot->set_quote('battle_victory', 'Earth\’s champion, I have repaid the wounds you dealt me a thousand times over!');
                    break;
                }
                case 'disco': {
                    $this_robot->set_quote('battle_victory', '... Hmph. Nice hair.');
                    break;
                }
                case 'shadow-man': {
                    $this_robot->set_quote('battle_victory', 'Mingling with the Earthlings will mark your fate the same as theirs: DESTRUCTION!');
                    break;
                }
                case 'duo': {
                    $this_robot->set_quote('battle_victory', 'Star Marshal! May this repay the blood debt owed to the master Ra Moon!');
                    $this_robot->set_quote('battle_defeat', 'Heed my message, Duo. The great Sunstar is coming for this world! Die, alongside your precious Earthlings!');
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
