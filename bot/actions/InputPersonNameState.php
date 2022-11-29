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
                case PREV_PAGE_PAYLOAD:
                    $this->prevPage($user_id, $db);
                    break;
                case NEXT_PAGE_PAYLOAD:
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

            $max_page_number = $this->maxPageNumber($name_array_full);
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
            $max_page_number = $this->maxPageNumber($name_array_full);
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
        vkApi_messagesSend($user_id, DEVELOP_MESSAGE, $this->keyboard);
    }

    private function removePerson($user_id, $payload, $db)
    {
        $remove_person_name = $payload[REMOVE_PERSON_NAME_STATE_ARG];

        $user = new User($db);
        $user->id = $user_id;
        $user->getSingleUser();
        $state_args = json_decode($user->stateArgs, true);
        $persons_names = $state_args[PERSON_NAME_STATE_ARG];

        if (!in_array($remove_person_name, $persons_names)) {
            vkApi_messagesSend($user_id, ERROR_MASSAGE_PERSON_REMOVE_NAME, $this->keyboard);
            return;
        }
        vkApi_messagesSend($user_id, print_r($persons_names, true), $this->keyboard);

        unset($persons_names[$remove_person_name]);
        vkApi_messagesSend($user_id, print_r($persons_names, true), $this->keyboard);

        $name_array_full = removePersonNameFieldToJson($user->stateArgs, $remove_person_name);
        $max_page_number = $this->maxPageNumber($persons_names);
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

        $max_page_number = $this->maxPageNumber($name_array_full);
        $current_page = $max_page_number;

        $this->showMessageWithCorrectPersonsList($name_array_full,
            $current_page, $max_page_number, $updated_person_list_json, $user, $user_id
        );
    }

    private function maxPageNumber($array): int
    {
        return intdiv(count($array) - 1, MAX_INLINE_BUTTONS_COUNT);
    }

    private function lastArrayRanges($array, $page): array
    {
        return array_slice($array, $page * MAX_INLINE_BUTTONS_COUNT, MAX_INLINE_BUTTONS_COUNT);
    }

    private function containsNextPage($array, $page, $max_page): bool
    {
        return $page !== $max_page;
    }

    private function containsPrevPage($array, $page): bool
    {
        return $page !== 0;
    }

    private function showMessageWithCorrectPersonsList($name_array_full, int $current_page, int $max_page_number, $updated_person_list_json, User $user, $user_id)
    {
        $name_array_cut = $this->lastArrayRanges($name_array_full, $current_page);
        $contains_prev_page = $this->containsPrevPage($name_array_full, $current_page);
        $contains_next_page = $this->containsNextPage($name_array_full, $current_page, $max_page_number);

        $updated_person_list_json = addPersonPageNumberFieldToJson($updated_person_list_json, $current_page);

        $user->updateStateWithArgs(
            SET_BILL_PERSONS_STATE,
            $updated_person_list_json
        );
        $inline_keyboard_generated = arrayOfPersonButtons($name_array_cut, $contains_prev_page, $contains_next_page);
        vkApi_messagesSend($user_id, INPUT_PERSONS_BILL_LIST_MESSAGE, $inline_keyboard_generated);
    }


}