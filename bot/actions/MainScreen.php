<?php

function mainStateAction($user_id, $data, $db)
{
    if (payloadSwitch($user_id, $data, $db)) return;

    switch ($data["message"]["text"]) {
        default:
            vkApi_messagesSend($user_id, ERROR_MAIN_MESSAGE, MAIN_KEYBOARD);
    }
}

function payloadSwitch($user_id, $data, $db)
{
    if (isset($data["message"]["payload"])) {
        $data_payload = $data["message"]["payload"];
        vkApi_messagesSend($user_id, $data_payload, MAIN_KEYBOARD);
        vkApi_messagesSend($user_id, $data_payload, isset($data_payload[COMMAND_PAYLOAD]));
        if (!isset($data_payload[COMMAND_PAYLOAD])) return false;
        switch ($data_payload[COMMAND_PAYLOAD]) {
            case CREATE_BILL_PAYLOAD:
                startCreateUserBills($user_id, $db);
                break;
            case SHOW_BILLS_PAYLOAD:
                showUserBills($user_id, $db);
                break;
            case HELP_PAYLOAD:
                vkApi_messagesSend($user_id, START_MESSAGE, MAIN_KEYBOARD);
                break;
            default:
                return false;
        }
    }
    return false;
}

function showUserBills($user_id, $db)
{
    $user = new User($db);
    $user->id = $user_id;
    $user->getSingleUser();

    $bill = new Bill($db);
    $bill_id_list = json_decode($user->bills);
    $bill_name_list = $bill->getNameBillList($bill_id_list);
    vkApi_messagesSend($user_id, $bill_name_list, MAIN_KEYBOARD);
}

function startCreateUserBills($user_id, $db)
{
    vkApi_messagesSend($user_id, DEVELOP_MESSAGE, MAIN_KEYBOARD);
}