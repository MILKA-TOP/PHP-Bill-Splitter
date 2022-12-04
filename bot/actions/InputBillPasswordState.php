<?php


class InputBillPasswordState extends BotState
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
                    $this->correctBack($user_id, $db);
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
        $user = new User($db);
        $user->id = $user_id;
        $user->getSingleUser();
        $bill_id = json_decode($user->stateArgs, true)[BILL_ID_STATE_ARG];

        $bill = new Bill($db);
        $bill->id = $bill_id;
        $bill->getSingleBill();

        if ($bill->password === $message) {
            $this->toMainBillMenuState($user_id, $db, $bill_id);
        } else {
            vkApi_messagesSend($user_id, INCORRECT_PASSWORD_BILL_ERROR, $this->keyboard);
        }
    }

}