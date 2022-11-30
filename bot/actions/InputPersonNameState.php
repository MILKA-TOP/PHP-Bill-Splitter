<?php


class InputPersonNameState extends BotState
{
    function stateAction($user_id, $data, $db)
    {
        if ($this->payloadSwitch($user_id, $data, $db)) return;

        $input_name = $data["message"]["text"];
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

    private function prevPage($user_id, $db)
    {
        $user = new User($db);
        $user->id = $user_id;
        $user->getSingleUser();
        $state_args = json_decode($user->stateArgs, true);
        if (isset($state_args[PAGE_NUMBER_PERSON_STATE_ARG])) {
            $name_array_full = array();
            $current_page = $state_args[PAGE_NUMBER_PERSON_STATE_ARG];
            if (isset($state_args[PERSON_NAME_STATE_ARG])) $name_array_full = $state_args[PERSON_NAME_STATE_ARG];

            $max_page_number = maxPageNumber($name_array_full);
            if ($current_page <= 0) {
                vkApi_messagesSend($user_id, ERROR_MAIN_MESSAGE, $this->keyboard);
                return;
            }

            $current_page = $current_page - 1;
            $state_args_json = $user->stateArgs;
            $this->showMessageWithCorrectPersonsList($name_array_full,
                $current_page, $max_page_number, $state_args_json, $user, $user_id
            );
            return;
        }

        vkApi_messagesSend($user_id, ERROR_MAIN_MESSAGE, $this->keyboard);
    }

    private function nextPage($user_id, $db)
    {
        $user = new User($db);
        $user->id = $user_id;
        $user->getSingleUser();
        $state_args = json_decode($user->stateArgs, true);
        if (isset($state_args[PAGE_NUMBER_PERSON_STATE_ARG])) {
            $name_array_full = array();
            $current_page = $state_args[PAGE_NUMBER_PERSON_STATE_ARG];
            if (isset($state_args[PERSON_NAME_STATE_ARG])) {
                $name_array_full = $state_args[PERSON_NAME_STATE_ARG];
            }
            $max_page_number = maxPageNumber($name_array_full);
            if ($current_page >= $max_page_number) {
                vkApi_messagesSend($user_id, ERROR_MAIN_MESSAGE, $this->keyboard);
                return;
            }

            $current_page = $current_page + 1;
            $state_args_json = $user->stateArgs;
            $this->showMessageWithCorrectPersonsList($name_array_full,
                $current_page, $max_page_number, $state_args_json, $user, $user_id
            );
            return;
        }
        vkApi_messagesSend($user_id, ERROR_MAIN_MESSAGE, $this->keyboard);
    }

    private function creatingBill($user_id, $db)
    {
        $user = new User($db);
        $user->id = $user_id;
        $user->getSingleUser();
        $state_args = json_decode($user->stateArgs, true);
        $persons_names = $state_args[PERSON_NAME_STATE_ARG];
        if (count($persons_names) === 0) {
            vkApi_messagesSend($user_id, ERROR_MESSAGE_PERSON_ZERO_LIST_INPUT, $this->keyboard);
            return;
        }

        // Create bill;
        $billId = $this->createMainBill($user_id, $state_args, $db);

        // Crate persons
        $persons_id_array = $this->createPersons($user_id, $state_args, $billId, $db);
        // Add persons to bill;
        $this->addPersonsToBill($user_id, $persons_id_array, $billId, $db);
        // Create single bills;
        $single_bill_id_array = $this->createSingleBills($user_id, $persons_id_array, $billId, $db);
        // Add singleBillsToBill;
        $this->addSingleBillsToBill($user_id, $single_bill_id_array, $billId, $db);
        // Connect bill to User;
        $this->updateUserBillList($user_id, $billId, $db);
        // navigate to create;

        vkApi_messagesSend($user_id, DEVELOP_MESSAGE, $this->keyboard);
    }

    private function removePerson($user_id, $payload, $db)
    {
        $remove_person_name = $payload[ACTION_STATE_PAYLOAD_ARG];

        $user = new User($db);
        $user->id = $user_id;
        $user->getSingleUser();
        $state_args = json_decode($user->stateArgs, true);
        $persons_names = $state_args[PERSON_NAME_STATE_ARG];

        if (!in_array($remove_person_name, $persons_names)) {
            vkApi_messagesSend($user_id, ERROR_MASSAGE_PERSON_REMOVE_NAME, $this->keyboard);
            return;
        }

        unset($persons_names[array_search($remove_person_name, $persons_names)]);

        $name_array_full = removePersonNameFieldToJson($user->stateArgs, $remove_person_name);
        $max_page_number = maxPageNumber($persons_names);
        $this->showMessageWithCorrectPersonsList($persons_names,
            $max_page_number, $max_page_number, $name_array_full, $user, $user_id
        );
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


    private function createMainBill($user_id, $bill_data, $db)
    {
        $bill = new Bill($db);
        $bill->adminId = $user_id;
        $bill->password = $bill_data[PASSWORD_STATE_ARG];
        $bill->name = $bill_data[BILL_NAME_STATE_ARG];
        $bill->persons = EMPTY_JSON_ARRAY;
        $bill->singleBillsIds = EMPTY_JSON_ARRAY;

        $bill->createBill();
        return $bill->id;
    }

    private function createPersons($user_id, $bill_data, $bill_id, $db)
    {
        $person = new Person($db);
        $person_names = $bill_data[PERSON_NAME_STATE_ARG];
        $person_id_array = [];

        foreach ($person_names as $value) {
            $person->name = $value;
            $person->singleBillsIds = EMPTY_JSON_ARRAY;
            $person->billId = $bill_id;
            $person->createPerson();
            $person_id_array[] = $person->id;
        }

        return $person_id_array;
    }

    private function addPersonsToBill($user_id, array $persons_id_array, $billId, $db)
    {
        $bill = new Bill($db);
        $bill->id = $billId;
        $bill->updatePersonId(arrayToJson($persons_id_array));
    }

    private function createSingleBills($user_id, array $persons_id_array, $billId, $db)
    {
        $single_bill = new SingleBill($db);
        $single_bill_id_array = [];

        foreach ($persons_id_array as $value) {
            $single_bill->billId = $billId;
            $single_bill->persons = arrayToJson([$value]);
            $single_bill->fields = EMPTY_JSON_ARRAY;
            $single_bill->isPersonField = 1;
            $single_bill->fullValue = 0.0;
            $single_bill->createSingleBill();

            $single_bill_id_array[] = $single_bill->id;
        }

        return $single_bill_id_array;
    }

    private function addSingleBillsToBill($user_id, array $single_bill_id_array, $billId, $db)
    {
        $bill = new Bill($db);
        $bill->id = $billId;
        $bill->updateSingleBillId(arrayToJson($single_bill_id_array));
    }

    private function updateUserBillList($user_id, $billId, $db)
    {
        $user = new User($db);
        $user->id = $user_id;
        $user->getSingleUser();

        $updated_array_json = addElementToJsonArray($user->bills, $billId);
        $user->updateBillIdsArray($updated_array_json);
    }

}