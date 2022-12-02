<?php


class InputFieldValueState extends BotState
{
    function stateAction($user_id, $data, $db)
    {
        if ($this->payloadSwitch($user_id, $data, $db)) return;

        $this->setCurrentValue($user_id, $data["message"]["text"], $db);
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
                case RENAME_FIELD_PAYLOAD:
                    $this->toInputFieldNameState($user_id, $db);
                    break;
                default:
                    return false;
            }
            return true;
        }
        return false;
    }

    private function setCurrentValue($user_id, $value, $db)
    {
        vkApi_messagesSend($user_id, DEVELOP_MESSAGE, $this->keyboard);
    }

}