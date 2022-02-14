<?php



/* @var $this \yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */

use yii\grid\GridView;

?>

<div class="ibox-content">
    <?=
    GridView::widget([
        'id' => 'addpeopleList',
        'dataProvider' =>  $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'field',
                'label' => 'Поле',
                'format' => 'text',
            ],
            [
                'attribute' => 'value',
                'label' => 'Значение',
                'format' => 'text',
            ],
        ],
    ]);
    ?>
</div>
