<?php
/**
 * Created by JetBrains PhpStorm.
 * User: y.dyumkin
 * Date: 24.10.14
 * Time: 14:27
 * To change this template use File | Settings | File Templates.
 */

namespace common\components\lang;

use Yii;
use yii\web\Request;
use common\models\Lang;

class LangRequest extends Request
{
    protected function resolveRequestUri()
    {
        $lang_prefix = null;
        $requestUri = parent::resolveRequestUri();
        $requestUriToList = explode('/', $requestUri);
        $lang_url = isset($requestUriToList[1]) ? $requestUriToList[1] : null;

        Lang::setCurrent($lang_url);

        if( $lang_url !== null && $lang_url === Lang::getCurrent()->url && strpos($requestUri, Lang::getCurrent()->url) === 1 )
        {
            $requestUri = substr($requestUri, strlen(Lang::getCurrent()->url)+1 );
        }
        return $requestUri;
    }
}