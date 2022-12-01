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

const CONFIRM_BILL_NAME_KEYBOARD = [
    "one_time" => false,
    "buttons" => [
        [[
            "action" => [
                "type" => "text",
                "payload" => '{"command": "' . BACK_PAYLOAD . '"}',
                "label" => RENAME_BUTTON_TEXT],
            "color" => "negative"],
            [
                "action" => [
                    "type" => "text",
                    "payload" => '{"command": "' . CONFIRM_PAYLOAD . '"}',
                    "label" => OK_BUTTON_TEXT],
                "color" => "positive"]],
        [["action" => [
            "type" => "text",
            "payload" => '{"command": "' . CANCEL_PAYLOAD . '"}',
            "label" => CANCEL_BUTTON_TEXT],
            "color" => "secondary"],
        ]]];

const INPUT_PASSWORD_KEYBOARD = [
    "one_time" => false,
    "buttons" => [
        [[
            "action" => [
                "type" => "text",
                "payload" => '{"command": "' . SKIP_PASSWORD_PAYLOAD . '"}',
                "label" => SKIP_PASSWORD_BUTTON_TEXT],
            "color" => "primary"]],
        [[
            "action" => [
                "type" => "text",
                "payload" => '{"command": "' . CANCEL_PAYLOAD . '"}',
                "label" => CANCEL_BUTTON_TEXT],
            "color" => "secondary"]]]];

const CONFIRM_PASSWORD_KEYBOARD = [
    "one_time" => false,
    "buttons" => [
        [[
            "action" => [
                "type" => "text",
                "payload" => '{"command": "' . BACK_PAYLOAD . '"}',
                "label" => CHANGE_PASSWORD_BUTTON_TEXT],
            "color" => "negative"]],
        [[
            "action" => [
                "type" => "text",
                "payload" => '{"command": "' . CANCEL_PAYLOAD . '"}',
                "label" => CANCEL_BUTTON_TEXT],
            "color" => "secondary"]]]];

const INPUT_PERSONS_KEYBOARD = [
    "one_time" => false,
    "buttons" => [
        [[
            "action" => [
                "type" => "text",
                "payload" => '{"command": "' . CONFIRM_PAYLOAD . '"}',
                "label" => CREATE_BILL_BUTTON_TEXT],
            "color" => "positive"]],
        [[
            "action" => [
                "type" => "text",
                "payload" => '{"command": "' . CANCEL_PAYLOAD . '"}',
                "label" => CANCEL_BUTTON_TEXT],
            "color" => "secondary"]]]];

const TEST_INLINE_KEYBOARD = [
    "inline" => true,
    "buttons" => [
        [[
            "action" => [
                "type" => "callback",
                "label" => CREATE_BILL_BUTTON_TEXT],
            "color" => "positive"]],
        [[
            "action" => [
                "type" => "callback",
                "label" => CANCEL_BUTTON_TEXT],
            "color" => "secondary"]]]];

const BACK_BUTTON = [
    "action" => [
        "type" => "callback",
        "payload" => '{"command": "' . PREV_PAGE_NAME_PAYLOAD . '"}',
        "label" => PREV_PAGE_INLINE],
    "color" => "positive"];

const NEXT_BUTTON = [
    "action" => [
        "type" => "callback",
        "payload" => '{"command": "' . NEXT_PAGE_NAME_PAYLOAD . '"}',
        "label" => NEXT_PAGE_INLINE],
    "color" => "positive"];

const BACK_NEXT_BUTTONS = [BACK_BUTTON, NEXT_BUTTON];

function arrayOfPersonButtons($names_array, $with_back = false, $with_next = false, $payload = REMOVE_PERSON_PAYLOAD): array
{
    $buttons_array = array();
    foreach ($names_array as $value => $label) {
        $buttons_array[] = [[
            "action" => [
                "type" => "callback",
                "payload" => '{"command": "' . $payload . '", "value":"' . $value . '"}',
                "label" => $label],
            "color" => "primary"]];
    }

    if ($with_back && $with_next) {
        $buttons_array[] = BACK_NEXT_BUTTONS;
    } else if ($with_back) {
        $buttons_array[] = [BACK_BUTTON];
    } else if ($with_next) {
        $buttons_array[] = [NEXT_BUTTON];
    }

    return ["inline" => true, "buttons" => $buttons_array];
}

const BILL_MAIN_KEYBOARD = [
    "one_time" => false,
    "buttons" => [[
        ["action" => [
            "type" => "text",
            "payload" => '{"command": "' . BILL_SHOW_ALL_PAYLOAD . '"}',
            "label" => MAIN_BILL_SHOW_ALL],
            "color" => "positive"]],
        [["action" => [
            "type" => "text",
            "payload" => '{"command": "' . BILL_CHANGE_SINGLE_BILL_PAYLOAD . '"}',
            "label" => MAIN_BILL_CHANGE_SINGLE_BILL],
            "color" => "primary"]],
        [["action" => [
            "type" => "text",
            "payload" => '{"command": "' . BILL_SHOW_SINGLE_PAYLOAD . '"}',
            "label" => MAIN_BILL_SHOW_SINGLE],
            "color" => "primary"]],
        [["action" => [
            "type" => "text",
            "payload" => '{"command": "' . CANCEL_PAYLOAD . '"}',
            "label" => CANCEL_BUTTON_TEXT],
            "color" => "secondary"]]]];


const SINGLE_BILL_CHOOSE_KEYBOARD = [
    "one_time" => false,
    "buttons" => [[
        ["action" => [
            "type" => "text",
            "payload" => '{"command": "' . BILL_CREATE_SINGLE_BILL_PAYLOAD . '"}',
            "label" => CREATE_NEW_SINGLE_BILL_BUTTON_TEXT],
            "color" => "positive"]],
        [["action" => [
            "type" => "text",
            "payload" => '{"command": "' . SINGLE_BILL_SHOW_ALL_GROUPS . '"}',
            "label" => SINGLE_BILL_SHOW_ALL],
            "color" => "primary"]],
        [["action" => [
            "type" => "text",
            "payload" => '{"command": "' . BACK_PAYLOAD . '"}',
            "label" => BACK_BUTTON_TEXT],
            "color" => "secondary"]]]];

const SINGLE_BILL_CREATE_KEYBOARD = [
    "one_time" => false,
    "buttons" => [[
        ["action" => [
            "type" => "text",
            "payload" => '{"command": "' . BILL_CREATE_SINGLE_BILL_PAYLOAD . '"}',
            "label" => CREATE_NEW_SINGLE_BILL_BUTTON_TEXT],
            "color" => "positive"]],
        [["action" => [
            "type" => "text",
            "payload" => '{"command": "' . BACK_PAYLOAD . '"}',
            "label" => BACK_BUTTON_TEXT],
            "color" => "secondary"]]]];

function arrayOfPersonStatusButtons($names_array,
                                    $status_array,
                                    $with_back = false,
                                    $with_next = false): array
{
    $STATUS_ARRAY = array(true => "positive", false => "negative");
    $buttons_array = array();
    foreach ($names_array as $value => $label) {
        $buttons_array[] = [[
            "action" => [
                "type" => "callback",
                "payload" => '{"command": "' . CHANGE_PERSON_STATE_SINGLE_BILL_PAYLOAD
                    . '", "value":"' . $value . '", "status:"' . $status_array[$value] . '"}',
                "label" => $label],
            "color" => $STATUS_ARRAY[$status_array[$value]]]];
    }

    if ($with_back && $with_next) {
        $buttons_array[] = BACK_NEXT_BUTTONS;
    } else if ($with_back) {
        $buttons_array[] = [BACK_BUTTON];
    } else if ($with_next) {
        $buttons_array[] = [NEXT_BUTTON];
    }

    return ["inline" => true, "buttons" => $buttons_array];
}
