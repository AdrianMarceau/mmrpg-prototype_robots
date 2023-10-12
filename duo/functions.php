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

        // Update this robot's quotes based on the general context of this battle
        //error_log('update quotes for duo w/ context '.print_r($this_battle->values['context'], true));

        // Update END GAME quotes differently than any other quotes
        if ($this_battle->has_endgame_context()){
            $context = $this_battle->values['context'];
            $this_robot->set_quote('battle_start', 'Apologies for the delay. Let us finally end this!!');
            $this_robot->set_quote('battle_taunt', 'I fear no evil! Justice will ultimately prevail in this fight!');
            $this_robot->set_quote('battle_victory', 'I take no pleasure in your defeat, but my mission is absolute!');
            $this_robot->set_quote('battle_defeat', 'I have failed you, my friends. Your planet... you must protect it!');
        }

        // Return true on success
        return true;

    },
    'robot_function_ontargetchange' => function($objects){

        // Extract all objects into the current scope
        extract($objects);

        // If we're in the endgame, do not touch any of our preset quotes
        if ($this_battle->has_endgame_context()){ return true; }

        // Update this robot's taunt quote based on the robot being faced
        //error_log('update quotes for duo w/ target '.$target_robot->robot_string);
        //$this_robot->set_quote('battle_start', 'This is a target change test and I am now facing '.$target_robot->robot_string.'!');
        $target_robot_info = rpg_robot::get_index_info($target_robot->robot_token);
        // Update END GAME quotes differently than any other quotes
        if ($this_battle->has_endgame_context()){
            $context = $this_battle->values['context'];
            switch ($target_robot->robot_token){
                case 'slur': {
                    $this_robot->set_quote('battle_taunt', 'I feel an unsettling connection to you, but I cannot let you hurt my friends!');
                    $this_robot->set_quote('battle_victory', 'I take no pleasure in your defeat Slur, but my mission is absolute!');
                    break;
                }
                case 'trille-bot': {
                    $this_robot->set_quote('battle_taunt', 'I sense a great sadness within you... Something important has been lost...');
                    $this_robot->set_quote('battle_victory', 'It\'s over now, little one. You can sleep. You did your best.');
                    break;
                }
            }
        }
        // Otherwise if this is ANY OTHER TIME we can define our quotes based on specific characters
        else {
            switch ($target_robot->robot_token){
                case 'slur': {
                    $this_robot->set_quote('battle_start', 'I thought I took care of you already! Back for more?');
                    $this_robot->set_quote('battle_victory', 'I will defeat you as man times as it takes! You will never win!');
                    break;
                }
                case 'terra': {
                    $this_robot->set_quote('battle_start', 'Terra… Ra Moon is dead. You fruitlessly serve as the only messenger of a dead ideology.');
                    break;
                }
                case 'mercury': {
                    $this_robot->set_quote('battle_start', 'Mercury… You are a parasite that feeds on the lives of innocents. There will be no mercy for you. ');
                    break;
                }
                case 'venus': {
                    $this_robot->set_quote('battle_start', 'Submit immediately, Venus. To destroy you would take me only a single blow.');
                    break;
                }
                case 'mars': {
                    $this_robot->set_quote('battle_start', 'War is only just a game to you, Mars. Today, you will finally face justice.');
                    break;
                }
                case 'jupiter': {
                    $this_robot->set_quote('battle_start', 'Your soul has seen enough warfare for a thousand years. Do your sins not haunt you?');
                    break;
                }
                case 'saturn': {
                    $this_robot->set_quote('battle_start', 'You\'ve been running from me for over 20,000 years.. And yet, still, here I am.');
                    break;
                }
                case 'uranus': {
                    $this_robot->set_quote('battle_start', 'Your soul is that of a diseased beast. It falls on me, then, to put you down.');
                    break;
                }
                case 'neptune': {
                    $this_robot->set_quote('battle_start', 'The Earth will never be yours, Pluto - As a Star Marshal, that is my promise.');
                    break;
                }
                case 'pluto': {
                    $this_robot->set_quote('battle_start', 'I\'ve seen firsthand the hell you\'ve sown. Destroying you quickly is all the mercy I can offer.');
                    break;
                }
                case 'sunstar': {
                    $this_robot->set_quote('battle_start', 'Sunstar… has been revived?! Everyone, listen well. If we fall here, our universe is lost!');
                    break;
                }
                default: {
                    $noun_prefix = ($target_robot->robot_class === 'mecha' ? 'A ' : '');
                    $target_name_text = $noun_prefix.$target_robot->robot_name;
                    $noun_prefix = ($target_robot->robot_class === 'mecha' ? 'A ' : 'The ');
                    $target_class_text = $noun_prefix.strtolower($target_robot_info['robot_description']);
                    $after_name_texts = array(', correct?', ', I presume?', ', right?', '!', '?', '...');
                    $after_class_texts = array('!', '?', '...');
                    $after_name_text = $after_name_texts[array_rand($after_name_texts)];
                    $after_class_text = $after_class_texts[array_rand($after_class_texts)];
                    $this_robot->set_quote('battle_start',
                        $target_robot->robot_name.$after_name_text.
                        ' '.$target_class_text.$after_class_text.
                        ' Let\'s go!'
                        );
                    break;
                }
            }
        }

        // Return true on success
        return true;

    }
);
$functions['robot_function_onturnstart'] = function($objects) use ($functions){
    error_log('onturnstart for duo w/ target '.$objects['target_robot']->robot_string);
    return $functions['robot_function_ontargetchange']($objects, true);
};
$functions['robot_function_onswitch'] = function($objects) use ($functions){
    error_log('onswitch for duo w/ target '.$objects['target_robot']->robot_string);
    return $functions['robot_function_ontargetchange']($objects, true);
};
$functions['robot_function_onswitchin'] = function($objects) use ($functions){
    error_log('onswitchin for duo w/ target '.$objects['target_robot']->robot_string);
    return $functions['robot_function_ontargetchange']($objects, true);
};
?>
