<?php

class MainSingleBillState extends BotState
{

    static function showSingleBillData($user_id, $singleBillId, $db)
    {
        $singleBill = new SingleBill($db);
        $singleBill->id = $singleBillId;
        $singleBill->getSingleBill();
        $fields_id_array = json_decode($singleBill->fields, true);

        $person = new Person($db);
        $person_names = $person->getPersonsBillList(json_decode($singleBill->persons, true));

        $field = new Field($db);
        $field_name_array = $field->getFieldsNamesList($fields_id_array);
        $field_value_array = $field->getFieldsValuesList($fields_id_array);
        $fields_string = self::formattedFieldsList($field_name_array, $field_value_array);

        $output_message = sprintf(SINGLE_BILL_REMOVE_POSITION_MESSAGE,
            count($person_names), $singleBill->fullValue, implode(",", $person_names), $fields_string);

        $user = new User($db);
        $user->id = $user_id;
        $user->getSingleUser();
        $user->updateStateWithArgs(MAIN_SINGLE_BILL_STATE, setSingleBillJson($user->stateArgs, $singleBillId));

        vkApi_messagesSend($user_id, $output_message, SINGLE_BILL_DATA_KEYBOARD);
    }

    static function formattedFieldsList($field_name_array, $field_value_array): string
    {
        $output_message = "";

        foreach ($field_name_array as $curr_id => $name) {
            $output_message = $output_message . sprintf(
                    SINGLE_BILL_POSITIONS,
                    $curr_id,
                    $name,
                    $field_value_array[$curr_id]);
        }

        return $output_message;
    }

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
                case SINGLE_BILL_ADD_POSITION_PAYLOAD:
                    $this->addPosition($user_id, $db);
                    break;
                case SINGLE_BILL_REMOVE_POSITION_PAYLOAD:
                    $this->removePosition($user_id, $db);
                    break;
                case BACK_PAYLOAD:
                    $this->toSingleBillList($user_id, $db);
                    break;
                default:
                    return false;
            }
            return true;
        }
        return false;
    }

    private function addPosition($user_id, $db)
    {
        vkApi_messagesSend($user_id, DEVELOP_MESSAGE, $this->keyboard);
    }

    private function removePosition($user_id, $db)
    {
        vkApi_messagesSend($user_id, DEVELOP_MESSAGE, $this->keyboard);
    }

}