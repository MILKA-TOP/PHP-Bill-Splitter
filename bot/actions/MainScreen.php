<?php

function mainStateAction($user_id, $data, $db)
{
    if (checkStartPayload($user_id, $data)) {
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

function checkStartPayload($user_id, $data)
{
    if (isset($data["message"]["payload"])) {
        $curr_payload = $data["message"]["payload"];
        vkApi_messagesSend($user_id, $curr_payload);
        return isset($data["message"]["payload"]["command"]) && $data["message"]["payload"]["command"] == "start";
    }
    return false;
}

function showUserBills($user_id, $db)
{
    vkApi_messagesSend($user_id, DEVELOP_MESSAGE, MAIN_KEYBOARD);
}

function startCreateUserBills($user_id, $db)
{
    vkApi_messagesSend($user_id, DEVELOP_MESSAGE, MAIN_KEYBOARD);
}