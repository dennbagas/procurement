<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('success_message')) {
    function success_message($message = '', $url = '', $link = '')
    {
        if ($url != null) {
            $raw_link = '<a href="' . $url . '" class="pull-right">' . $link . '</a>';
        }

        return '
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>'
            . $raw_link . $message . '
        </div>
        ';
    }
}

if (!function_exists('error_message')) {
    function error_message($message = '')
    {
        return '
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>'
            . $message . '
        </div>
        ';
    }
}
