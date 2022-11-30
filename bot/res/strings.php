<?php
const START_MESSAGE = "Добро пожаловать в бота \"Bill-Splitter\"!\n\nБлагодаря данному боту" .
    "мы можете удобно разделить общий счет и позиции из чека на всю компанию, получив то, сколько" .
    "должен заплатить каждый из участников чека!";

const DEVELOP_MESSAGE = "Данный раздел еще находится в разработке <3";

const START_SHOW_BILLS_FOR_USER = "Ниже представлен список доступных счетов. Для того, чтобы открыть соответствующий" .
    " чек, просто введите его [id]";

const START_SHOW_BILLS_FOR_EMPTY = "У вас нет никаких доступных чеков.";

const INPUT_NAME_MESSAGE = "Введите пожалуйста название данного чека.\nМожете сюда вписать название" .
    " заведение, дату встречи или что-то иное.\n\nДля отмены нажмите на кнопку \"Отмена\"";

const INPUT_NAME_CONFIRM = "Подтвердите пожалуйста название вашего счета. Если вас все устраивает, нажмите \"Oк\"," .
    " в противном случае нажмите на кнопку \"Переименовать\"\n\nНазвание: '%s'";

const INPUT_NAME_INCORRECT_MESSAGE = "Пожалуйста, введите корректное название счёта: его длина не должна превышать " .
    "50 символов или быть пустой.";

const INPUT_PASSWORD_INCORRECT_MESSAGE = "Введенный пароль неверный. Пожалуйста, введите пароль верно или же поменяйте" .
    " его, нажав на кнопку \"Изменить пароль\".";

const CONFIRM_INPUT_NAME_INCORRECT_MESSAGE = "Пожалуйста, подтвердите название '%s', нажав на кнопку \"Ок\" или " .
    "измените его, нажав на кнопку \"Переименовать\"";

const INPUT_PASSWORD_MESSAGE = "Введите пожалуйста пароль для данного чека.\nВы можете также пропустить этот пункт, но в" .
    " дальнейшем любой человек, обладающий ID вашего чека может произвести в нем изменения.\n\nУстановить пароль позднее" .
    " будет невозможно.";

const INPUT_PASSWORD_CONFIRM_MESSAGE = "Пожалуйста, подтвердите пароль, введя его еще раз.\n\nТекущий пароль: '%s';\n\n" .
    "Если вы хотите его изменить, то нажмите на кнопку \"Изменить пароль\".";

const INPUT_PERSONS_BILL_MESSAGE = "Введите имена пользователей, которые будут использоваться в дальнейшем для" .
    " разделение чека.";

const INPUT_PERSONS_BILL_LIST_MESSAGE = "Список добавленных пользователей (для удаления пользователя нажмите на него).";

const ERROR_MESSAGE_PERSON_INPUT = "Пожалуйста, введите корректное имя пользователя (его длина не должна превышать" .
    " 50 символов.";

const ERROR_MESSAGE_PERSON_ZERO_LIST_INPUT = "Невозможно создать чек без пользователей. Пожалуйста, введите хотя" .
    " бы одно имя.";

const ERROR_MASSAGE_PERSON_SAME_NAME = "Вы уже вводили данное имя. Пожалуйста, введите другое.";

const ERROR_MASSAGE_PERSON_REMOVE_NAME = "Данный пользователь не найден.";

const ROLLBACK_TO_MAIN_MENU = "Вы перешли в главное меню";

const ERROR_MAIN_MESSAGE = "Пожалуйста, введите корректную команду";

const CREATE_BILL_BUTTON_TEXT = "Создать счёт";
const SHOW_BILLS_BUTTON_TEXT = "Показать доступные счета";
const HELP_TEXT = "Помощь";

const NEXT_BUTTON_TEXT = "Далее";
const RENAME_BUTTON_TEXT = "Переименовать";
const OK_BUTTON_TEXT = "Ок";
const CANCEL_BUTTON_TEXT = "Отмена";
const SKIP_PASSWORD_BUTTON_TEXT = "Пропустить пароль";
const CHANGE_PASSWORD_BUTTON_TEXT = "Изменить пароль";
const NEXT_PAGE_INLINE = " ▶";
const PREV_PAGE_INLINE = " ◀";

const PASSWORD_STATE_ARG = "password";
const BILL_NAME_STATE_ARG = "name";
const ACTION_STATE_PAYLOAD_ARG = "value";
const PERSON_NAME_STATE_ARG = "persons";
const PAGE_NUMBER_PERSON_STATE_ARG = "page";
