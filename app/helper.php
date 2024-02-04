<?php

function secondsToTime($seconds)
{
    if ($seconds <= 59) {
        $format = $seconds . " seconds";
    } elseif ($seconds > 59) {
        $format = floor($seconds / 60) . " minutes, ";
        $format .=  ($seconds % 60) . " seconds";
    } else if ($seconds > 3559) {
        $format = floor($seconds / 3600) . " hours, ";
        $secondsLeft = $seconds % 3600;
        if ($secondsLeft <= 59) {
            $format .= $secondsLeft . " seconds";
        } elseif ($secondsLeft > 59) {
            $format .= floor($secondsLeft / 60) . " minutes, ";
            $format .=  ($seconds % 60) . " seconds";
        }
    }
    return $format;
}

function prx($value)
{
    echo "<pre>";
    print_r($value);
    die;
}
