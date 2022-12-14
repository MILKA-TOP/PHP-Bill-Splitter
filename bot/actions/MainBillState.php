<?php

class MainBillState extends BotState
{
    public function stateAction($user_id, $data, $db)
    {
        if ($this->payloadSwitch($user_id, $data, $db)) return;

        switch ($this->getMessageOrEmpty($data)) {
            default:
                vkApi_messagesSend($user_id, ERROR_MAIN_MESSAGE, $this->keyboard);
        }
    }

    private function payloadSwitch($user_id, $data, $db): bool
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
                case OPEN_BILL_PAYLOAD:
                    $this->showBillData($user_id, $db);
                    break;
                case BILL_ADD_FIELD_PAYLOAD:
                    $this->addNewFieldToBill($user_id, $db);
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

    private function addNewFieldToBill($user_id, $db)
    {
        InputPersonsForFieldsState::showPersonTable($user_id, $db);
    }

    private function showBillData($user_id, $db)
    {
        $user = new User($db);
        $user->id = $user_id;
        $user->getSingleUser();
        $bill_id = json_decode($user->stateArgs, true)[BILL_ID_STATE_ARG];

        $this->toMainBillMenuState($user_id, $db, $bill_id);
    }

    private function showAllBills($user_id, $db)
    {
        $user = new User($db);
        $user->id = $user_id;
        $user->getSingleUser();
        $bill_id = json_decode($user->stateArgs, true)[BILL_ID_STATE_ARG];

        $bill = new Bill($db);
        $bill->id = $bill_id;
        $bill->getPersonsByCache();
        $persons = json_decode($bill->persons, true);
        $group_bill_value = 0.0;
        foreach ($persons as $curr_id) {
            $group_bill_value += $this->sendPersonBill($user_id, $bill_id, $curr_id, $db);
        }
        vkApi_messagesSend($user_id, sprintf(BILL_FINAL_GROUP_ALL_STRING, $group_bill_value), $this->keyboard);
    }

    private function sendPersonBill($user_id, $bill_id, $person_id, $db)
    {
        $output_value = 0.0;
        $item_list_string = "";

        $person = new Person($db);
        $person->id = $person_id;
        $person->getSinglePerson();

        $single_bill = new SingleBill($db);
        $full_single_bill_list = $single_bill->getPersonsSingleBillList($bill_id);
        $used_single_bill_ids = [];

        foreach ($full_single_bill_list as $currSingleId => $currPersons) {
            if (in_array($person_id, $currPersons)) {
                $used_single_bill_ids[] = $currSingleId;
            }
        }

        foreach ($used_single_bill_ids as $currSingleId) {
            $single_bill->id = $currSingleId;
            $single_bill->getSingleBill();
            $single_bill_persons_count = count(json_decode($single_bill->persons, true));

            $format_field_line = FIELD_FORMAT_BY_BOOL_ARRAY[$single_bill->isPersonField];
            $output_value += $single_bill->fullValue;

            $field = new Field($db);
            $fields_ids = $field->getFieldsIdsBySingleBillId($currSingleId);

            foreach ($fields_ids as $currFieldId) {
                $field->id = $currFieldId;
                $field->getSingleField();

                $item_list_string = $item_list_string . sprintf(
                        $format_field_line,
                        $field->name,
                        $field->price / $single_bill_persons_count);
            }
        }

        $output_message = sprintf(BILL_FINAL_STRING, $person->name, $item_list_string, $output_value);
        vkApi_messagesSend($user_id, $output_message, $this->keyboard);
        return $output_value;
    }

    private function showSingleBill($user_id, $db)
    {
        vkApi_messagesSend($user_id, DEVELOP_MESSAGE, $this->keyboard);
    }

}