<?php

class StartState extends BotState
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
                case CREATE_BILL_PAYLOAD:
                    $this->startCreateUserBills($user_id, $db);
                    break;
                case SHOW_BILLS_PAYLOAD:
                    $this->showUserBills($user_id, $db);
                    break;
                case HELP_PAYLOAD:
                    vkApi_messagesSend($user_id, START_MESSAGE, $this->keyboard);
                    break;
                default:
                    return false;
            }
            return true;
        }
        return false;
    }

    private function showUserBills($user_id, $db)
    {
        $user = new User($db);
        $user->id = $user_id;
        $user->getSingleUser();

        $bill = new Bill($db);
        $bill_id_list = json_decode($user->bills, true);
        $bill_name_list = $bill->getNameBillList($bill_id_list);
        vkApi_messagesSend($user_id, print_r($bill_name_list, true), $this->keyboard);
    }

    private function startCreateUserBills($user_id, $db)
    {
        $user = new User($db);
        $user->id = $user_id;
        $user->updateState(SET_BILL_NAME_STATE);
        vkApi_messagesSend($user_id, INPUT_NAME_MESSAGE, CREATE_BILL_INPUT);
    }
}