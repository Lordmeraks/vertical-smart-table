<?php



/* @var $this \yii\web\View */
/* @var $settings \app\models\smart_base\SmartBaseSettings|array|mixed|null|string|\yii\db\ActiveRecord */


use app\models\App;
use yii\helpers\Html;

$this->title = 'Анкета клиента';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile(App::clearCache('../web/themes/custom/modal_window_jquery.js'), ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile(App::clearCache('../web/themes/custom/smart_base/form.js'), ['depends' => 'yii\web\JqueryAsset']);
?>
<div class="col-lg-6">
    <div class="ibox float-e-margins  animated fadeIn">
        <div class="ibox-title">
            <h5>Данные для проверки</h5>
            <div class="ibox-content">
                <div class="row">
                    <input type="text" id="phone" class="form-control" placeholder="№ телефона"
                           aria-invalid="false">
                    <br>
                    <input type="button" id="button_owner_tz" class="btn btn-w-m btn-success btn-block"
                           value="Опросить" onclick="Form.getForm()">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-6" id="form"></div>
