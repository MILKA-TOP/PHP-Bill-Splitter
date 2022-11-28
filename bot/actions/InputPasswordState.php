<?php

class InputPasswordState implements BotState
{
    function stateAction($user_id, $data, $db)
    {
        if ($this->payloadSwitch($user_id, $data, $db)) return;

        $input_name = $data["message"]["text"];
        if (strlen($input_name) > 0 && strlen($input_name) < BILL_PASSWORD_MAX_SIZE) {
            $this->setCurrentPassword($user_id, $input_name, $db);
        } else {
            vkApi_messagesSend($user_id, INPUT_PASSWORD_INCORRECT_MESSAGE, INPUT_PASSWORD_KEYBOARD);
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
                    $this->setCancelState($user_id, $db);
                    break;
                case SKIP_PASSWORD_PAYLOAD:
                    $this->skipPassword($user_id, $db);
                    break;
                default:
                    return false;
            }
            return true;
        }
        return false;
    }

    private function setCancelState($user_id, $db)
    {
        $user = new User($db);
        $user->id = $user_id;
        $user->updateStateWithArgs(START_STATE, EMPTY_JSON_STATE);
        vkApi_messagesSend($user_id, ROLLBACK_TO_MAIN_MENU, MAIN_KEYBOARD);
    }

    private function setCurrentPassword($user_id, $password, $db)
    {
        vkApi_messagesSend($user_id, DEVELOP_MESSAGE, CONFIRM_BILL_NAME_KEYBOARD);

        #$user = new User($db);
        #$user->id = $user_id;
        #$user->updateStateWithArgs(SET_BILL_CONFIRM_NAME_STATE, setNameStateJsonArgument($password));
        #vkApi_messagesSend($user_id, sprintf(INPUT_NAME_CONFIRM, $password), CONFIRM_BILL_NAME_KEYBOARD);
    }

    private function skipPassword($user_id, $db)
    {
        vkApi_messagesSend($user_id, DEVELOP_MESSAGE, CONFIRM_BILL_NAME_KEYBOARD);

        #$user = new User($db);
        #$user->id = $user_id;
        #$user->updateStateWithArgs(SET_BILL_CONFIRM_NAME_STATE, setNameStateJsonArgument($name));
        #vkApi_messagesSend($user_id, sprintf(INPUT_NAME_CONFIRM, $name), CONFIRM_BILL_NAME_KEYBOARD);
    }


}