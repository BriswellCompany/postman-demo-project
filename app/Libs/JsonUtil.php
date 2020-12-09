<?php

namespace App\Libs;

class JsonUtil
{
    public static function readData4Json($secion) {
        $jsonString = file_get_contents(base_path("resources/json/{$secion}.json"));

        return json_decode($jsonString, true);
    }

    public static function writeData4Json($section, $data) {
        try {
            $content = json_encode($data, JSON_PRETTY_PRINT);
            file_put_contents(base_path("resources/json/{$section}.json"), stripslashes($content));

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
