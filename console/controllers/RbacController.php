<?php
/**
 * Created by JetBrains PhpStorm.
 * User: y.dyumkin
 * Date: 20.10.14
 * Time: 13:31
 * To change this template use File | Settings | File Templates.
 */

namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\components\rbac\UserRoleRule;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();
        // add "createPost" permission
        $createPost = $auth->createPermission('createPost');
        $createPost->description = 'Create a post';
        $auth->add($createPost);

        // add "updatePost" permission
        $updatePost = $auth->createPermission('updatePost');
        $updatePost->description = 'Update post';
        $auth->add($updatePost);

        $dashboard = $auth->createPermission('dashboard');
        $dashboard->description = 'Admin panel';
        $auth->add($dashboard);

        $rule = new UserRoleRule();
        $auth->add($rule);

        // add "author" role and give this role the "createPost" permission
        $user = $auth->createRole('user');
        $user->ruleName = $rule->name;
        $auth->add($user);
        $auth->addChild($user, $createPost);

        // add "admin" role and give this role the "updatePost" permission
        // as well as the permissions of the "author" role
        $admin = $auth->createRole('admin');
        $admin->ruleName = $rule->name;
        $auth->add($admin);
        $auth->addChild($admin, $updatePost);
        $auth->addChild($admin, $user);
        $auth->addChild($admin, $dashboard);

        $auth->assign($admin,1);

    }

}