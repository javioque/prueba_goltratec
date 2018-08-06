<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>

<a href="<?= Url::toRoute("site/vertipo") ?>">Ir listado de tipos viviendas</a>

<h1>Editar el tipo de Vivienda con id <?= Html::encode($_GET["id_tipo"]) ?></h1>

<h3><?= $msg ?></h3>

<?php $form = ActiveForm::begin([
    "method" => "post",
    'enableClientValidation' => true,
]);
$model->id_tipo = $_GET["id_tipo"];
?>

<?= $form->field($model, "id_tipo")->input("hidden")->label(false) ?>

<?= $msg ?>
<div class="form-group">
 <?= $form->field($model, "nombre_tipo")->input("text") ?>   
</div>

<?= Html::submitButton("Actualiza el tipo", ["class" => "btn btn-primary"]) ?>

<?php $form->end() ?>