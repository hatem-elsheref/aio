<?php

namespace Hatem\Aio\Support;

class Arr
{

    public static function flat($items, $depth = 256)
    {
        $result = [];
        foreach ($items as $item){
            if(!is_array($item)){
                $result[] = $item;
            }else{
                $values = $depth === 1 ? array_values($item) : self::flat($item, $depth - 1);
                foreach ($values as $value){
                    $result[] = $value;
                }
            }
        }

        return $result;
    }
}