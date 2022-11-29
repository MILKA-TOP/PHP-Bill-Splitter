<?php

const state_model = array(
    START_STATE => StartState::class,
    SET_BILL_NAME_STATE => InputBillNameState::class,
    SET_BILL_CONFIRM_NAME_STATE => ConfirmNameState::class,
    SET_BILL_PASSWORD_INPUT_STATE => InputPasswordState::class,
    SET_BILL_PASSWORD_CONFIRM_STATE => ConfirmPasswordState::class,
    SET_BILL_PERSONS_STATE => InputPersonNameState::class,
);