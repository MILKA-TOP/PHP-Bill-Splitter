<?php
const ADMIN_ID = 219928545;

function bot_sendMessage($user_id, $data)
{
    $database = new Database();
    $db = $database->getConnection();
    $currentState = stateById($user_id, $db);
    actionByState($user_id, $currentState, $data, $db);
}

function stateById($user_id, $db): int
{
    $item = new User($db);

    $item->id = $user_id;
    $item->getSingleUser();

    if ($item->stateId == null) {
        $item->stateId = 0;
        $item->stateArgs = EMPTY_JSON_STATE;
        $item->bills = EMPTY_JSON_ARRAY;
        $item->createUser();
    }

    return $item->stateId;
}

function actionByState($user_id, $stateId, $data, $db)
{
    $state_class = state_model[$stateId];
    $state_object = new $state_class($stateId, keyboard_model[$stateId]);
    $state_object->stateAction($user_id, $data, $db);
}