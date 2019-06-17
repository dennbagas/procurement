<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('custom_input')) {
    function custom_input($data = '', $value = '', $extra = '')
    {
        $defaults = array(
            'type' => 'text',
            'name' => is_array($data) ? '' : $data['name'],
            'value' => $value,
            'class' => 'form-control',
            'required' => 'required',
        );

        return
        '<div class="form-group">
        ' . form_label($data["placeholder"], $data["name"], ["class" => "col-sm-2 control-label"]) . '
            <div class="col-sm-10">
                <input ' . _parse_form_attributes($data, $defaults) . _attributes_to_string($extra) . " />
            </div>
        </div>";
    }
}

if (!function_exists('custom_password')) {
    function custom_input_readonly($data = '', $value = '', $extra = '')
    {
        is_array($data) or $data = array('name' => $data);
        $data['readonly'] = 'readonly';
        $data['style'] = 'cursor:default;';
        return custom_input($data, $value, $extra);
    }
}

if (!function_exists('custom_password')) {
    function custom_password($data = '', $value = '', $extra = '')
    {
        is_array($data) or $data = array('name' => $data);
        $data['type'] = 'password';
        return custom_input($data, $value, $extra);
    }
}

if (!function_exists('custom_dropdown')) {
    function custom_dropdown($label = '', $data = '', $options = array(), $selected = array(), $extra = '')
    {
        return
        '<div class="form-group">
        ' . form_label($label, $data["name"], ["class" => "col-sm-2 control-label"]) . '
            <div class="col-sm-10">' .
        form_dropdown([
            'name' => $data['name'], 'class' => 'form-control', 'required' => 'required'],
            $options, $selected, $extra) .
            '</div>
        </div>';
    }
}

if (!function_exists('custom_submit')) {
    function custom_submit($data = '', $value = '', $extra = '')
    {
        $defaults = array(
            'type' => 'submit',
            'name' => is_array($data) ? '' : $data,
            'value' => $value,
            'class' => 'btn btn-primary',
        );

        return
        '<div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input ' . _parse_form_attributes($data, $defaults) . _attributes_to_string($extra) . " />
            </div>
        </div>";
    }
}