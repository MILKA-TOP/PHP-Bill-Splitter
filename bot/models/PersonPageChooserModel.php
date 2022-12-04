<?php

abstract class PersonPageChooserModel extends BotState
{

    static function sendInlineKeyboard($user_id, $db, $updated_json)
    {
        $user = new User($db);
        $user->id = $user_id;
        $bill_persons = getSingleBillPersonIds($user_id, $db)[1];

        $inline_keyboard = self::getArraysForInlineKeyboard($updated_json, $bill_persons, $db);
        $user->updateStateWithArgs(CREATE_SINGLE_BILL_STATE, $updated_json);
        vkApi_messagesSend($user_id, CHOOSE_PERSONS_FOR_SINGLE_BILL, $inline_keyboard);
    }

    static function idStatusArray($id_person_array, $selected_array): array
    {
        $output_array = [];
        foreach ($id_person_array as $curr_id) {
            $output_array[$curr_id] = in_array($curr_id, $selected_array);
        }
        log_msg(print_r($output_array, true));
        return $output_array;
    }

    protected function prevPage($user_id, $db)
    {
        $user = new User($db);
        $user->id = $user_id;
        $user->getSingleUser();

        $user_args_array = json_decode($user->stateArgs, true);
        $current_page = $user_args_array[PAGE_NUMBER_PERSON_STATE_ARG];
        if ($current_page > 0) {
            $user_args_array[PAGE_NUMBER_PERSON_STATE_ARG] = $current_page - 1;
            self::sendInlineKeyboard($user_id, $db, arrayToJson($user_args_array));
        } else {
            vkApi_messagesSend($user_id, ERROR_MAIN_MESSAGE, $this->keyboard);
        }

    }

    protected function nextPage($user_id, $db)
    {
        $user = new User($db);
        $user->id = $user_id;
        $user->getSingleUser();

        $user_args_array = json_decode($user->stateArgs, true);
        $current_page = $user_args_array[PAGE_NUMBER_PERSON_STATE_ARG];

        $bill = new Bill($db);
        $bill->id = $user_args_array[BILL_ID_STATE_ARG];
        $bill->getSingleBill();
        $max_page = maxPageNumber(json_decode($bill->persons, true));
        if ($current_page < $max_page) {
            $user_args_array[PAGE_NUMBER_PERSON_STATE_ARG] = $current_page + 1;
            self::sendInlineKeyboard($user_id, $db, arrayToJson($user_args_array));
        } else {
            vkApi_messagesSend($user_id, ERROR_MAIN_MESSAGE, $this->keyboard);
        }
    }

    protected function personClick($user_id, $payload, $db)
    {
        $user = new User($db);
        $user->id = $user_id;
        $user->getSingleUser();

        $click_element_id = $payload[ACTION_STATE_PAYLOAD_ARG];
        $updated_element_status = !$payload[SINGLE_BILL_PERSON_STATUS_STATE_PAYLOAD_ARG];

        $update_json = updatePersonsSingleBillArray($user->stateArgs, $click_element_id, $updated_element_status);

        self::sendInlineKeyboard($user_id, $db, $update_json);
        //vkApi_messagesSend($user_id, DEVELOP_MESSAGE, $this->keyboard);
    }

    static function getArraysForInlineKeyboard($json, $personsIds, $db): array
    {
        $json_array = json_decode($json, true);
        $current_page = $json_array[PAGE_NUMBER_PERSON_STATE_ARG];
        $selectedPersons = $json_array[SINGLE_PERSONS_STATE_ARG];

        $is_selected_person_array = self::idStatusArray($personsIds, $selectedPersons);

        $person = new Person($db);
        $person_name_array = $person->getPersonsBillList($personsIds);
        log_msg(print_r($person_name_array, true));

        $max_page_number = maxPageNumber($person_name_array);
        $name_array_cut = lastArrayRanges($person_name_array, $current_page);
        $contains_prev_page = containsPrevPage($person_name_array, $current_page);
        $contains_next_page = containsNextPage($person_name_array, $current_page, $max_page_number);
        log_msg(print_r($name_array_cut, true));

        return arrayOfPersonStatusButtons($name_array_cut,
            $is_selected_person_array, $contains_prev_page, $contains_next_page);
    }
}