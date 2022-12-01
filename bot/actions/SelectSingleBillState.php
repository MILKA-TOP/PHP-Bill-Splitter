<?php

class SelectSingleBillState extends BotState
{
    public function stateAction($user_id, $data, $db)
    {
        if ($this->payloadSwitch($user_id, $data, $db)) return;

        $this->checkSingleBillIdContains($user_id, $data["message"]["text"], $db);
    }

    private function payloadSwitch($user_id, $data, $db)
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
        vkApi_messagesSend($user_id, DEVELOP_MESSAGE, $this->keyboard);
    }

    private function backToBillMenu($user_id, $db)
    {
        $user = new User($db);
        $user->id = $user_id;
        $user->updateState(MAIN_BILL_STATE);
        vkApi_messagesSend($user_id, BACK_TO_BILL_MENU_MESSAGE, BILL_MAIN_KEYBOARD);
    }

    private function checkSingleBillIdContains($user_id, $text, $db)
    {
        $user = new User($db);
        $user->id = $user_id;
        $user->getSingleUser();
        $bill_id = json_decode($user->stateArgs, true)[BILL_ID_STATE_ARG];

        $bill = new Bill($db);
        $bill->id = $bill_id;
        $bill->getSingleBill();
        $persons_ids = json_decode($bill->persons, true);

        $singleBill = new SingleBill($db);
        $singleBillArray = $singleBill->getPersonsBillList($bill_id);
        $single_bill_id_array = getIdArrayFromSingleBillArray($singleBillArray);

        if (in_array($text, $single_bill_id_array)) {
            vkApi_messagesSend($user_id, DEVELOP_MESSAGE, $this->keyboard);
        } else {
            vkApi_messagesSend($user_id, SELECT_SINGLE_BILL_INFO_INCORRECT_MESSAGE, $this->keyboard);
        }
    }

}