<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\TipoVivienda;
?>

<h1>Introduce los datos de la vivienda</h1>
<?= $msg ?>
<?php $form = ActiveForm::begin([
    "method" => "post",
 'enableClientValidation' => true,
]);
?>
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

<?= Html::submitButton("Nueva Vivienda", ["class" => "btn btn-primary"]) ?>

<?php $form->end() ?>