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