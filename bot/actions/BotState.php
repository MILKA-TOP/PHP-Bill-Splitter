<?php

interface BotState
{
    function stateAction($user_id, $data, $db);
}