<?php
/**
 * Created by JetBrains PhpStorm.
 * User: y.dyumkin
 * Date: 05.11.14
 * Time: 10:33
 * To change this template use File | Settings | File Templates.
 */

namespace common\components\helpers;


use yii\helpers\ArrayHelper;
use common\models\BlogLang;

class CommonHelper extends ArrayHelper {

    /**
     * @param $array[] BlogLang
     * @return array
     */
    public static function changeBlogKeys($array)
    {
        $newArray = [];

        /** @var $object BlogLang */
        foreach($array as $key => $object)
        {
            if ($object instanceof BlogLang)
            {
                $newArray[$object->lang->url] = $object;
            } else
            {
                continue;
            }
        }

        return $newArray;
    }

    /**
     * @param $string string
     * @return int
     */
    public static function generateCRC32Hash($string)
    {
        return (int)sprintf('%u', crc32($string));
    }

}