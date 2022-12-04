<?php


class InputPersonsForFieldsState extends PersonPageChooserModel
{

    const STATE_ID = SELECT_PERSONS_FOR_SINGLE_BILL;

    static function showPersonTable($user_id, $db)
    {
        $user = new User($db);
        $user->id = $user_id;
        $user->getSingleUser();
        $updated_json = setJsonChoosePersons($user->stateArgs);

        PersonPageChooserModel::sendInlineKeyboard($user_id, $db, $updated_json, InputPersonsForFieldsState::STATE_ID);
        vkApi_messagesSend($user_id, InputPersonsForFieldsState::STATE_ID, SINGLE_BILL_CREATE_KEYBOARD);
    }

    function stateAction($user_id, $data, $db)
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
                    $this->personClick($user_id, $array, $db, InputPersonsForFieldsState::STATE_ID);
                    break;
                case PREV_PAGE_NAME_PAYLOAD:
                    $this->prevPage($user_id, $db, InputPersonsForFieldsState::STATE_ID);
                    break;
                case NEXT_PAGE_NAME_PAYLOAD:
                    $this->nextPage($user_id, $db, InputPersonsForFieldsState::STATE_ID);
                    break;
                default:
                    return false;
            }
            return true;
        }
        return false;
    }

    private function tryCreatingSingleBill($user_id, $db)
    {
        $user = new User($db);
        $user->id = $user_id;
        $user->getSingleUser();

        $arg_array = json_decode($user->stateArgs, true);
        $selected_persons_ids = $arg_array[SINGLE_PERSONS_STATE_ARG];
        $bill_id = $arg_array[BILL_ID_STATE_ARG];
        sort($selected_persons_ids);

        $single_bill = new SingleBill($db);
        $singleBillIdToPersonsArray = $single_bill->getPersonsSingleBillList($bill_id);
        $singleBillId = -1;
        if (!$selected_persons_ids) {
            vkApi_messagesSend($user_id, SINGLE_BILL_EMPTY_SELECTED, $this->keyboard);
        } else if (in_array($selected_persons_ids, $singleBillIdToPersonsArray)) {
            $singleBillId = array_search($selected_persons_ids, $singleBillIdToPersonsArray);
        } else {
            $single_bill->fullValue = 0.0;
            $single_bill->isPersonField = 0;
            $single_bill->billId = $bill_id;
            $single_bill->persons = arrayToJson($selected_persons_ids);
            $single_bill->createSingleBill();
            $singleBillId = $single_bill->id;
        }


        if ($singleBillId != -1) {
            $user->updateStateWithArgs(
                SET_FIELD_NAME_STATE,
                setSingleBillJson($user->stateArgs, $singleBillId, true)
            );
            $this->toInputFieldNameState($user_id, $db);
        }
    }

}