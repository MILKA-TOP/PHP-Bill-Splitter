<?php

abstract class BotState
{

    protected $state_number;
    protected $keyboard;

    public function __construct(int $state_number, array $keyboard)
    {
        $this->state_number=$state_number;
        $this->keyboard=$keyboard;
    }

    abstract public function stateAction($user_id, $data, $db);
}