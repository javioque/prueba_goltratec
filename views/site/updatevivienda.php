<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\TipoVivienda;
?>

<a href="<?= Url::toRoute("site/vervivienda") ?>">Ir listado de viviendas</a>

<h1>Editar Vivienda con id <?= Html::encode($_GET["id_vivienda"]) ?></h1>

<h3><?= $msg ?></h3>

<?php $form = ActiveForm::begin([
    "method" => "post",
    'enableClientValidation' => true,
]);
$model->id_vivienda = $_GET["id_vivienda"];
?>

<?= $form->field($model, "id_vivienda", ['options' => ['value'=> $model->id_vivienda] ])->input("hidden")->label(false) ?>



<div class="form-group">
 <?= $form->field($model, "id_tipo")->label("Tipo de vivienda")->dropDownList(
         ArrayHelper::map(TipoVivienda::find()->all(),'id_tipo','nombre_tipo'),
        ['propmt'=>'Selecciona un tipo de vivienda']
         )?>   
</div>
<div class="form-group">
 <?= $form->field($model, "propietario")->input("text") ?>   
</div>

<div class="form-group">
 <?= $form->field($model, "direccion")->input("text") ?>   
</div>

<div class="form-group">
 <?= $form->field($model, "localidad")->input("text") ?>   
</div>

<div class="form-group">
 <?= $form->field($model, "habitaciones")->input("text") ?>   
</div>
<div class="form-group">
 <?= $form->field($model, "aseos")->input("text") ?>   
</div>
<div class="form-group">
 <?= $form->field($model, "superficie")->input("text") ?>   
</div>

<?= Html::submitButton("Actualizar", ["class" => "btn btn-primary"]) ?>

<?php $form->end() ?>
