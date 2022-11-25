<?php
$empty_ids_array = array(
    'ids' => array()
);

$empty_json = array();

const MAIN_BUTTONS_JSON_FILE = __DIR__ . "/../res/json/main_buttons.json";

define("EMPTY_JSON_IDS_ARRAY", json_encode($empty_ids_array));
define("EMPTY_JSON_STATE", json_encode($empty_json));
define("MAIN_JSON_BUTTONS", file_get_contents(MAIN_BUTTONS_JSON_FILE));
