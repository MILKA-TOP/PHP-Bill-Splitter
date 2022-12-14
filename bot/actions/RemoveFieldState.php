<?php

class RemoveFieldState extends BotState
{

    static function showSingleBillData($user_id, $db)
    {
        $user = new User($db);
        $user->id = $user_id;
        $user->getSingleUser();
        $single_bill_id = json_decode($user->stateArgs, true)[SINGLE_BILL_ID_STATE_ARG];


        $singleBill = new SingleBill($db);
        $singleBill->id = $single_bill_id;
        $singleBill->getSingleBill();

        $field = new Field($db);
        $fields_id_array = $field->getFieldsIdsBySingleBillId($single_bill_id);

        $field = new Field($db);
        $field_name_array = $field->getFieldsNamesList($fields_id_array);
        $field_value_array = $field->getFieldsValuesList($fields_id_array);
        $fields_string = MainSingleBillState::formattedFieldsList($field_name_array, $field_value_array);

        $user->updateState(REMOVE_FIELD_STATE);
        vkApi_messagesSend($user_id, sprintf(REMOVE_FIELD_MESSAGE, $fields_string), REMOVE_FIELD_KEYBOARD);
    }

    public function stateAction($user_id, $data, $db)
    {
        if ($this->payloadSwitch($user_id, $data, $db)) return;

        $message = $this->getMessageOrEmpty($data);
        $this->checkSingleBillIdContains($user_id, $message, $db);
    }

    private function payloadSwitch($user_id, $data, $db)
    {
        $data_payload = $this->getPayloadArgs($data);
        if ($data_payload != null) {
            $array = json_decode($data_payload, true);
            if (!isset($array[COMMAND_PAYLOAD])) return false;
            switch ($array[COMMAND_PAYLOAD]) {
                case BACK_PAYLOAD:
                    $this->toMainSingleBillState($user_id, $db);
                    break;
                default:
                    return false;
            }
            return true;
        }
        return false;
    }

    private function checkSingleBillIdContains($user_id, $text, $db)
    {
        $user = new User($db);
        $user->id = $user_id;
        $user->getSingleUser();
        $singleBillId = json_decode($user->stateArgs, true)[SINGLE_BILL_ID_STATE_ARG];

        $singleBill = new SingleBill($db);
        $singleBill->id = $singleBillId;
        $singleBill->getSingleBill();

        $field = new Field($db);
        $fieldsIdArray = $field->getFieldsIdsBySingleBillId($singleBillId);

        if (in_array($text, $fieldsIdArray)) {
            $field = new Field($db);
            $field->id = $text;
            $field->getSingleField();
            $singleBill->updateFullValue(-$field->price);
            $field->removeField();
            MainSingleBillState::showSingleBillData($user_id, $text, $db);
        } else {
            vkApi_messagesSend($user_id, SELECT_SINGLE_BILL_INFO_INCORRECT_MESSAGE, $this->keyboard);
        }
    }

}