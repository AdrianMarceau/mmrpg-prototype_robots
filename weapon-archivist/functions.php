<?
$functions = array(
    'robot_function' => function($objects){

        // Extract all objects into the current scope
        extract($objects);

        // Return true on success
        return true;

    },
    'rpg-ability_trigger-damage_after' => function($objects){
        error_log('rpg-ability_trigger-damage_after() for '.$objects['this_robot']->robot_string);

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

        // If the opposing player is not on the left-hand side, we cannot trigger this effect
        $target_robot = !empty($options->damage_initiator) ? $options->damage_initiator : false;
        if (empty($target_robot)){ return false; }
        $target_player = $target_robot->player;
        if ($target_player->player_side !== 'left'){ return false; }

        error_log('i guess we can drop some cores eh?');

        // Trigger the actual item drop function on for the player
        $this_robot->set_frame('defend');
        $item_reward_key = 0;
        $item_reward_token = $this_robot->robot_core.'-core';
        $item_quantity_dropped = 1;
        rpg_player::trigger_item_drop($this_battle, $target_player, $target_robot, $this_robot, $item_reward_key, $item_reward_token, $item_quantity_dropped);
        $this_robot->reset_frame();

        // Return true on success
        return true;

    }
);
?>
