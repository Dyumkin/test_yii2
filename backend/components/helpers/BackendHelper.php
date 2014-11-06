<?php
/**
 * Created by JetBrains PhpStorm.
 * User: y.dyumkin
 * Date: 06.11.14
 * Time: 4:57
 * To change this template use File | Settings | File Templates.
 */

namespace backend\components\helpers;



class BackendHelper
{

    public static function unsetEmptyAttribute($array)
    {

        foreach($array as $key => $value)
        {
            if (empty($value))
            {
                unset($array[$key]);
            } else if (is_array($value))
            {
                foreach ($value as $subkey => $subvalue)
                {
                    if (empty($subvalue))
                    {
                        unset($array[$key][$subkey]);
                    }
                }
            }
        }

        return $array;
    }
}