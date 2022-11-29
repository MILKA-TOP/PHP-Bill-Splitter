<?php

class InputPasswordState extends BotState
{
    function stateAction($user_id, $data, $db)
    {
        if ($this->payloadSwitch($user_id, $data, $db)) return;

        $input_name = $data["message"]["text"];
        if (strlen($input_name) > 0 && strlen($input_name) < BILL_PASSWORD_MAX_SIZE) {
            $this->setCurrentPassword($user_id, $input_name, $db);
        } else {
            vkApi_messagesSend($user_id, INPUT_PASSWORD_INCORRECT_MESSAGE, $this->keyboard);
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

    private function setCurrentPassword($user_id, $password, $db)
    {
        $user = new User($db);
        $user->id = $user_id;
        $user->getSingleUser();
        $user->updateStateWithArgs(
            SET_BILL_PASSWORD_CONFIRM_STATE,
            setPasswordFieldToJson($user->stateArgs, $password)
        );

        vkApi_messagesSend(
            $user_id,
            sprintf(
                INPUT_PASSWORD_CONFIRM_MESSAGE,
                $password
            ),
            CONFIRM_PASSWORD_KEYBOARD);
    }

    private function skipPassword($user_id, $db)
    {
        $user = new User($db);
        $user->id = $user_id;
        $user->getSingleUser();
        $user->updateStateWithArgs(
            SET_BILL_PERSONS_STATE,
            setPasswordFieldToJson($user->stateArgs, null)
        );
        vkApi_messagesSend($user_id, INPUT_PERSONS_BILL_MESSAGE, INPUT_PERSONS_KEYBOARD);
    }


}