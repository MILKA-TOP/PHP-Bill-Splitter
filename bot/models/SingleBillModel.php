<?php

function getSingleBillDataString($user_id, $db): string
{
    $user = new User($db);
    $user->id = $user_id;
    $user->getSingleUser();
    $bill_id = json_decode($user->stateArgs, true)[BILL_ID_STATE_ARG];

    $bill = new Bill($db);
    $bill->id = $bill_id;
    $bill->getSingleBill();
    $persons_ids = json_decode($bill->persons, true);

    $person = new Person($db);
    $persons_names = $person->getPersonsBillList($persons_ids);

    $singleBill = new SingleBill($db);
    $singleBillArray = $singleBill->getPersonsBillList($bill_id);
    $single_bill_data_array = getIdArrayFromSingleBillArray($singleBillArray);
    $id_array = $single_bill_data_array[0];
    $id_persons_array = array_combine($id_array, $single_bill_data_array[1]);
    $id_fullValue_array = array_combine($id_array, $single_bill_data_array[2]);

    $output_string = "";

    foreach ($id_persons_array as $curr_single_id => $person_array) {
        $output_string = $output_string .
            sprintf(GROUP_LINE_FORMAT,
                $curr_single_id,
                getSeparatedPersonNamesLine($persons_names, $person_array),
                $id_fullValue_array[$curr_single_id]
            ) . $output_string;
    }

    return $output_string;
}

// Return [[ids], [persons], [fullValue]]

function getIdArrayFromSingleBillArray($array)
{
    $id_array = [];
    $persons_array = [];
    $fullValue_array = [];
    foreach ($array as $sub_array) {
        $id_array[] = $sub_array['id'];
        $persons_array[] = json_decode($sub_array['persons'], true);
        $fullValue_array[] = $sub_array['fullValue'];
    }
    return [$id_array, $persons_array, $fullValue_array];
}

function getSeparatedPersonNamesLine($full_person_names, $person_ids): string
{
    $output_array = [];
    foreach ($person_ids as $person_id) {
        $output_array[] = $full_person_names[$person_id];
    }

    return implode(' | ', $output_array);
}
