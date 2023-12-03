<?
$functions = array(
    'robot_function' => function($objects){

        // Extract all objects into the current scope
        extract($objects);

        // Return true on success
        return true;

    },
    'rpg-ability_trigger-damage_after' => function($objects){
        //error_log('rpg-ability_trigger-damage_after() for '.$objects['this_robot']->robot_string);

        // Extract all objects into the current scope
        extract($objects);

        // If this robot is not the recipient, the effect doesn't activate
        if ($options->damage_target !== $this_robot){ return false; }

        // If this robot is not itself, we cannot trigger the effect
        if (empty($this_robot->robot_energy)){ return false; }
        if ($this_robot->robot_status === 'disabled'){ return false; }
        if ($this_robot->robot_token !== $this_robot->robot_pseudo_token){ return false; }

        // If the ability was a failure or didn't do any damage, no item drop
        if ($this_ability->ability_results['this_result'] !== 'success'){ return false; }
        if (empty($this_ability->ability_results['this_amount'])){ return false; }
        if (empty($this_ability->ability_results['damage_type'])){ return false; }

        // If the opposing player is not on the left-hand side, we cannot trigger this effect
        $target_robot = !empty($options->damage_initiator) ? $options->damage_initiator : false;
        if (empty($target_robot)){ return false; }
        $target_player = $target_robot->player;
        if ($target_player->player_side !== 'left'){ return false; }

        // Check to see which kind of shard we should be dropping
        $item_reward_type = $this_ability->ability_results['damage_type'];
        $item_reward_token = $item_reward_type.'-shard';

        // Check to see how many shards we should be dropping in this way
        $inflicted_damage_percent = ceil(($this_ability->ability_results['this_amount'] / $this_robot->robot_base_energy) * 100);
        $item_quantity_dropped = 1; //floor($inflicted_damage_percent / 20);
        //if (empty($item_quantity_dropped)){ $item_quantity_dropped = 1; }
        //error_log('$this_robot->robot_base_energy: '.$this_robot->robot_base_energy);
        //error_log('$this_ability->ability_results: '.print_r($this_ability->ability_results, true));
        //error_log('$this_ability->ability_results[\'this_amount\']: '.$this_ability->ability_results['this_amount']);
        //error_log('$inflicted_damage_percent: '.$inflicted_damage_percent);
        //error_log('$item_quantity_dropped: '.$item_quantity_dropped);

        // Trigger the actual item drop function on for the player
        $this_robot->set_frame('defend');
        $item_reward_key = 0;
        rpg_player::trigger_item_drop($this_battle, $target_player, $target_robot, $this_robot, $item_reward_key, $item_reward_token, $item_quantity_dropped);
        $this_robot->reset_frame();

        // Return true on success
        return true;

    }
);
?>
