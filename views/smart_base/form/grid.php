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
                'attribute' => 'value',
                'label' => 'Значение',
                'format' => 'text',
                ],
            [
                'attribute' => 'created',
                'label' => 'Изменено',
                'format' => 'text',
                'content' => function ($data) {
                    return \Carbon\Carbon::parse($data->dialogue->created_at)->format('d-m-Y') . '<a class="glyphicon glyphicon-eye-open pull-right dialogue-history" data-dialogue="' .$data->dialogue->id.'" data-original-title="История диалога" data-toggle="tooltip"></a>';
                },
                ],
            [
                'attribute' => 'first_name',
                'label' => 'Кем изменено',
                'format' => 'text',
                'content' => function ($data) {
                    return $data->user->first_name." ".$data->user->last_name;
                }, ],
        ],
    ]);
    ?>
</div>
