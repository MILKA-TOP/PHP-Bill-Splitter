<?php

const keyboard_model = array(
    START_STATE => MAIN_KEYBOARD,
    SET_BILL_NAME_STATE => CREATE_BILL_INPUT,
    SET_BILL_CONFIRM_NAME_STATE => CONFIRM_BILL_NAME_KEYBOARD,
    SET_BILL_PASSWORD_INPUT_STATE => INPUT_PASSWORD_KEYBOARD,
    SET_BILL_PASSWORD_CONFIRM_STATE => CONFIRM_PASSWORD_KEYBOARD,
    SET_BILL_PERSONS_STATE => INPUT_PERSONS_KEYBOARD,
    MAIN_BILL_STATE => BILL_MAIN_KEYBOARD,
    SELECT_SINGLE_BILL_STATE => SINGLE_BILL_CHOOSE_KEYBOARD,
    CREATE_SINGLE_BILL_STATE => SINGLE_BILL_CREATE_KEYBOARD,
    MAIN_SINGLE_BILL_STATE => SINGLE_BILL_DATA_KEYBOARD,
    SET_FIELD_NAME_STATE => BACK_INPUT_KEYBOARD,
);