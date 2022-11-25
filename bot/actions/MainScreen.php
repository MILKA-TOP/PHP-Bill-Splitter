<?php

function mainStateAction($user_id, $data, $db)
{
    if (isset($data["payload"])) {
        vkApi_messagesSend($user_id, $data["payload"]);
    } else {
        vkApi_messagesSend($user_id, $data);
    }
    switch ($data["message"]["text"]) {
        case CREATE_BILL_BUTTON_TEXT:
            startCreateUserBills($user_id, $db);
            break;
        case SHOW_BILLS_BUTTON_TEXT:
            showUserBills($user_id, $db);
            break;
        default:
            vkApi_messagesSend($user_id, START_MESSAGE, MAIN_KEYBOARD);
    }
}

function showUserBills($user_id, $db)
{
    vkApi_messagesSend($user_id, DEVELOP_MESSAGE, MAIN_KEYBOARD);
}

function startCreateUserBills($user_id, $db)
{
    vkApi_messagesSend($user_id, DEVELOP_MESSAGE, MAIN_KEYBOARD);
}