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