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
        vkApi_messagesSend($user_id, START_MESSAGE);
    }

    return $item->stateId;
}

function actionByState($user_id, $stateId, $data, $db)
{
    switch ($stateId) {
        case START_STATE:
            mainStateAction($user_id, $data, $db);
            break;
    }
}

function completeByMessage($user_id, $message, $db)
{
    $messagesParts = preg_split('/\s+/', $message);
    if ($messagesParts[0] === "INC" && sizeof($messagesParts) > 1) {
        if (is_numeric($messagesParts[1])) {
            $currNUmber = (int)$messagesParts[1] + 1;
            vkApi_messagesSend($user_id, "Result: $currNUmber");
        } else {
            vkApi_messagesSend($user_id, "Is not a number: $messagesParts[1]");
        }
    } else if ($messagesParts[0] === "BILL" && sizeof($messagesParts) >= 2) {
        $item = new Bill($db);
        if ($messagesParts[1] === "ALL") {
            vkApi_messagesSend($user_id, $item->getBills());
        } else if ($messagesParts[1] === "CREATE") {
            vaseCreateBill($user_id, $item);
            vkApi_messagesSend($user_id, $item->getBills());
        } else if (is_numeric($messagesParts[1])) {
            $item->id = (int)$messagesParts[1];
            $item->getSingleBill();
        }
    } else {
        vkApi_messagesSend($user_id, "Error input: $messagesParts[0]");
    }

}

function vaseCreateBill($user_id, $item)
{
    $item->adminId = $user_id;
    $item->password = "ASD";
    $item->persons = EMPTY_JSON_IDS_ARRAY;
    $item->name = "ASDAD";
    $item->singleBillsIds = EMPTY_JSON_IDS_ARRAY;
    $item->createUser();
}