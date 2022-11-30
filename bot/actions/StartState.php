<?php

class StartState extends BotState
{
    public function stateAction($user_id, $data, $db)
    {
        if ($this->payloadSwitch($user_id, $data, $db)) return;

        if ($this->billOpenTry($user_id, $data["message"]["text"], $db)) return;
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
                case PREV_PAGE_BILL_PAYLOAD:
                    $this->prevPage($user_id, $array, $db);
                    break;
                case NEXT_PAGE_BILL_PAYLOAD:
                    $this->nextPage($user_id, $array, $db);
                    break;
                case OPEN_BILL_PAYLOAD:
                    $this->openBill($user_id, $array, $db);
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
        vkApi_messagesSend($user_id, START_SHOW_BILLS_FOR_USER, $this->keyboard);
        if (count($bill_name_list) === 0)
            vkApi_messagesSend($user_id, START_SHOW_BILLS_FOR_EMPTY, $this->keyboard);
        else {
            $result = '';
            foreach ($bill_name_list as $curr_id => $curr_label) {
                $result = $result . '[' . $curr_id . ']: ' . $curr_label . "\n";
            }
            vkApi_messagesSend($user_id, $result, $this->keyboard);
        }
    }

    private function startCreateUserBills($user_id, $db)
    {
        $user = new User($db);
        $user->id = $user_id;
        $user->updateState(SET_BILL_NAME_STATE);
        vkApi_messagesSend($user_id, INPUT_NAME_MESSAGE, CREATE_BILL_INPUT);
    }

    private function billOpenTry($user_id, $message, $db): bool
    {
        $user = new User($db);
        $user->id = $user_id;
        $user->getSingleUser();
        $bill_id_list = json_decode($user->bills, true);
        if (in_array($message, $bill_id_list)) {
            vkApi_messagesSend($user_id, "INPUT_NAME_MESSAGE", $this->keyboard);
            return true;
        }
        return false;
    }

    private function prevPage($user_id, $array, $db)
    {
        vkApi_messagesSend($user_id, DEVELOP_MESSAGE, $this->keyboard);
    }

    private function nextPage($user_id, $array, $db)
    {
        vkApi_messagesSend($user_id, DEVELOP_MESSAGE, $this->keyboard);
    }

    private function openBill($user_id, $array, $db)
    {
        vkApi_messagesSend($user_id, DEVELOP_MESSAGE, $this->keyboard);
    }
}