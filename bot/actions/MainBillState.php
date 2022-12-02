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
                    $this->toSingleBillList($user_id, $db);
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
        $user = new User($db);
        $user->id = $user_id;
        $user->getSingleUser();
        $bill_id = json_decode($user->stateArgs, true)[BILL_ID_STATE_ARG];

        $bill = new Bill($db);
        $bill->id = $bill_id;
        $bill->getSingleBill();
        $persons = json_decode($bill->persons, true);
        log_msg(print_r($persons, true));
        foreach ($persons as $curr_id) {
            $this->sendPersonBill($user_id, $bill_id, $curr_id, $db);
        }

    }

    private function sendPersonBill($user_id, $bill_id, $person_id, $db)
    {
        $output_value = 0.0;
        $item_list_string = "";

        $person = new Person($db);
        $person->id = $person_id;
        $person->getPerson();

        $single_bill = new SingleBill($db);
        $full_single_bill_list = $single_bill->getPersonsSingleBillList($bill_id);
        $used_single_bill_ids = [];
        log_msg(print_r($full_single_bill_list, true));

        foreach ($full_single_bill_list as $currSingleId => $currPersons) {
            if (in_array($person_id, $currPersons)) {
                $used_single_bill_ids[] = $currSingleId;
            }
        }
        log_msg(print_r($used_single_bill_ids, true));

        foreach ($used_single_bill_ids as $currSingleId) {
            $single_bill->id = $currSingleId;
            $single_bill->getSingleBill();

            $format_field_line = FIELD_FORMAT_BY_BOOL_ARRAY[$single_bill->isPersonField];
            $output_value += $single_bill->fullValue;

            $field = new Field($db);
            $fields_ids = $field->getFieldsIdsBySingleBillId($currSingleId);

            foreach ($fields_ids as $currFieldId) {
                $field->id = $currFieldId;
                $field->getField();

                $item_list_string = $item_list_string . sprintf($format_field_line, $field->name, $field->price);
            }
        }

        $output_message = sprintf(BILL_FINAL_STRING, $person->name, $item_list_string, $output_value);
        vkApi_messagesSend($user_id, $output_message, $this->keyboard);
    }

    private function showSingleBill($user_id, $db)
    {
        vkApi_messagesSend($user_id, DEVELOP_MESSAGE, $this->keyboard);
    }

}