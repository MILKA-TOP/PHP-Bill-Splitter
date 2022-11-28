<?php

abstract class BotState
{

    private $state_number;
    private $keyboard;

    public function __construct(int $state_number, array $keyboard)
    {
        $this->$state_number=$state_number;
        $this->$keyboard=$keyboard;
    }

    abstract public function stateAction($user_id, $data, $db);
}