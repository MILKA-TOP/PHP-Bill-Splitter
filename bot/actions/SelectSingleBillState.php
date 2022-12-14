<?php

class SelectSingleBillState extends BotState
{
    public function stateAction($user_id, $data, $db)
    {
        if ($this->payloadSwitch($user_id, $data, $db)) return;

        $message = $this->getMessageOrEmpty($data);
        $this->checkSingleBillIdContains($user_id, $message, $db);
    }

    private function payloadSwitch($user_id, $data, $db): bool
    {
        $data_payload = $this->getPayloadArgs($data);
        if ($data_payload != null) {
            $array = json_decode($data_payload, true);
            if (!isset($array[COMMAND_PAYLOAD])) return false;
            switch ($array[COMMAND_PAYLOAD]) {
                case BILL_CREATE_SINGLE_BILL_PAYLOAD:
                    $this->createNewSingleBill($user_id, $db);
                    break;
                case BACK_PAYLOAD:
                    $this->backToBillMenu($user_id, $db);
                    break;
                case SINGLE_BILL_SHOW_ALL_GROUPS:
                    sendSingleBillListMessage($user_id, $db);
                    break;
                default:
                    return false;
            }
            return true;
        }
        return false;
    }

    private function createNewSingleBill($user_id, $db)
    {
        CreateNewSingleBill::showPersonTable($user_id, $db);
    }

    private function checkSingleBillIdContains($user_id, $text, $db)
    {
        $single_bill = new SingleBill($db);
        $bill_id = getSingleBillPersonIds($user_id, $db)[0];
        $single_bill_ids = $single_bill->getSingleBillIds($bill_id);

        log_msg(print_r($single_bill_ids, true));
        if (in_array($text, $single_bill_ids)) {
            MainSingleBillState::showSingleBillData($user_id, $text, $db);
        } else {
            vkApi_messagesSend($user_id, SELECT_SINGLE_BILL_INFO_INCORRECT_MESSAGE, $this->keyboard);
        }
    }

}