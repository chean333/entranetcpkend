<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Knowledge */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Knowledges', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="knowledge-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Deleteลบไฟล์', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'คุณแน่ใจหรือยังว่าจะลบมันหายไปเลยนะ',
               'method' => 'post',
           ],
        ]) ?>
        <p><a class="btn btn-lg btn-success" href="http://192.168.1.18/entranetcpk/frontend/web/index.php?r=knowledge%2Findex ">กลับไปยังการค้นหา</a></p>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'knowledge',
            [
                'attribute' => 'files',
                'format' => 'raw',
                'value' => call_user_func(function($data){
                    $files = null;
                    if($data->files){
                        foreach ($data->getFiles() as $key => $value) {
                            $files .= Html::a('<i class="glyphicon glyphicon-trash"></i>',['delete-file', 'id' => $data->id, 'file' => $value], ['class' => 'btn btn-xs btn-danger', 'data' => ['confirm' => 'แน่ใจนะว่าต้องการลบ?', 'method' => 'post']]).' '.
                            Html::a($value, Url::to(Yii::getAlias('@web').'/'.$data->uploadFilesFolder.'/'.$value), ['target' => '_blank']).'<br />';

                        }
                        return $files;
                    }else{
                        return null;
                    }
                },$model),
            ]
        ],
    ]) ?>

</div>
