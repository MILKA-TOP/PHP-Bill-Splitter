<?php

const CALLBACK_API_EVENT_CONFIRMATION = 'confirmation';
const CALLBACK_API_EVENT_MESSAGE_NEW = 'message_new';

require_once 'config.php';
require_once 'global.php';

require_once 'api/vk_api.php';

require_once 'bot/class/User.php';
require_once 'bot/class/SingleBill.php';
require_once 'bot/class/Person.php';
require_once 'bot/class/Field.php';
require_once 'bot/class/Bill.php';
require_once 'bot/config/database.php';
require_once 'bot/config/json.php';
require_once 'bot/config/states.php';
require_once 'bot/config/payloads.php';
require_once 'bot/actions/StartState.php';
require_once 'bot/actions/InputNameState.php';
require_once 'bot/actions/ConfirmNameState.php';
require_once 'bot/res/strings.php';
require_once 'bot/res/keyboards.php';
require_once 'bot/res/numbers.php';
require_once 'bot/bot.php';

if (!isset($_REQUEST)) {
    exit;
}

callback_handleEvent();

function callback_handleEvent()
{
    $event = _callback_getEvent();

    try {
        switch ($event['type']) {
            //Подтверждение сервера
            case CALLBACK_API_EVENT_CONFIRMATION:
                _callback_handleConfirmation();
                break;

            //Получение нового сообщения
            case CALLBACK_API_EVENT_MESSAGE_NEW:
                _callback_handleMessageNew($event['object']);
                break;

            default:
                _callback_response('Unsupported event '.$event['type']);
                break;
        }
    } catch (Exception $e) {
        log_error($e);
    }

    _callback_okResponse();
}

function _callback_getEvent()
{
    return json_decode(file_get_contents('php://input'), true);
}

function _callback_handleConfirmation()
{
    _callback_response(CALLBACK_API_CONFIRMATION_TOKEN);
}

function _callback_handleMessageNew($data)
{
    $user_id = $data['message']['peer_id'];
    bot_sendMessage($user_id, $data);
    _callback_okResponse();
}

function _callback_okResponse()
{
    _callback_response('ok');
}

function _callback_response($data)
{
    echo $data;
    exit();
}


