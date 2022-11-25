<?php

function mainStateAction($user_id, $data, $db)
{
    switch ($data["message"]["text"]) {
        case CREATE_BILL_BUTTON_TEXT:
            break;
        case SHOW_BILLS_BUTTON_TEXT:
            break;
        default:
            vkApi_messagesSendWithKeyBoard($user_id, START_MESSAGE, [
                "one_time" => true,
                "buttons" => [[
                    ["action" => [
                        "type" => "text",
                        "payload" => '{"button": "1"}',
                        "label" => "Фрукты?"],
                        "color" => "default"],
                ]]]);
    }
}