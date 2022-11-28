<?php
const ADMIN_ID = 219928545;

function bot_sendMessage($user_id, $data)
{
    $database = new Database();
    $db = $database->getConnection();
    vkApi_messagesSend($user_id, $data["message"]["text"]);
    $currentState = stateById($user_id, $db);
    actionByState($user_id, $currentState, $data, $db);
}

function stateById($user_id, $db)
{
    $item = new User($db);

    $item->id = $user_id;
    $item->getSingleUser();

    if ($item->stateId == null) {
        $item->stateId = 0;
        $item->stateArgs = EMPTY_JSON_STATE;
        $item->bills = EMPTY_JSON_IDS_ARRAY;
        $item->createUser();
    }

    return $item->stateId;
}

function actionByState($user_id, $stateId, $data, $db)
{
    switch ($stateId) {
        case START_STATE:
            (new StartState(START_STATE, array()))->stateAction($user_id, $data, $db);
            break;
        case SET_BILL_NAME_STATE:
            (new InputNameState(SET_BILL_NAME_STATE, array()))->stateAction($user_id, $data, $db);
            break;
        case SET_BILL_CONFIRM_NAME_STATE:
            (new ConfirmNameState(SET_BILL_CONFIRM_NAME_STATE, array()))->stateAction($user_id, $data, $db);
            break;
        case SET_BILL_PASSWORD_INPUT_STATE:
            (new InputPasswordState(SET_BILL_PASSWORD_INPUT_STATE, array()))->stateAction($user_id, $data, $db);
            break;
    }
}