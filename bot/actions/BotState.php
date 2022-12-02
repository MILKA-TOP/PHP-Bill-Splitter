<?php

abstract class BotState
{

    protected $state_number;
    protected $keyboard;

    public function __construct(int $state_number, array $keyboard = array())
    {
        $this->state_number = $state_number;
        $this->keyboard = $keyboard;
    }

    protected function toStartMenuState($user_id, $db)
    {
        $user = new User($db);
        $user->id = $user_id;
        $user->updateStateWithArgs(START_STATE, EMPTY_JSON_STATE);
        vkApi_messagesSend($user_id, ROLLBACK_TO_MAIN_MENU, MAIN_KEYBOARD);
    }

    protected function backToBillMenu($user_id, $db)
    {
        $user = new User($db);
        $user->id = $user_id;
        $user->updateState(MAIN_BILL_STATE);
        vkApi_messagesSend($user_id, BACK_TO_BILL_MENU_MESSAGE, BILL_MAIN_KEYBOARD);
    }

    protected function toSingleBillList($user_id, $db)
    {
        $user = new User($db);
        $user->id = $user_id;
        $user->updateState(SELECT_SINGLE_BILL_STATE);
        sendSingleBillListMessage($user_id, $db);
    }

    protected function toMainSingleBillState($user_id, $db)
    {
        $user = new User($db);
        $user->id = $user_id;
        $user->getSingleUser();

        $single_bill_id = json_decode($user->stateArgs, true)[SINGLE_BILL_ID_STATE_ARG];
        MainSingleBillState::showSingleBillData($user_id, $single_bill_id, $db);
    }

    protected function toInputFieldNameState($user_id, $db)
    {
        $user = new User($db);
        $user->id = $user_id;
        $user->getSingleUser();

        $user->updateStateWithArgs(SET_FIELD_NAME_STATE, filterToSingleBillJson($user->stateArgs));
        vkApi_messagesSend($user_id, FIELD_NAME_MESSAGE, BACK_INPUT_KEYBOARD);
    }

    protected function toMainBillMenuState($user_id, $db, $billId)
    {
        $user = new User($db);
        $user->id = $user_id;
        $user->updateStateWithArgs(MAIN_BILL_STATE, setIdBillArgState($billId));

        $bill = new Bill($db);
        $bill->id = $billId;
        $bill->getSingleBill();

        $person = new Person($db);
        $person_name_list = $person->getPersonsBillList(json_decode($bill->persons, true));

        $output_message = sprintf(MAIN_BILL_INFO_MESSAGE,
            $bill->name, $billId, implode("\n", $person_name_list));
        vkApi_messagesSend($user_id, $output_message, BILL_MAIN_KEYBOARD);
    }

    protected function getPayloadArgs($data)
    {
        if (isset($data["message"]["payload"])) return $data["message"]["payload"];
        if (isset($data["payload"])) return json_encode($data["payload"], JSON_UNESCAPED_UNICODE);
        return null;
    }


    abstract public function stateAction($user_id, $data, $db);
}