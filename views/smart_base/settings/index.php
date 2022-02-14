<?php



/* @var $this \yii\web\View */
/* @var $settings \app\models\smart_base\SmartBaseSettings|array|mixed|null|string|\yii\db\ActiveRecord */


use app\models\App;
use yii\helpers\Html;

$this->title = 'Настройки умной базы';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile(App::clearCache('../web/themes/custom/smart_base/settings.js'), ['depends' => 'app\assets\AppAsset']);
if (!$settings) {
    $settings = [];
}
?>

<div class="ibox float-e-margins  animated fadeIn">
    <div class="smart-base-settings-index">
        <div class="crm-panel">
            <h5><?= Html::encode($this->title) ?></h5>
        </div>
    </div>

    <div class="ibox-content">
        <div class="client-index grid-table table-responsive" id="smart-base-settings-container">
            <?php foreach ($settings as $block): ?>
                <div class="setting_block ibox-content">
                    <div class="col-sm-3">
                        <div class="form-content-label col-sm-4">Название поля</div>
                        <div class="form-content-item col-sm-8">
                            <input type="text" class="form-control name" name="name[]" maxlength="255"
                                   placeholder="Укажите название поля" value="<?= $block['name'] ?>">
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-content-label col-sm-4">Тип поля</div>
                        <div class="form-content-item col-sm-8">
                            <select type="text" class="form-control select"
                                    name="type[]">
                                <option value="">Укажите тип поля</option>
                                <?php foreach (array_keys(\app\controllers\smart_base\SettingsController::TYPES) as $type): ?>
                                    <?php if ($block['type'] === $type) {
                                        $selected = 'selected';
                                    } else {
                                        $selected = '';
                                    } ?>
                                    <option <?= $selected ?>
                                            value="<?= $type ?>"><?= \app\controllers\smart_base\SettingsController::TYPES[$type]['label'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-content-label col-sm-4">Варианты списка</div>
                        <div class="form-content-item col-sm-8">
                            <table class="table table-striped">
                                <tbody>
                                <?php foreach ($block['items'] as $item): ?>
                                    <tr>
                                        <td class="variant"><?= $item ?><i
                                                    class="glyphicon glyphicon-trash text-danger delete-block pull-right"></i>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td class="">
                                        <div class="col-sm-8"><input type="text" class="form-control" name="variant[]"
                                                                     maxlength="255" placeholder="Укажите вариант">
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="card-info-btn full primary btn-block add-variant">Добавить</div>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <i class="card-info-btn full danger btn-block glyphicon glyphicon-trash text-danger delete-block"></i>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="ibox-content">
            <div class="col-sm-6">
                <div class="card-info-btn primary btn-block" id="add_block" onclick="PageBuilder.addNewBlock()">Добавить
                    новое поле
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card-info-btn primary btn-block" id="save" onclick="PageBuilder.saveSettings()">Сохранить
                    настройки
                </div>
            </div>
        </div>
    </div>

</div>
