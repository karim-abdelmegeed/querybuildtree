<?php

namespace App;

class Helper
{
    const ISEQUAL  =  '$eq';
    const NOTEQUAL = '$ne';

    public static function getOperation($operation)
    {
      if($operation=='is_equal'){
           return self::ISEQUAL;
      }
      else if($operation=='not_equal'){
        return self::NOTEQUAL;
      }
    }
}
