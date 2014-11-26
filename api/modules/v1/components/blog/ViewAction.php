<?php
/**
 * Created by JetBrains PhpStorm.
 * User: y.dyumkin
 * Date: 21.11.14
 * Time: 11:32
 * To change this template use File | Settings | File Templates.
 */

namespace api\modules\v1\components\blog;

use api\modules\v1\components\helpers\ApiHelper;
use yii\rest\ViewAction as RestView;

class ViewAction extends RestView
{
    public function run($id)
    {
        $model = $this->findModel($id);
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }

        $data = ApiHelper::getRelationData($model, 'blogLangs');

        return $data;
    }
}