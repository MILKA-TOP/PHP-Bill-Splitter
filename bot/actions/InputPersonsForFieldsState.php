<?php


class InputPersonsForFieldsState extends PersonPageChooserModel
{
    function stateAction($user_id, $data, $db)
    {
        if ($this->payloadSwitch($user_id, $data, $db)) return;

        vkApi_messagesSend($user_id, CONFIRM_INPUT_NAME_INCORRECT_MESSAGE, $this->keyboard);
    }

    private function payloadSwitch($user_id, $data, $db): bool
    {
        $data_payload = $this->getPayloadArgs($data);
        if (!empty($data_payload)) {
            $array = json_decode($data_payload, true);
            if (!isset($array[COMMAND_PAYLOAD])) return false;
            switch ($array[COMMAND_PAYLOAD]) {
                case BACK_PAYLOAD:
                    $this->toSingleBillList($user_id, $db);
                    break;
                case BILL_CREATE_SINGLE_BILL_PAYLOAD:
                    $this->tryCreatingSingleBill($user_id, $db);
                    break;
                case CHANGE_PERSON_STATE_SINGLE_BILL_PAYLOAD:
                    $this->personClick($user_id, $array, $db);
                    break;
                case PREV_PAGE_NAME_PAYLOAD:
                    $this->prevPage($user_id, $db);
                    break;
                case NEXT_PAGE_NAME_PAYLOAD:
                    $this->nextPage($user_id, $db);
                    break;
                default:
                    return false;
            }
            return true;
        }
        return false;
    }

}