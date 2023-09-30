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
        //error_log('Updating quotes for '.$this_robot->robot_token);
        //error_log('$this_battle->battle_token = '.print_r($this_battle->battle_token, true));
        //error_log('$this_battle->values = '.print_r($this_battle->values, true));
        //error_log('$this_battle->values[\'context\'] = '.print_r($this_battle->values['context'], true));

        // Update this robot's quotes to be more dynamic with the battle context
        $context = $this_battle->values['context'];
        $human_player_info = !empty($this_battle->values['battle_players']['this_player']) ? $this_battle->values['battle_players']['this_player'] : array();
        $human_player_is_visible = !empty($human_player_info['player_visible']) ? true : false;
        $human_player_robots_count = !empty($human_player_info['player_robots']) ? count(explode(',', $human_player_info['player_robots'])) : 1;
        $start_quote = "...";
        $taunt_quote = "...";
        $victory_quote = "...";
        $defeat_quote = "...";
        if ($context['round'] <= 1){
            // Use different dialogue if the player is visible versus disabled for some reason
            if ($human_player_is_visible){
                // Normal Slur (first appearance is in Dr. Light's campaign)
                if ($context['player'] === 'dr-light'){
                    $start_quote = 'The human they call Hikari? Your hubris will be your demise.';
                    $taunt_quote = 'You remind me of a Creator. It will be shame to extingish you.';
                    $victory_quote = 'Can you see me, Master? I have finally completed my mission!';
                    $defeat_quote = 'Savour your temporary victory... I will return even more powerful...!';
                }
                // Emboldened Slur (second appearance is in Dr. Wily's campaign)
                elseif ($context['player'] === 'dr-wily'){
                    $start_quote = 'I sense an Evil in your heart. My master will be pleased at your erasure!';
                    $taunt_quote = 'Stupid Earth creatures! You are only delaying the inevitable!';
                    $victory_quote = 'The Earth should thank me for saving it from your tragic future!';
                    $defeat_quote = 'It doesn\'t end like this... I still haven\'t found my master...';
                }
                // Final Weapon Slur (third appearance is in Dr. Cossack's campaign)
                elseif ($context['player'] === 'dr-cossack'){
                    $start_quote = 'I sense you are somehow... responsible... for my suffering!';
                    $taunt_quote = 'Stop resisting! It is time you Earthlings met your deserved ends!';
                    $victory_quote = 'You wretched Earth NetNavis are all the same! Weak! Nyahahaha!';
                    $defeat_quote = 'Master... why have you forsaken me again? Was it all for nothing...?';
                }
            } else {
                if ($human_player_robots_count === 1){ $start_quote = 'A lone robot dares to challenge me?  Very well...'; }
                else { $start_quote = 'This pitiful group of robots dares to challenge me?  Very well...'; }
                $taunt_quote = 'Stop resisting! You\'re even more pathetic without your operator!';
                $victory_quote = 'Can\'t you see what I\'m doing here? I\'m saving you from yourselves!';
                $defeat_quote = 'Master... please... I need your power! Where you are...?';
            }
        } else {
            // Crestfallen Slur (final appearance is only in Dr. Cossack's campaign)
            if ($human_player_is_visible){
                $start_quote = 'No! I refuse to let it end this way!';
                $taunt_quote = 'Master, why have not come for me? Are you even out there?'; //'Master! Have you have finally come for me?!';
                $victory_quote = 'Master, I have completed my task! Are you still out there?'; //'Master, forgive me for what have I done....';
                $defeat_quote = 'Master, forgive me for I have failed you...';
            } else {
                if ($human_player_robots_count === 1){ $start_quote = 'No! I refuse to be beaten by a Earth robot!'; }
                else { $start_quote = 'No! I refuse to be beaten by a group of Earth robots!'; }
                $taunt_quote = 'Master, why have not come for me? Are you even out there?'; //'Master! Have you have finally come for me?!';
                $victory_quote = 'Master, I have completed my task! Are you still out there?'; //'Master, forgive me for what have I done....';
                $defeat_quote = 'Master, forgive me for I have failed you...';
            }
        }
        $this_robot->set_quote('battle_start', $start_quote);
        $this_robot->set_quote('battle_taunt', $taunt_quote);
        $this_robot->set_quote('battle_victory', $victory_quote);
        $this_robot->set_quote('battle_defeat', $defeat_quote);

        // Return true on success
        return true;

    }
);
?>
