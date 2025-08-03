<?php

if (!function_exists('format_gender')) {
    function format_gender($gender) {
        if ($gender === 'L') {
            return 'Laki-laki';
        } elseif ($gender === 'P') {
            return 'Perempuan';
        }
        return $gender; // Return as is if not L or P
    }
}

if (!function_exists('format_gender_code')) {
    function format_gender_code($gender) {
        if (strtolower($gender) === 'laki-laki' || $gender === 'L') {
            return 'L';
        } elseif (strtolower($gender) === 'perempuan' || $gender === 'P') {
            return 'P';
        }
        return $gender; // Return as is if not matching any case
    }
}
