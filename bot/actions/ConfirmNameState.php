<?php


class ConfirmNameState extends BotState
{
    function stateAction($user_id, $data, $db)
    {
        if ($this->payloadSwitch($user_id, $data, $db)) return;

        vkApi_messagesSend($user_id, CONFIRM_INPUT_NAME_INCORRECT_MESSAGE, $this->keyboard);
    }

    private function payloadSwitch($user_id, $data, $db): bool
    {
        $data_payload = $this->getPayloadArgs($data);
        if ($data_payload != null) {
            $array = json_decode($data_payload, true);
            if (!isset($array[COMMAND_PAYLOAD])) return false;
            switch ($array[COMMAND_PAYLOAD]) {
                case CONFIRM_PAYLOAD:
                    $this->setConfirmState($user_id, $db);
                    break;
                case BACK_PAYLOAD:
                    $this->setBackState($user_id, $db);
                    break;
                case CANCEL_PAYLOAD:
                    $this->toStartMenuState($user_id, $db);
                    break;
                default:
                    return false;
            }
            return true;
        }
        return false;
    }

    private function setConfirmState($user_id, $db)
    {
        $user = new User($db);
        $user->id = $user_id;
        $user->updateState(SET_BILL_PASSWORD_INPUT_STATE);
        vkApi_messagesSend($user_id, INPUT_PASSWORD_MESSAGE, INPUT_PASSWORD_KEYBOARD);
    }

    private function setBackState($user_id, $db)
    {
        $user = new User($db);
        $user->id = $user_id;
        $user->updateStateWithArgs(SET_BILL_NAME_STATE, EMPTY_JSON_STATE);
        vkApi_messagesSend($user_id, INPUT_NAME_MESSAGE, CREATE_BILL_INPUT);
    }

}