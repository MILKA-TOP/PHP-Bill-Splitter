<?php

const state_model = array(
    START_STATE => StartState::class,
    SET_BILL_NAME_STATE => InputBillNameState::class,
    SET_BILL_CONFIRM_NAME_STATE => ConfirmNameState::class,
    SET_BILL_PASSWORD_INPUT_STATE => InputPasswordState::class,
    SET_BILL_PASSWORD_CONFIRM_STATE => ConfirmPasswordState::class,
    SET_BILL_PERSONS_STATE => InputPersonNameState::class,
    MAIN_BILL_STATE => MainBillState::class,
    SELECT_SINGLE_BILL_STATE => SelectSingleBillState::class,
    CREATE_SINGLE_BILL_STATE => CreateNewSingleBill::class,
    MAIN_SINGLE_BILL_STATE => MainSingleBillState::class,
    SET_FIELD_NAME_STATE => InputFieldNameState::class,
    SET_FIELD_VALUE_STATE => InputFieldValueState::class,
    REMOVE_FIELD_STATE => RemoveFieldState::class,
    SET_BILL_ID_STATE => InputBillIdState::class,
    SET_BILL_PASSWORD_STATE => InputBillPasswordState::class,
    FROM_MAIN_BILL_CREATE_FIELD => InputPersonsForFieldsState::class,
);