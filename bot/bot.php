<?php

function bot_sendMessage($user_id, $data)
{
    $msg = "Привет, {$user_id}!";
    //$curr_data = stateById($user_id);
    vkApi_messagesSend($user_id, $msg);
    vkApi_messagesSend($user_id, stateById($user_id));
}

function stateById($user_id)
{
    $database = new Database();
    $db = $database->getConnection();
    vkApi_messagesSend($user_id, $db);

    $item = new User($db);

    $item->id = $user_id;
    $item->getSingleUser();
    vkApi_messagesSend($user_id, $item->stateId);
    if ($item->stateId != null) {
        // create array

    } else {
        vkApi_messagesSend($user_id, "Creating");
        $item->stateId = 0;
        $item->stateArgs = EMPTY_JSON_STATE;
        $item->bills = EMPTY_JSON_IDS_ARRAY;
        vkApi_messagesSend($user_id, $item->createUser());
    }
    $usr_arr = array(
        "id" => $item->id,
        "stateId" => $item->stateId,
        "stateArgs" => $item->stateArgs,
        "bills" => $item->bills,
    );

    return json_encode($usr_arr);
}