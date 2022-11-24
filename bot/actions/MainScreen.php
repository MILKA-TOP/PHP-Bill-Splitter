<?php

function mainStateAction($user_id, $data, $db)
{
    switch ($data["message"]["text"]) {
        case START_MESSAGE:
            vkApi_messagesSend($user_id, START_MESSAGE);
            break;
        case CREATE_BILL_BUTTON_TEXT:
            break;
        case SHOW_BILLS_BUTTON_TEXT:
            break;
        default:
            vkApi_messagesSend($user_id, ERROR_MAIN_MESSAGE);
    }
}