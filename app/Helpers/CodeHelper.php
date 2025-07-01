<?php

use Illuminate\Support\Facades\App;

if (!function_exists('format_field_label')) {
    function format_field_label($input)
    {
        // Pisahkan bagian dalam kurung jika ada
        preg_match('/^([^\[]+)(?:\[(.+)\])?$/', $input, $matches);

        $label = str_replace('_', ' ', $matches[1] ?? $input);
        $label = ucwords($label);

        if (isset($matches[2])) {
            $label .= ' (' . $matches[2] . ')';
        }

        return $label;
    }

}