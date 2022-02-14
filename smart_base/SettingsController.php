<?php

namespace app\controllers\smart_base;

use app\models\smart_base\SmartBaseSettings;
use app\services\smart_base\validators\DefaultValidator;
use app\services\smart_base\validators\EmailValidator;
use app\services\smart_base\validators\OnlyCharValidator;
use app\services\smart_base\validators\OnlyNumValidator;
use app\services\smart_base\validators\TZValidator;
use Carbon\Carbon;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\controllers\AppController;

class SettingsController extends AppController
{
    const TYPES = [
        'input' => [
            'validator' => DefaultValidator::class,
            'label' => 'Обычный ввод',
        ],
        'dropdown' => [
            'validator' => DefaultValidator::class,
            'label' => 'Выпадающий список',
        ],
        'only_num' => [
            'validator' => OnlyNumValidator::class,
            'label' => 'Только цифры',
        ],
        'only_char' => [
            'validator' => OnlyCharValidator::class,
            'label' => 'Только буквы',
        ],
        'tz' => [
            'validator' => TZValidator::class,
            'label' => 'Теудат Зеут',
        ],
        'email' => [
            'validator' => EmailValidator::class,
            'label' => 'Ел. почта',
        ],
    ];

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'save-settings', 'get-settings'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Show settings for smart-base.
     * @return string
     */
    public function actionIndex(): string
    {
        $settings = SmartBaseSettings::find()
            ->one();

        if ($settings) {
            $settings = $settings->settings;
            $settings = Json::decode($settings);
        }

        return $this->render('index', [
            'settings' => $settings,
        ]);
    }

    /**
     * Save settings for smart-base.
     * @return string
     */
    public function actionSaveSettings(): string
    {
        $settings = SmartBaseSettings::find()
            ->one();
        $post = Yii::$app->request->post();
        if ($post['data']) {
            if (!$settings) {
                $settings = new SmartBaseSettings();
                $settings->created_at = Carbon::now();
                $settings->created_by = Yii::$app->user->id;
            }
            $settings->updated_at = Carbon::now();
            $settings->settings = $post['data'];
            if ($settings->validate()) {
                $settings->save();
            }
        }


        return $settings->settings;
    }

    /**
     * @return false|mixed|string|null
     */
    public function actionGetSettings()
    {
        $settings = SmartBaseSettings::find()
            ->one();

        if ($settings) {
            return $settings->settings;
        } else {
            return false;
        }
    }
}
