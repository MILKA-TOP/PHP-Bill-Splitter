<?php


class InputBillIdState extends BotState
{
    function stateAction($user_id, $data, $db)
    {
        if ($this->payloadSwitch($user_id, $data, $db)) return;

        $message = $this->getMessageOrEmpty($data);
        $this->checkId($user_id, $message, $db);
    }

    private function payloadSwitch($user_id, $data, $db): bool
    {
        $data_payload = $this->getPayloadArgs($data);
        if ($data_payload != null) {
            $array = json_decode($data_payload, true);
            if (!isset($array[COMMAND_PAYLOAD])) return false;
            switch ($array[COMMAND_PAYLOAD]) {
                case BACK_PAYLOAD:
                    $this->toStartMenuState($user_id, $db);
                    break;
                default:
                    return false;
            }
            return true;
        }
        return false;
    }

    private function checkId($user_id, $message, $db)
    {
        $bill = new Bill($db);
        $bill->id = $message;
        $bill->getSingleBill();

        if (is_null($bill->adminId)) {
            vkApi_messagesSend($user_id, UNKNOWN_BILL_ID_ERROR, $this->keyboard);
        } else {
            vkApi_messagesSend($user_id, DEVELOP_MESSAGE, $this->keyboard);
        }
    }

}