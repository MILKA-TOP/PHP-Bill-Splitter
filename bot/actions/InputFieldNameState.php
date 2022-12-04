<?php


class InputFieldNameState extends BotState
{
    function stateAction($user_id, $data, $db)
    {
        if ($this->payloadSwitch($user_id, $data, $db)) return;

        $input_name = $this->getMessageOrEmpty($data);
        if (strlen($input_name) > 0 && strlen($input_name) < FIELD_NAME_MAX_SIZE) {
            $this->setCurrentName($user_id, $input_name, $db);
        } else {
            vkApi_messagesSend($user_id, INPUT_FIELD_NAME_INCORRECT_MESSAGE, $this->keyboard);
        }
    }

    private function payloadSwitch($user_id, $data, $db): bool
    {
        $data_payload = $this->getPayloadArgs($data);
        if ($data_payload != null) {
            $array = json_decode($data_payload, true);
            if (!isset($array[COMMAND_PAYLOAD])) return false;
            switch ($array[COMMAND_PAYLOAD]) {
                case BACK_PAYLOAD:
                    $this->correctBack($user_id, $db);
                    break;
                default:
                    return false;
            }
            return true;
        }
        return false;
    }

    private function setCurrentName($user_id, $name, $db)
    {
        $user = new User($db);
        $user->id = $user_id;
        $user->getSingleUser();
        $user->updateStateWithArgs(SET_FIELD_VALUE_STATE, addNameFieldToJson($user->stateArgs, $name));

        $output_message = sprintf(FIELD_INPUT_VALUE, $name);
        vkApi_messagesSend($user_id, $output_message, INPUT_VALUE_FIELD_KEYBOARD);
    }
}