<?php


class InputPersonNameState extends PersonPageChooserModel
{
    function stateAction($user_id, $data, $db)
    {
        if ($this->payloadSwitch($user_id, $data, $db)) return;

        $input_name = $this->getMessageOrEmpty($data);;
        if (strlen($input_name) > 0 && strlen($input_name) < BILL_NAME_MAX_SIZE) {
            $this->addPersonToArgs($user_id, $input_name, $db);
        } else {
            vkApi_messagesSend($user_id, ERROR_MESSAGE_PERSON_INPUT, $this->keyboard);
        }
    }

    private function payloadSwitch($user_id, $data, $db)
    {
        $data_payload = $this->getPayloadArgs($data);
        if (!empty($data_payload)) {
            $array = json_decode($data_payload, true);
            if (!isset($array[COMMAND_PAYLOAD])) return false;
            switch ($array[COMMAND_PAYLOAD]) {
                case CANCEL_PAYLOAD:
                    $this->toStartMenuState($user_id, $db);
                    break;
                case CONFIRM_PAYLOAD:
                    $this->creatingBill($user_id, $db);
                    break;
                case REMOVE_PERSON_PAYLOAD:
                    $this->removePerson($user_id, $array, $db);
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

    private function addPersonToArgs($user_id, $name, $db)
    {
        $user = new User($db);
        $user->id = $user_id;
        $user->getSingleUser();

        $updated_person_list_json = addPersonNameFieldToJson($user->stateArgs, $name);
        $updated_person_array = json_decode($updated_person_list_json, true);

        $name_array_full = array();
        if (isset($updated_person_array[PERSON_NAME_STATE_ARG])) {
            $name_array_full = $updated_person_array[PERSON_NAME_STATE_ARG];
        }

        if (count($name_array_full) !== count(array_unique($name_array_full))) {
            vkApi_messagesSend($user_id, ERROR_MASSAGE_PERSON_SAME_NAME, $this->keyboard);
            return;
        }

        $max_page_number = maxPageNumber($name_array_full);
        $current_page = $max_page_number;

        $this->showMessageWithCorrectPersonsList($name_array_full,
            $current_page, $max_page_number, $updated_person_list_json, $user, $user_id
        );
    }

    private function showMessageWithCorrectPersonsList($name_array_full, int $current_page, int $max_page_number, $updated_person_list_json, User $user, $user_id)
    {
        $name_array_cut = lastArrayRanges($name_array_full, $current_page);
        $contains_prev_page = containsPrevPage($name_array_full, $current_page);
        $contains_next_page = containsNextPage($name_array_full, $current_page, $max_page_number);

        $updated_person_list_json = addPersonPageNumberFieldToJson($updated_person_list_json, $current_page);

        $user->updateStateWithArgs(
            SET_BILL_PERSONS_STATE,
            $updated_person_list_json
        );

        $inline_keyboard_generated = arrayOfPersonButtons(array_combine(
            $name_array_cut, $name_array_cut),
            $contains_prev_page, $contains_next_page
        );
        vkApi_messagesSend($user_id, INPUT_PERSONS_BILL_LIST_MESSAGE, $inline_keyboard_generated);
    }

}