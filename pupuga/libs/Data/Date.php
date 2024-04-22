<?php

namespace Pupuga\Libs\Data;

class Date
{
    /**
     * convert number (1 - 12) to month name
     *
     * @param string $number
     * @param string $lang
     *
     * @return string $monthName
     */
    public static function getLangMonth($number, $lang = 'no')
    {
        switch ($lang) {
            case 'no' :
                $langMonths = array('Januar', 'Februar', 'Mars', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Desember');
                break;
        }
        if (isset($langMonths)) {
            $monthName = $langMonths[$number - 1];
        } else {
            $monthName = '';
        }
        return $monthName;
    }

    /**
     * convert date (y-m-d) to custom format
     *
     * @param  string $date
     * @param  string $format (y-m-d)
     *
     * @return string $formatDate
     */
    public static function getLangDate($date, $format = 'd m y')
    {
        $dateParts = explode('-', $date);
        $dateParts[1] = self::getLangMonth($dateParts[1]);
        $formatDate = str_replace(array('y', 'm', 'd'), $dateParts, $format);
        return $formatDate;
    }

    /**
     * return year or period of years
     *
     * @param  string $period (year | years)
     * @param  string $before text is placing before date
     * @param  string $after text is placing after date
     *
     * @return string $copyright
     */
    public static function getCopyright($period = '', $before = 'Copyright &copy; ', $after = '')
    {
        $year = date('Y');

        $period = empty($period)
            ? $year
            : $period . ' - ' . $year;

        $copyright = $before . $period . $after;

        return $copyright;
    }
}