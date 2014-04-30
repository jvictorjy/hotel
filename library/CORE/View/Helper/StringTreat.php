<?php

class CORE_View_Helper_StringTreat
{
    
    public function stringTreat($string)
    {
        $caracteres = array("(", ")", "/", "-", ".", " ");

        return str_replace($caracteres, "", $string);
    }
    
}