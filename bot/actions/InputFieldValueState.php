<?php


class InputFieldValueState extends BotState
{
    function stateAction($user_id, $data, $db)
    {
        if ($this->payloadSwitch($user_id, $data, $db)) return;

        $this->checkCurrentValue($user_id, $this->getMessageOrEmpty($data), $db);
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

    private function checkCurrentValue($user_id, $value, $db)
    {
        if (is_numeric($value)) {
            $double_val = doubleval($value);
            if ($double_val >= 0) {
                $this->setCurrentValue($user_id, $double_val, $db);
                return;
            }
        }
        vkApi_messagesSend($user_id, ERROR_FIELD_VALUE_INCORRECT, $this->keyboard);
    }

    private function setCurrentValue($user_id, $double_val, $db)
    {
        $user = new User($db);
        $user->id = $user_id;
        $user->getSingleUser();

        $state_args_array = json_decode($user->stateArgs, true);
        $single_bill_id = $state_args_array[SINGLE_BILL_ID_STATE_ARG];
        $field_name = $state_args_array[BILL_NAME_STATE_ARG];
        $go_to_main_bill = $state_args_array[SINGLE_BILL_TO_MAIN_MENU_RETURN_STATE_ARG];

        $single_bill = new SingleBill($db);
        $single_bill->id = $single_bill_id;
        $single_bill->getSingleBill();

        $field = new Field($db);
        $field->name = $field_name;
        $field->price = $double_val;
        $field->singleBillId = $single_bill_id;
        $field->billId = $single_bill->billId;
        $field->createField();

        $single_bill->updateFullValue($double_val);

        if ($go_to_main_bill) {
            $this->toMainBillMenuState($user_id, $db, $single_bill->billId);
        } else {
            MainSingleBillState::showSingleBillData($user_id, $single_bill_id, $db);
        }
    }

}