<?php
const START_MESSAGE = "Добро пожаловать в бота \"Bill-Splitter\"!\n\nБлагодаря данному боту" .
    "мы можете удобно разделить общий счет и позиции из чека на всю компанию, получив то, сколько" .
    "должен заплатить каждый из участников чека!";

const DEVELOP_MESSAGE = "Данный раздел еще находится в разработке <3";
const INPUT_BILL_ID_MESSAGE = "Введите [id] чека, к которому хотите присоединиться.";
const INPUT_BILL_PASSWORD_MESSAGE = "Введите пароль для чека с id [%s].";

const START_SHOW_BILLS_FOR_USER = "Ниже представлен список доступных счетов. Для того, чтобы открыть соответствующий" .
    " чек, просто введите его [id]";

const START_SHOW_BILLS_FOR_EMPTY = "У вас нет никаких доступных чеков.";

const INPUT_NAME_MESSAGE = "Введите пожалуйста название данного чека.\nМожете сюда вписать название" .
    " заведение, дату встречи или что-то иное.\n\nДля отмены нажмите на кнопку \"Отмена\"";

const INPUT_NAME_CONFIRM = "Подтвердите пожалуйста название вашего счета. Если вас все устраивает, нажмите \"Oк\"," .
    " в противном случае нажмите на кнопку \"Переименовать\"\n\nНазвание: '%s'";

const INPUT_NAME_INCORRECT_MESSAGE = "Пожалуйста, введите корректное название счёта: его длина не должна превышать " .
    "50 символов или быть пустой.";

const INPUT_FIELD_NAME_INCORRECT_MESSAGE = "Пожалуйста, введите корректное название позиции: её длина не должна превышать " .
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

const CHOOSE_PERSONS_FOR_SINGLE_BILL = "Список пользователей:";

const INPUT_PERSONS_BILL_LIST_MESSAGE = "Список добавленных пользователей (для удаления пользователя нажмите на него).";

const ERROR_MESSAGE_PERSON_INPUT = "Пожалуйста, введите корректное имя пользователя (его длина не должна превышать" .
    " 50 символов.";

const ERROR_MESSAGE_PERSON_ZERO_LIST_INPUT = "Невозможно создать чек без пользователей. Пожалуйста, введите хотя" .
    " бы одно имя.";

const ERROR_MASSAGE_PERSON_SAME_NAME = "Вы уже вводили данное имя. Пожалуйста, введите другое.";

const ERROR_MASSAGE_PERSON_REMOVE_NAME = "Данный пользователь не найден.";

const ROLLBACK_TO_MAIN_MENU = "Вы перешли в главное меню";

const ERROR_MAIN_MESSAGE = "Пожалуйста, введите корректную команду";

const SL = "--------------------------------\n";
const MAIN_BILL_INFO_MESSAGE = "🧾 | Название чека: '%s';\n🆔 | ID: '%s';\n👥 | Участники:\n" . SL . "%s";
const PERSON_NAME_IN_BILL_FORMAT = "%s) %s\n";
const BACK_TO_BILL_MENU_MESSAGE = "Вы вернулись в главное меню чека";

const SELECT_SINGLE_BILL_INFO_MESSAGE = "Выберите из приведенного списка ту группу людей, у которой хотите изменить" .
    " набор блюд, отправив её номер, или создайте новую группу.\n\n%s";

const GROUP_LINE_FORMAT = SL . "🆔 | ID: '%s';\n👥 | Участники: %s\n💰 | Сумма: %.2f руб." . "\n";

const SELECT_SINGLE_BILL_INFO_INCORRECT_MESSAGE = "Группы с таким [id] нет в списке.\n\n Введите пожалуйста" .
    " корректный [id] или же создайте новую группу.";

const SELECT_PERSONS_FOR_SINGLE_BILL = "Выберите людей для соответствующей группы. Чтобы выбрать человека, необходимо" .
    " нажать на него. Если вы хотите удалить его из группы, то также нажмите на него.";

const SINGLE_BILL_REMOVE_POSITION_MESSAGE = "📄 | ИНФОРМАЦИЯ О ГРУППЕ\n\n👤 | Количество участников: %s;\n💰 | Сумма на всю группу: %s руб." .
    "\n👥 | Список участников: %s;\n🍽️ | Позиции:\n%s";

const FIELD_NAME_MESSAGE = "Пожалуйста, введите название позиции, которую хотите добавить.";

const REMOVE_FIELD_MESSAGE = "Веберите [id] позиции, которую хотите удалить из списка:\n\n%s";

const ERROR_FIELD_VALUE_INCORRECT = "Введенное вами значение не является корректным. Пожалуйста, введите стоимость позиции.";

const SINGLE_BILL_POSITIONS = SL . "[%s] | %s | %.2f руб.\n";

const UNKNOWN_BILL_ID_ERROR = "Чека с данным [id] не существует.";
const INCORRECT_PASSWORD_BILL_ERROR = "Введен неверный пароль от чека.";

const BILL_FINAL_STRING = SL . "🧾 | Чек:\n👤 | Имя пользователя: \"%s\";" . "\n" . SL . "%s" . SL .
    "\n\n💰 | Общая сумма: %.2f руб." . "\n" . SL;

const SINGLE_FIELD_FOR_BILL = "\"%s\" - %.2f руб.\n";
const GROUP_FIELD_FOR_BILL = "\"%s\" - %.2f руб./чел.\n";

const FIELD_FORMAT_BY_BOOL_ARRAY = array(true => SINGLE_FIELD_FOR_BILL, false => GROUP_FIELD_FOR_BILL);

const SINGLE_BILL_EMPTY_SELECTED = "Выберите хотя бы одного пользователя, чтобы создать группу.";
const SINGLE_BILL_SAME_SELECTED = "Группа с таким набором пользователей уже присутствует";

const FIELD_INPUT_VALUE = "Введите стоимость позиции \"%s\".\n\nТакже можете переименовать данную позицию.";

const CREATE_BILL_BUTTON_TEXT = "Создать счёт";
const SHOW_BILLS_BUTTON_TEXT = "Показать доступные счета";
const CONNECT_TO_BILL_BUTTON_TEXT = "Присоединиться к счету";
const HELP_TEXT = "Помощь";

const MAIN_BILL_SHOW_ALL = "Вывести все чеки";
const MAIN_BILL_CHANGE_SINGLE_BILL = "Редактировать чек";
const MAIN_BILL_SHOW_SINGLE = "Вывести чек пользователя";
const MAIN_BILL_ADD_FIELD = "Добавить позицию к чеку (блюдо/напиток)";

const NEXT_BUTTON_TEXT = "Далее";
const SINGLE_BILL_SHOW_ALL = "Показать доступные группы";
const RENAME_BUTTON_TEXT = "Переименовать";
const OK_BUTTON_TEXT = "Ок";
const BACK_BUTTON_TEXT = "Назад";
const CANCEL_BUTTON_TEXT = "Отмена";
const SKIP_PASSWORD_BUTTON_TEXT = "Пропустить пароль";
const CHANGE_PASSWORD_BUTTON_TEXT = "Изменить пароль";
const CREATE_NEW_SINGLE_BILL_BUTTON_TEXT = "Создать новую группу";
const SINGLE_BILL_ADD_POSITION_BUTTON_TEXT = "Добавить позицию";
const FIELD_RENAME_BUTTON_TEXT = "Переименовать позицию";
const SINGLE_BILL_REMOVE_POSITION_BUTTON_TEXT = "Удалить позицию";
const SHOW_BILL_DATA_BUTTON_TEXT = "Показать данные чека";
const NEXT_PAGE_INLINE = " ▶";
const PREV_PAGE_INLINE = " ◀";

const PASSWORD_STATE_ARG = "password";
const BILL_NAME_STATE_ARG = "name";
const ACTION_STATE_PAYLOAD_ARG = "value";
const SINGLE_BILL_PERSON_STATUS_STATE_PAYLOAD_ARG = "status";
const PERSON_NAME_STATE_ARG = "persons";
const PAGE_NUMBER_PERSON_STATE_ARG = "page";
const SINGLE_PERSONS_STATE_ARG = "single_persons";
const BILL_ID_STATE_ARG = "bill_id";
const SINGLE_BILL_ID_STATE_ARG = "single_bill_id";
