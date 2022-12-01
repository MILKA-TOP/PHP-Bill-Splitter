<?php

class MainBillState extends BotState
{
    public function stateAction($user_id, $data, $db)
    {
        if ($this->payloadSwitch($user_id, $data, $db)) return;

        switch ($data["message"]["text"]) {
            default:
                vkApi_messagesSend($user_id, ERROR_MAIN_MESSAGE, $this->keyboard);
        }
    }

    private function payloadSwitch($user_id, $data, $db)
    {
        $data_payload = $this->getPayloadArgs($data);
        if ($data_payload != null) {
            $array = json_decode($data_payload, true);
            if (!isset($array[COMMAND_PAYLOAD])) return false;
            switch ($array[COMMAND_PAYLOAD]) {
                case BILL_SHOW_ALL_PAYLOAD:
                    $this->showAllBills($user_id, $db);
                    break;
                case BILL_CHANGE_SINGLE_BILL_PAYLOAD:
                    $this->updateBill($user_id, $db);
                    break;
                case BILL_SHOW_SINGLE_PAYLOAD:
                    $this->showSingleBill($user_id, $db);
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

    private function showAllBills($user_id, $db)
    {
        vkApi_messagesSend($user_id, DEVELOP_MESSAGE, $this->keyboard);
    }

    private function updateBill($user_id, $db)
    {
        $user = new User($db);
        $user->id = $user_id;
        $user->updateState(SELECT_SINGLE_BILL_STATE);
        $message = sprintf(SELECT_SINGLE_BILL_INFO_MESSAGE, getSingleBillDataString($user_id, $db));
        vkApi_messagesSend($user_id, $message, SINGLE_BILL_CHOOSE_KEYBOARD);
    }

    private function showSingleBill($user_id, $db)
    {
        vkApi_messagesSend($user_id, DEVELOP_MESSAGE, $this->keyboard);
    }

}