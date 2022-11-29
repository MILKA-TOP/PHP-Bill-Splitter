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
                "type" => "test_callback",
                "label" => CREATE_BILL_BUTTON_TEXT],
            "color" => "positive"]],
        [[
            "action" => [
                "type" => "test_callback",
                "label" => CANCEL_BUTTON_TEXT],
            "color" => "secondary"]]]];

