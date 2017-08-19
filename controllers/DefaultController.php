<?php

namespace vistarsvo\proxymanager\controllers;

use vistarsvo\proxymanager\models\Proxy;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

/**
 * Default controller for the `proxy` module
 */
class DefaultController extends Controller
{
    /**
     * @var
     */
    public $module;


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['?', '@'],
                    ],
                    [
                        'actions' => ['proxy', 'resources', 'actions'],
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['get'],
                ],
            ],
        ];
    }


    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Proxy::find(),
        ]);

        if (Yii::$app->user->isGuest || !Yii::$app->user->can('admin')) {
            return $this->render('index', ['dataProvider' => $dataProvider, 'read-only' => true]);
        } else {
            return $this->render('index', ['dataProvider' => $dataProvider, 'read-only' => false]);
        }
    }
}
