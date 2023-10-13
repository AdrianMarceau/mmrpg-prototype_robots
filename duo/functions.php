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

        // Update END GAME quotes differently than any other quotes
        if ($this_battle->has_endgame_context()){
            $this_robot->set_quote('battle_start', 'Apologies for the delay, everyone. Let us finally end this years-long battle!!');
            $this_robot->set_quote('battle_defeat', 'I have failed you, my friends. Please… you must protect the Earth!');
            $this_robot->set_quote('battle_taunt', 'I fear no evil! Justice will ultimately prevail in this fight!');
            $this_robot->set_quote('battle_victory', 'I take no pleasure in your defeat, but my mission is absolute!');
        }
        // Otherwise, update this robot's quotes based on the general context of this battle
        elseif ($context['chapter'] === 1){
            $this_robot->set_quote('battle_taunt', 'It\'s the simple things that give life meaning, don\'t you think?');
        } elseif ($context['chapter'] === 2){
            $this_robot->set_quote('battle_taunt', 'These earlier challenges are quite easy for us now, aren\'t they?');
        } elseif ($context['chapter'] === 3){
            $this_robot->set_quote('battle_taunt', 'Yes! Fighting against one\'s rivals is truly exhilarating, isn\'t it?');
        } elseif ($context['chapter'] === 4){
            $this_robot->set_quote('battle_taunt', 'Fusion is the ultimate expression of teamwork, don\'t you think?');
        } elseif ($context['chapter'] === 5){
            $this_robot->set_quote('battle_taunt', 'Can you feel it in the air? The final battle is drawing near!');
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
        $target_robot_info = rpg_robot::get_index_info($target_robot->robot_token);
        // Update END GAME quotes differently than any other quotes
        if ($this_battle->has_endgame_context()){
            $context = $this_battle->values['context'];
            switch ($target_robot->robot_token){
                case 'slur': {
                    $this_robot->set_quote('battle_taunt', 'I feel an otherworldy connection to you, but I cannot let you hurt my friends!');
                    $this_robot->set_quote('battle_victory', 'I take no pleasure in your defeat, but my mission to destroy evil is absolute!');
                    break;
                }
                case 'trille-bot': {
                    $this_robot->set_quote('battle_taunt', 'I sense a great sadness within you… Something important has been lost…');
                    $this_robot->set_quote('battle_victory', 'It\'s over now, little one. You really did your best, didn\'t you?');
                    break;
                }
            }
        }
        // Otherwise if this is ANY OTHER TIME we can define our quotes based on specific characters
        else {
            switch ($target_robot->robot_token){
                case 'slur': {
                    $this_robot->set_quote('battle_start', 'I thought I took care of you already? Back for more, I guess!');
                    $this_robot->set_quote('battle_victory', 'I will defeat you as many times as it takes! You will never win!');
                    break;
                }
                case 'terra': {
                    $this_robot->set_quote('battle_start', 'Terra… Ra Moon is gone. You serve as the lone messenger of a dead ideology!');
                    break;
                }
                case 'mercury': {
                    $this_robot->set_quote('battle_start', 'Mercury… A parasite feeding on the lives of innocents. There will be no mercy.');
                    break;
                }
                case 'venus': {
                    $this_robot->set_quote('battle_start', 'Submit immediately, Venus. To destroy you would take me only a single blow.');
                    break;
                }
                case 'mars': {
                    $this_robot->set_quote('battle_start', 'War is just a game to you, isn\'t it Mars? Today, you will finally face justice!');
                    break;
                }
                case 'jupiter': {
                    $this_robot->set_quote('battle_start', 'Your wars have rended the souls of thousands, Jupiter! Do your sins not haunt you?');
                    break;
                }
                case 'saturn': {
                    $this_robot->set_quote('battle_start', 'Saturn, you\'ve run from me for over 20,000 years…  And yet, still, here I am!');
                    break;
                }
                case 'uranus': {
                    $this_robot->set_quote('battle_start', 'Uranus… Your brutal heart is poisoned and wicked. Like a disease, I will expell you!');
                    break;
                }
                case 'neptune': {
                    $this_robot->set_quote('battle_start', 'I\'ve seen firsthand the hell you’ve sown, Neptune. Felling you quickly would be a mercy!');
                    break;
                }
                case 'pluto': {
                    $this_robot->set_quote('battle_start', 'Heel, fowl beast! Earth will never be yours, Pluto! I promise you that as a Star Marshal!');
                    break;
                }
                case 'sunstar': {
                    $this_robot->set_quote('battle_start', 'S… Sunstar?! Free again?! Listen well, everyone! If we lose here, our universe is doomed!');
                    break;
                }
                default: {
                    $noun_prefix = ($target_robot->robot_class === 'mecha' ? 'A ' : '');
                    $target_name_text = $noun_prefix.$target_robot->robot_name;
                    $noun_prefix = ($target_robot->robot_class === 'mecha' ? 'A ' : 'The ');
                    $target_class_text = $noun_prefix.strtolower($target_robot_info['robot_description']);
                    $after_name_texts = array(', correct?', ', I presume?', ', right?', '!', '?', '…');
                    $after_class_texts = array('!', '?', '…');
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
    //error_log('onturnstart for duo w/ target '.$objects['target_robot']->robot_string);
    return $functions['robot_function_ontargetchange']($objects, true);
};
$functions['robot_function_onswitch'] = function($objects) use ($functions){
    //error_log('onswitch for duo w/ target '.$objects['target_robot']->robot_string);
    return $functions['robot_function_ontargetchange']($objects, true);
};
$functions['robot_function_onswitchin'] = function($objects) use ($functions){
    //error_log('onswitchin for duo w/ target '.$objects['target_robot']->robot_string);
    return $functions['robot_function_ontargetchange']($objects, true);
};
?>
