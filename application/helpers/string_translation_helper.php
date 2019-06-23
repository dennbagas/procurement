<?php
defined('BASEPATH') or exit('No direct script access allowed');

function dashed_lower_case($string)
{
    return str_replace(' ', '-', strtolower($string));
}

function underscored_lower_case($string)
{
    return str_replace(' ', '_', strtolower($string));
}
