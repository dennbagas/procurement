<?php
defined('BASEPATH') or exit('No direct script access allowed');

function after($char, $inthat)
{
    if (!is_bool(strpos($inthat, $char))) {
        return substr($inthat, strpos($inthat, $char) + strlen($char));
    }
};

function after_last($char, $inthat)
{
    if (!is_bool(strrevpos($inthat, $char))) {
        return substr($inthat, strrevpos($inthat, $char) + strlen($char));
    }
};

function before($char, $inthat)
{
    return substr($inthat, 0, strpos($inthat, $char));
};

function before_last($char, $inthat)
{
    return substr($inthat, 0, strrevpos($inthat, $char));
};

function between($char, $that, $inthat)
{
    return before($that, after($char, $inthat));
};

function between_last($char, $that, $inthat)
{
    return after_last($char, before_last($that, $inthat));
};
