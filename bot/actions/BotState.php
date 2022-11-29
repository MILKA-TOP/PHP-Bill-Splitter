<?php

abstract class BotState
{

    protected $state_number;
    protected $keyboard;

    public function __construct(int $state_number, array $keyboard = array())
    {
        $this->state_number = $state_number;
        $this->keyboard = $keyboard;
    }

    protected function toStartMenuState($user_id, $db)
    {
        $user = new User($db);
        $user->id = $user_id;
        $user->updateStateWithArgs(START_STATE, EMPTY_JSON_STATE);
        vkApi_messagesSend($user_id, ROLLBACK_TO_MAIN_MENU, MAIN_KEYBOARD);
    }

    protected function getPayloadArgs($data) {
        if (isset($data["message"]["payload"])) return $data["message"]["payload"];
        if (isset($data["payload"])) return $data["payload"];
        return null;
    }


    abstract public function stateAction($user_id, $data, $db);
}