<?php

if (!function_exists('format_indo')) {
    /**
     * Format date to Indonesian format
     * 
     * @param string $date Date string in Y-m-d H:i:s format
     * @return string Formatted date in Indonesian
     */
    function format_indo($date) {
        if (empty($date) || $date == '0000-00-00 00:00:00') {
            return '-';
        }

        $bulan = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];

        $split = explode(' ', $date);
        $tgl = explode('-', $split[0]);
        
        if (count($tgl) < 3) {
            return $date;
        }
        
        $result = $tgl[2] . ' ' . $bulan[$tgl[1]] . ' ' . $tgl[0];
        
        // Add time if exists
        if (isset($split[1])) {
            $result .= ' ' . substr($split[1], 0, 5); // Only show hours and minutes
        }
        
        return $result;
    }
}
