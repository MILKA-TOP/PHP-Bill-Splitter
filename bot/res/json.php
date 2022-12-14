<?php
$empty_ids_array = array();

$empty_json = array();

define("EMPTY_JSON_ARRAY", json_encode($empty_ids_array));
define("EMPTY_JSON_STATE", json_encode($empty_json));

function arrayToJson($array)
{
    return json_encode($array, JSON_UNESCAPED_UNICODE);
}

function setNameStateJsonArgument($name)
{
    return json_encode(array(BILL_NAME_STATE_ARG => $name), JSON_UNESCAPED_UNICODE);
}

function setPasswordFieldToJson($input_json, $password)
{
    $current_json_array = json_decode($input_json, true);
    $current_json_array[PASSWORD_STATE_ARG] = $password;
    return json_encode($current_json_array, JSON_UNESCAPED_UNICODE);
}

function addPersonNameFieldToJson($input_json, $personName)
{
    $current_json_array = json_decode($input_json, true);
    if (!isset($current_json_array[PERSON_NAME_STATE_ARG])) {
        $current_json_array[PERSON_NAME_STATE_ARG] = array($personName);
    } else {
        $current_json_array[PERSON_NAME_STATE_ARG][] = $personName;
    }
    return json_encode($current_json_array, JSON_UNESCAPED_UNICODE);
}

function removePersonNameFieldToJson($input_json, $personName)
{
    $current_json_array = json_decode($input_json, true);
    $current_person_names = $current_json_array[PERSON_NAME_STATE_ARG];
    unset($current_person_names[array_search($personName, $current_person_names)]);
    $current_json_array[PERSON_NAME_STATE_ARG] = $current_person_names;
    return json_encode($current_json_array, JSON_UNESCAPED_UNICODE);
}

function addPersonPageNumberFieldToJson($input_json, $pageNumber = 0)
{
    $current_json_array = json_decode($input_json, true);
    $current_json_array[PAGE_NUMBER_PERSON_STATE_ARG] = $pageNumber;
    return json_encode($current_json_array, JSON_UNESCAPED_UNICODE);

}

function addElementToJsonArray($input_json, $element)
{
    $array_regular = json_decode($input_json, true);
    $array_regular[] = $element;
    return json_encode($array_regular, JSON_UNESCAPED_UNICODE);
}

function setIdBillArgState($billId)
{
    return json_encode(array(BILL_ID_STATE_ARG => $billId), JSON_UNESCAPED_UNICODE);
}

function setJsonChoosePersons($input_json)
{
    $input_json = addPersonPageNumberFieldToJson($input_json);
    $current_json_array = json_decode($input_json, true);
    $current_json_array[SINGLE_PERSONS_STATE_ARG] = array();
    return json_encode($current_json_array, JSON_UNESCAPED_UNICODE);
}

function updatePersonsSingleBillArray($input_json, $person_id, $bool)
{
    $args_array = json_decode($input_json, true);

    $selected_array = $args_array[SINGLE_PERSONS_STATE_ARG];
    if ($bool) {
        $selected_array[] = $person_id;
    } else {
        unset($selected_array[array_search($person_id, $selected_array)]);
    }
    $args_array[SINGLE_PERSONS_STATE_ARG] = $selected_array;

    return json_encode($args_array, JSON_UNESCAPED_UNICODE);
}

function setSingleBillJson($input_json, $single_bill_id, $toMainMenuReturn = false)
{
    $args_array = json_decode($input_json, true);

    $output_array = array(
        BILL_ID_STATE_ARG => $args_array[BILL_ID_STATE_ARG],
        SINGLE_BILL_ID_STATE_ARG => $single_bill_id,
        SINGLE_BILL_TO_MAIN_MENU_RETURN_STATE_ARG => $toMainMenuReturn,
    );

    return json_encode($output_array, JSON_UNESCAPED_UNICODE);
}

function filterToSingleBillJson($input_json)
{
    $args_array = json_decode($input_json, true);

    $output_array = array(
        BILL_ID_STATE_ARG => $args_array[BILL_ID_STATE_ARG],
        SINGLE_BILL_ID_STATE_ARG => $args_array[SINGLE_BILL_ID_STATE_ARG],
        SINGLE_BILL_TO_MAIN_MENU_RETURN_STATE_ARG => $args_array[SINGLE_BILL_TO_MAIN_MENU_RETURN_STATE_ARG],
    );

    return json_encode($output_array, JSON_UNESCAPED_UNICODE);
}

function addNameFieldToJson($input_json, $name)
{
    $args_array = json_decode($input_json, true);

    $args_array[BILL_NAME_STATE_ARG] = $name;

    return json_encode($args_array, JSON_UNESCAPED_UNICODE);
}