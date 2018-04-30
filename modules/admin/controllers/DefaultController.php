<?php

namespace app\modules\admin\controllers;

use app\modules\admin\components\AdminController;
use yii\helpers\ArrayHelper;

/**
 * Default controller for the `admin` module
 */
class DefaultController extends AdminController
{
    public function behaviors()
    {
        $behaviors = [];
        return ArrayHelper::merge($behaviors,parent::behaviors());
    }
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
