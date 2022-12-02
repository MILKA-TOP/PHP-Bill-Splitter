<?php


class InputSingleBillNameState extends BotState
{
    function stateAction($user_id, $data, $db)
    {
        if ($this->payloadSwitch($user_id, $data, $db)) return;

        $input_name = $data["message"]["text"];
        if (strlen($input_name) > 0 && strlen($input_name) < FIELD_NAME_MAX_SIZE) {
            $this->setCurrentName($user_id, $input_name, $db);
        } else {
            vkApi_messagesSend($user_id, INPUT_NAME_INCORRECT_MESSAGE, $this->keyboard);
        }
    }

    private function payloadSwitch($user_id, $data, $db)
    {
        $data_payload = $this->getPayloadArgs($data);
        if ($data_payload != null) {
            $array = json_decode($data_payload, true);
            if (!isset($array[COMMAND_PAYLOAD])) return false;
            switch ($array[COMMAND_PAYLOAD]) {
                case BACK_PAYLOAD:
                    $this->toMainSingleBillState($user_id, $db);
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
        vkApi_messagesSend($user_id, DEVELOP_MESSAGE, $this->keyboard);
    }

}