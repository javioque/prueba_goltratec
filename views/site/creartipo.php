<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<h1>A&ntilde;adir tipo de vivienda</h1>
<a href="<?= Url::toRoute("site/vertipo") ?>">Accede al listado de los tipos de Vivienda</a>
<?php $form = ActiveForm::begin([
    "method" => "post",
    'enableClientValidation' => true,
    "enableAjaxValidation" => false,
]);
?>

<?= $msg ?>
<div class="form-group">
 <?= $form->field($model, "nombre_tipo")->input("text") ?>   
</div>

<?= Html::submitButton("Introduce el tipo", ["class" => "btn btn-primary"]) ?>

<?php $form->end() ?>