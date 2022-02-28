<?php

namespace Lucas\EmissorNotaFiscal\Helper;

class JsonResponser
{
    public static function toJson($array)
    {
        return json_decode(json_encode($array));
    }
}
