<?php

function mainStateAction($user_id, $data, $db)
{
    vkApi_messagesSend($user_id, $data["payload"]);
    switch ($data["message"]["text"]) {
        case CREATE_BILL_BUTTON_TEXT:
            break;
        case SHOW_BILLS_BUTTON_TEXT:
            break;
        default:
            vkApi_messagesSend($user_id, START_MESSAGE, MAIN_KEYBOARD);
    }
}