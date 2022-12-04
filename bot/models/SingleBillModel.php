<?php

function sendSingleBillListMessage($user_id, $db)
{
    $message = sprintf(SELECT_SINGLE_BILL_INFO_MESSAGE, getSingleBillDataString($user_id, $db));
    vkApi_messagesSend($user_id, $message, SINGLE_BILL_CHOOSE_KEYBOARD);
}

// return [id, [personIds]]
function getSingleBillPersonIds($user_id, $db): array
{
    $user = new User($db);
    $user->id = $user_id;
    $user->getSingleUser();
    $bill_id = json_decode($user->stateArgs, true)[BILL_ID_STATE_ARG];

    $bill = new Bill($db);
    $bill->id = $bill_id;
    $bill->getPersonsByCache();
    return [$bill_id, json_decode($bill->persons, true)];
}

function getSingleBillArraysData($user_id, $db): array
{
    $singleResult = getSingleBillPersonIds($user_id, $db);
    $bill_id = $singleResult[0];
    $persons_ids = $singleResult[1];

    $person = new Person($db);
    $persons_names = $person->getPersonsBillList($persons_ids);

    $singleBill = new SingleBill($db);
    $singleBillArray = $singleBill->getPersonsValueBillList($bill_id);

    $single_bill_data_array = getIdArrayFromSingleBillArray($singleBillArray);
    $id_persons_array = $single_bill_data_array[0];
    $id_fullValue_array = $single_bill_data_array[1];

    $output_string = "";

    foreach ($id_persons_array as $curr_single_id => $person_array) {
        $output_string = $output_string .
            sprintf(GROUP_LINE_FORMAT,
                $curr_single_id,
                getSeparatedPersonNamesLine($persons_names, $person_array),
                $id_fullValue_array[$curr_single_id]
            );
    }

    return [$id_persons_array, $persons_names, $id_fullValue_array];
}

function getSingleBillDataString($user_id, $db)
{
    $single_bill_data = getSingleBillArraysData($user_id, $db);
    $id_persons_array = $single_bill_data[0];
    $persons_names = $single_bill_data[1];
    $id_fullValue_array = $single_bill_data[2];
    $output_string = "";

    foreach ($id_persons_array as $curr_single_id => $person_array) {
        $output_string = $output_string .
            sprintf(GROUP_LINE_FORMAT,
                $curr_single_id,
                getSeparatedPersonNamesLine($persons_names, $person_array),
                $id_fullValue_array[$curr_single_id]
            );
    }

    return $output_string;
}

// Return [[persons], [fullValue]]

function getIdArrayFromSingleBillArray($array)
{
    $persons_array = [];
    $fullValue_array = [];
    foreach ($array as $sub_array) {
        $persons_array[$sub_array['id']] = json_decode($sub_array['persons'], true);
        $fullValue_array[$sub_array['id']] = $sub_array['fullValue'];
    }
    return [$persons_array, $fullValue_array];
}

function getSeparatedPersonNamesLine($full_person_names, $person_ids): string
{
    $output_array = [];
    foreach ($person_ids as $person_id) {
        $output_array[] = "[ " . $full_person_names[$person_id] . " ]";
    }

    log_msg(print_r($output_array, true));
    return implode(', ', $output_array);
}
