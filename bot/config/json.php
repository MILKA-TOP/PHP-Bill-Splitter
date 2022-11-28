<?php
$empty_ids_array = array();

$empty_json = array();

define("EMPTY_JSON_IDS_ARRAY", json_encode($empty_ids_array));
define("EMPTY_JSON_STATE", json_encode($empty_json));

function setNameStateJsonArgument($name)
{
    return json_encode(array("name" => $name));
}

function setPasswordFieldToJson($input_json, $password) {

}