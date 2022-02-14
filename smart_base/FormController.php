<?php

namespace app\controllers\smart_base;

use app\models\smart_base\SmartBase;
use app\models\smart_base\SmartBaseDialogue;
use app\models\smart_base\SmartBaseSettings;
use app\services\smart_base\SmartBaseModel;
use Carbon\Carbon;
use Yii;
use yii\base\InvalidConfigException;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\controllers\AppController;

class FormController extends AppController
{
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
                        'actions' => ['index', 'save-settings', 'index-ajax', 'get-settings', 'get-history','get-dialogue', 'get-client-data', 'save-client-data'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Render index page
     * @return string
     */
    public function actionIndex(): string
    {
        return $this->render('index', [
        ]);
    }

    /**
     * Render form as ajax request
     * @return string
     */
    public function actionIndexAjax(): string
    {
        $settings = SmartBaseSettings::find()
            ->one();

        if ($settings) {
            $settings = $settings->settings;
            $settings = Json::decode($settings);
        }

        return $this->renderAjax('form', [
            'settings' => $settings,
        ]);
    }

    /**
     * Send Client data on ajax request
     */
    public function actionGetClientData(): string
    {
        return $this->getClientData();
    }

    /**
     * Send change history as html
     */
    public function actionGetHistory(): string
    {
        $post = Yii::$app->request->post();
        $number = $post['number'];
        $field = $post['field'];
        $field_history = SmartBase::find()
            ->alias('sb')
            ->joinWith('dialogue')
            ->joinWith('user')
            ->where(['sb.client_number' => $number])
            ->andWhere(['sb.field' => $field])
            ->orderBy("sb.id DESC");
        $dataProvider = new ActiveDataProvider(['query' => $field_history]);
        return $this->renderAjax('grid', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Send dialogue stored info as html
     */
    public function actionGetDialogue(): string
    {
        $post = Yii::$app->request->post();
        $number = $post['number'];
        $id = $post['id'];
        $field_history = SmartBase::find()
            ->alias('sb')
            ->where(['sb.client_number' => $number])
            ->andWhere(['sb.dialogue_id' => $id]);
        $dataProvider = new ActiveDataProvider(['query' => $field_history]);
        return $this->renderAjax('dialogue_grid', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return string
     */
    public static function getClientData(): string
    {
        $post = Yii::$app->request->post();
        $number = $post['number'];
        $client_data = SmartBase::find()
            ->alias('sb')
            ->select(['sb.field', 'sb.value', 'sb.dialogue_id'])
            ->innerJoin('(SELECT field, MAX(dialogue_id) as dialogue_id FROM smart_base WHERE client_number = '.$number.' group by field) sbm', 'sb.field = sbm.field and sb.dialogue_id = sbm.dialogue_id')
            ->asArray()
            ->all();

        return Json::encode($client_data);
    }

    /**
     * Saving Client data to db
     * @return string
     */
    public function actionSaveClientData(): string
    {
        $post = Yii::$app->request->post();
        $number = $post['number'];
        $post_data = $post['data'];

        if ($post_data && $number) {
            $dialogue = new SmartBaseDialogue();
            $dialogue->user_id = Yii::$app->user->id;
            $dialogue->created_at = Carbon::now();
            $dialogue->save();
            $data = Json::decode($post_data);
            if (is_array($data)) {
                $model = new SmartBaseModel($data, $number, $dialogue);
                if ($model->validate()) {
                    $model->save();
                } else {
                    return Json::encode([
                        'number' => $number,
                        'data' => $post_data,
                        'errors' => $model->errors,
                    ]);
                }
            }
        }
        return Json::encode([
            'number' => $number,
            'data' => $post_data,
            'errors' => false,
        ]);
    }
}
