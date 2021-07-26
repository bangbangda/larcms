<?php

function arr_values($data, string $key) {
    $arr = [];
    foreach ($data as $val) {
        $arr[] = $val[$key];
    }
    return $arr;
}