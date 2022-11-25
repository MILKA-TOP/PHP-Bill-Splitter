<?php
$empty_ids_array = array(
    'ids' => array()
);

$empty_json = array();

define("EMPTY_JSON_IDS_ARRAY", json_encode($empty_ids_array));
define("EMPTY_JSON_STATE", json_encode($empty_json));
define("MAIN_JSON_BUTTONS", file_get_contents(BOT_JSON_DIRECTORY."/main_buttons.json"));
