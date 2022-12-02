<?php

const CALLBACK_API_EVENT_CONFIRMATION = 'confirmation';
const CALLBACK_API_EVENT_MESSAGE_NEW = 'message_new';
const CALLBACK_API_EVENT_MESSAGE_EVENT = 'message_event';

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
require_once 'bot/res/numbers.php';
require_once 'bot/models/InlineKeyboardPageModel.php';
require_once 'bot/models/SingleBillModel.php';
require_once 'bot/actions/BotState.php';
require_once 'bot/actions/StartState.php';
require_once 'bot/actions/InputBillNameState.php';
require_once 'bot/actions/ConfirmNameState.php';
require_once 'bot/actions/InputPasswordState.php';
require_once 'bot/actions/ConfirmPasswordState.php';
require_once 'bot/actions/InputPersonNameState.php';
require_once 'bot/actions/MainBillState.php';
require_once 'bot/actions/SelectSingleBillState.php';
require_once 'bot/actions/CreateNewSingleBill.php';
require_once 'bot/actions/MainSingleBillState.php';
require_once 'bot/actions/InputSingleBillNameState.php';
require_once 'bot/res/strings.php';
require_once 'bot/res/keyboards.php';
require_once 'bot/di/KeyboardModel.php';
require_once 'bot/di/StateModel.php';
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

            case CALLBACK_API_EVENT_MESSAGE_EVENT:
                _callback_handleMessageEvent($event['object']);
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

function _callback_handleMessageEvent($data)
{
    $user_id = $data['peer_id'];
    bot_sendMessage($user_id, $data);
    _callback_okResponse();
}

function _callback_okResponse()
{
    log_msg("Hello, log!");
    _callback_response('ok');
}

function _callback_response($data)
{
    echo $data;
    exit();
}


