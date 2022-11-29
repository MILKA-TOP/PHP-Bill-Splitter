<?php


class InputPersonNameState extends BotState
{
    function stateAction($user_id, $data, $db)
    {
        if ($this->payloadSwitch($user_id, $data, $db)) return;

        $input_name = $data["message"]["text"];
        if (strlen($input_name) > 0 && strlen($input_name) < BILL_NAME_MAX_SIZE) {
            $this->addPersonToArgs($user_id, $input_name, $db);
        } else {
            vkApi_messagesSend($user_id, ERROR_MESSAGE_PERSON_INPUT, $this->keyboard);
        }
    }

    private function payloadSwitch($user_id, $data, $db)
    {
        if (isset($data["message"]["payload"])) {
            $data_payload = $data["message"]["payload"];
            $array = json_decode($data_payload, true);
            if (!isset($array[COMMAND_PAYLOAD])) return false;
            switch ($array[COMMAND_PAYLOAD]) {
                case CANCEL_PAYLOAD:
                    $this->toStartMenuState($user_id, $db);
                    break;
                case CONFIRM_PAYLOAD:
                    $this->creatingBill($user_id, $db);
                    break;
                default:
                    return false;
            }
            return true;
        }
        return false;
    }

    private function creatingBill($user_id, $db) {
        vkApi_messagesSend($user_id, DEVELOP_MESSAGE, $this->keyboard);
    }

    private function addPersonToArgs($user_id, $name, $db)
    {
        /*$user = new User($db);
        $user->id = $user_id;
        $user->getSingleUser();
        $user->updateStateWithArgs(
            SET_BILL_PASSWORD_CONFIRM_STATE,
            setPasswordFieldToJson($user->stateArgs, $name)
        );*/
        vkApi_messagesSend($user_id, DEVELOP_MESSAGE, $this->keyboard);
        vkApi_messagesSend($user_id, INPUT_PERSONS_BILL_LIST_MESSAGE, CONFIRM_BILL_NAME_KEYBOARD);
    }

}