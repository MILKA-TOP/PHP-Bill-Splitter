<?php

function mainStateAction($user_id, $data, $db)
{
    if (payloadSwitch($user_id, $data)) {
        vkApi_messagesSend($user_id, START_MESSAGE, MAIN_KEYBOARD);
        return;
    }

    if (isset($data["message"]["payload"]))
        switch ($data["message"]["text"]) {
            case CREATE_BILL_BUTTON_TEXT:
                startCreateUserBills($user_id, $db);
                break;
            case SHOW_BILLS_BUTTON_TEXT:
                showUserBills($user_id, $db);
                break;
            case HELP_TEXT:
                vkApi_messagesSend($user_id, START_MESSAGE, MAIN_KEYBOARD);
                break;
            default:
                vkApi_messagesSend($user_id, ERROR_MAIN_MESSAGE, MAIN_KEYBOARD);
        }
}

function payloadSwitch($user_id, $data)
{
    if (isset($data["message"]["payload"])) {
        vkApi_messagesSend($user_id, $data["message"]["payload"], MAIN_KEYBOARD);
        $data_payload = $data["message"]["payload"];
        vkApi_messagesSend($user_id, $data_payload, MAIN_KEYBOARD);

        //return $data_payload["command"] === 'start';
        return false;
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