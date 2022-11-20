<?php

function bot_sendMessage($user_id, $data)
{
    $msg = "Привет, {$user_id}!";
    $curr_data = stateById($user_id);
    vkApi_messagesSend($user_id, $curr_data);
}

function stateById($user_id)
{
    $database = new Database();
    $db = $database->getConnection();

    $item = new User($db);

    $item->id = $user_id;
    $item->getSingleUser();
    if ($item->stateId != null) {
        // create array

    } else {
        $item->stateId = 0;
        $item->stateArgs = EMPTY_JSON_STATE;
        $item->bills = EMPTY_JSON_IDS_ARRAY;
        $item->createUser();
    }
    $usr_arr = array(
        "id" => $item->id,
        "stateId" => $item->stateId,
        "stateArgs" => $item->stateArgs,
        "bills" => $item->bills,
    );

    return json_encode($usr_arr);
}