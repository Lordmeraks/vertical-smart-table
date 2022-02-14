<?php



/* @var $this \yii\web\View */
/* @var $settings \app\models\smart_base\SmartBaseSettings|array|mixed|null|\yii\db\ActiveRecord */

use yii\helpers\Html;
$this->title = 'Анкета клиента';
if (!$settings) {
    $settings = [];
}
?>
<div class="col-lg-6" id="form">
    <div class="ibox float-e-margins  animated fadeIn">
        <div class="smart-base-settings-index">
            <div class="crm-panel">
                <h5><?= Html::encode($this->title) ?></h5>
            </div>
        </div>
        <div class="client-index form_item_style" id="smart-base-settings-container">
            <div class="setting_block">
                <?php foreach ($settings as $block): ?>
                    <div class="form-content-item client-form-content">
                        <div class="form-content-label col-sm-4">
                            <?= $block['name'] ?>
                        </div>
                        <?php if ($block['type'] === 'dropdown'): ?>
                            <div class="form-content-input col-sm-7">
                                <select type="text" data-type="<?= $block['type'] ?>" class="form-control select"
                                        name="<?= $block['name'] ?>">
                                    <option value="">Укажите <?= $block['name'] ?></option>
                                    <?php foreach ($block['items'] as $item): ?>
                                        <option value="<?= $item ?>"><?= $item ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php else: ?>
                            <div class="form-content-input col-sm-7">
                                <input type="text" class="form-control name" data-type="<?= $block['type'] ?>" name="<?= $block['name'] ?>"
                                       maxlength="255"
                                       placeholder="Укажите <?= $block['name'] ?>">
                                <div class="error" style="font-size: 10px; color: #9e0505"></div>
                            </div>
                        <?php endif; ?>
                        <div class="form-content col-sm-1">
                            <div class="card-info-btn primary btn-block show-history" style="display: none">
                                <i class="fa fa-book" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="form-content-item client-form-content">
                <div class="card-info-btn primary btn-block" id="add_block" onclick="Form.saveForm()">
                    Сохранить анкету
                </div>
            </div>
        </div>
    </div>
</div>
