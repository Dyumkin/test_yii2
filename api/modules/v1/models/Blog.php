<?php
/**
 * Created by JetBrains PhpStorm.
 * User: y.dyumkin
 * Date: 19.11.14
 * Time: 4:39
 * To change this template use File | Settings | File Templates.
 */

namespace api\modules\v1\models;

use \common\models\Blog as CommonBlog;

class Blog extends CommonBlog
{
    public function getParentClassName()
    {
        return get_parent_class($this);
    }
}