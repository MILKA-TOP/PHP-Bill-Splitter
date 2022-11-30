<?php

function maxPageNumber($array): int
{
    return intdiv(count($array) - 1, MAX_INLINE_BUTTONS_COUNT);
}

function lastArrayRanges($array, $page): array
{
    return array_slice($array, $page * MAX_INLINE_BUTTONS_COUNT, MAX_INLINE_BUTTONS_COUNT);
}

function containsNextPage($array, $page, $max_page): bool
{
    return $page !== $max_page;
}

function containsPrevPage($array, $page): bool
{
    return $page !== 0;
}

function getKeyboardFirstPage($array): array
{
    return getKeyboardByPage($array, 0);
}

function getKeyboardLastPage($array): array
{
    return getKeyboardByPage($array, maxPageNumber($array));
}


function getKeyboardByPage($array, $page): array
{
    $max_page_number = maxPageNumber($array);
    $name_array_cut = lastArrayRanges($array, $page);
    $contains_prev_page = containsPrevPage($array, $page);
    $contains_next_page = containsNextPage($array, $page, $max_page_number);
    return [arrayOfPersonButtons($name_array_cut, $contains_prev_page, $contains_next_page), $name_array_cut];
}