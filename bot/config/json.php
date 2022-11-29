<?php
$empty_ids_array = array();

$empty_json = array();

define("EMPTY_JSON_IDS_ARRAY", json_encode($empty_ids_array));
define("EMPTY_JSON_STATE", json_encode($empty_json));

function setNameStateJsonArgument($name)
{
    return json_encode(array(NAME_STATE_ARG => $name), JSON_UNESCAPED_UNICODE);
}

function setPasswordFieldToJson($input_json, $password)
{
    $current_json_array = json_decode($input_json, true);
    $current_json_array[PASSWORD_STATE_ARG] = $password;
    return json_encode($current_json_array, JSON_UNESCAPED_UNICODE);
}