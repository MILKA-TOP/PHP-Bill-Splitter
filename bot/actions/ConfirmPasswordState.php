<?php

class ConfirmPasswordState extends BotState
{
    function stateAction($user_id, $data, $db)
    {
        if ($this->payloadSwitch($user_id, $data, $db)) return;

        $input_password = $this->getMessageOrEmpty($data);
        $arg_password = $this->getPassword($user_id, $db);

        if ($input_password === $arg_password) {
            $this->confirmPasswordAction($user_id, $db);
        } else {
            vkApi_messagesSend($user_id, INPUT_PASSWORD_INCORRECT_MESSAGE, $this->keyboard);
        }
    }

    private function payloadSwitch($user_id, $data, $db): bool
    {
        $data_payload = $this->getPayloadArgs($data);
        if ($data_payload != null) {
            $array = json_decode($data_payload, true);
            if (!isset($array[COMMAND_PAYLOAD])) return false;
            switch ($array[COMMAND_PAYLOAD]) {
                case CANCEL_PAYLOAD:
                    $this->toStartMenuState($user_id, $db);
                    break;
                case BACK_PAYLOAD:
                    $this->changePassword($user_id, $db);
                    break;
                default:
                    return false;
            }
            return true;
        }
        return false;
    }

    private function getPassword($user_id, $db) {
        $user = new User($db);
        $user->id = $user_id;
        $user->getSingleUser();

        $args_array = json_decode($user->stateArgs, true);
        return $args_array[PASSWORD_STATE_ARG];
    }

    private function changePassword($user_id, $db)
    {
        $user = new User($db);
        $user->id = $user_id;
        $user->updateState(SET_BILL_PASSWORD_INPUT_STATE);
        vkApi_messagesSend($user_id, INPUT_PASSWORD_MESSAGE, INPUT_PASSWORD_KEYBOARD);
    }

    private function confirmPasswordAction($user_id, $db) {
        $user = new User($db);
        $user->id = $user_id;
        $user->updateState(SET_BILL_PERSONS_STATE);
        vkApi_messagesSend($user_id, INPUT_PERSONS_BILL_MESSAGE, INPUT_PERSONS_KEYBOARD);
    }

}