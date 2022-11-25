<?php
const MAIN_KEYBOARD = [
    "one_time" => false,
    "buttons" => [[
        ["action" => [
            "type" => "text",
            "payload" => '{"command": "' . CREATE_BILL_PAYLOAD . '"}',
            "label" => CREATE_BILL_BUTTON_TEXT],
            "color" => "positive"]],
        [["action" => [
            "type" => "text",
            "payload" => '{"command": "' . SHOW_BILLS_PAYLOAD . '"}',
            "label" => SHOW_BILLS_BUTTON_TEXT],
            "color" => "primary"]],
        [["action" => [
            "type" => "text",
            "payload" => '{"command": "' . HELP_PAYLOAD . '"}',
            "label" => HELP_TEXT],
            "color" => "secondary"]]]];

const CREATE_BILL_INPUT = [
    "one_time" => false,
    "buttons" => [[
        ["action" => [
            "type" => "text",
            "payload" => '{"command": "' . CANCEL_PAYLOAD . '"}',
            "label" => CANCEL_BUTTON_TEXT],
            "color" => "secondary"],
    ]]];