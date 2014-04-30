<?php

class CORE_View_Helper_FormatDate {

    public static function formatDate($date) {
        $temp = explode('/', $date);

        if (count($temp) == 3) {
            return $temp[2] . "" . $temp[1] . "" . $temp[0];
        }

        $temp = explode('-', $date);

        return (count($temp) == 3) ? $temp[2] . "/" . $temp[1] . "/" . $temp[0] : false;
    }

}