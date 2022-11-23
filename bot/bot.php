<?php
const ADMIN_ID = 219928545;

function bot_sendMessage($user_id, $data)
{
    $msg = "Привет, {$user_id}!";
    vkApi_messagesSend($user_id, "Start sending");
    vkApi_messagesSend($user_id, $data["message"]["text"]);
    completeByMessage($user_id, $data["message"]["text"]);
    //$curr_data = stateById($user_id);
    //vkApi_messagesSend($user_id, $curr_data);
}

function stateById($user_id)
{
    $database = new Database();
    $db = $database->getConnection();

    $item = new User($db);

    $item->id = $user_id;
    $item->getSingleUser();
    if ($item->stateId != null) {
        vkApi_messagesSend($user_id, "Get from database");

    } else {
        $item->stateId = 0;
        $item->stateArgs = EMPTY_JSON_STATE;
        $item->bills = EMPTY_JSON_IDS_ARRAY;
        $resCreate = $item->createUser();
        vkApi_messagesSend($user_id, "Create new: $resCreate");
    }
    $usr_arr = array(
        "id" => $item->id,
        "stateId" => $item->stateId,
        "stateArgs" => $item->stateArgs,
        "bills" => $item->bills,
    );

    return json_encode($usr_arr);
}

function completeByMessage($user_id, $message)
{
    $messagesParts = preg_split('/\s+/', $message);
    if ($messagesParts[0] === "INC") {
        if (sizeof($messagesParts) > 2 && is_numeric($messagesParts[1])) {
            $currNUmber = (int)$messagesParts[1] + 1;
            vkApi_messagesSend($user_id, "Result: $currNUmber");
        } else {
            vkApi_messagesSend($user_id, "Is not a number: $messagesParts[1]");
        }
    } else {
        vkApi_messagesSend($user_id, "Error input: $messagesParts[0]");
    }

}