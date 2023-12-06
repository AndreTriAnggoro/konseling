<?php

namespace App\Helpers;

class CarbonHelper
{
    public static function customDiffForHumans($updated_at, $tanggal)
    {
        $diff = \Carbon\Carbon::parse($updated_at)->diffForHumans(\Carbon\Carbon::parse($tanggal), true);
        $replacements = [
            'minutes' => 'menit',
            'minute' => 'menit',
            'hours' => 'jam',
            'hour' => 'jam',
            'days' => 'hari',
            'day' => 'hari',
            'months' => 'bulan',
            'month' => 'bulan',
            'years' => 'tahun',
            'year' => 'tahun',
        ];

        // Mengganti string sesuai dengan peta penggantian
        return str_replace(array_keys($replacements), array_values($replacements), $diff);
    }
}
