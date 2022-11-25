<?php
const MAIN_KEYBOARD = [
    "one_time" => false,
    "buttons" => [[
        ["action" => [
            "type" => "text",
            "payload" => '{"command": "create"}',
            "label" => CREATE_BILL_BUTTON_TEXT],
            "color" => "positive"]],
        [["action" => [
            "type" => "text",
            "label" => SHOW_BILLS_BUTTON_TEXT],
            "color" => "primary"]],
        [["action" => [
            "type" => "text",
            "label" => HELP_TEXT],
            "color" => "secondary"]]]];