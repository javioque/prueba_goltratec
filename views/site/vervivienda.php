<?php
use yii\helpers\Url;
use yii\helpers\html;
use yii\widgets\ActiveForm;
use yii\data\Pagination;
use yii\widgets\LinkPager;
use yii\boostrap\modal;
?>

<a href="<?= Url::toRoute("site/crearvivienda") ?>">Introducir una nueva Vivienda</a>

<?php $f = ActiveForm::begin([
    "method" => "get",
    "action" => Url::toRoute("site/vervivienda"),
    "enableClientValidation" => true,
]);
?>

<div class="form-group">
    <?= $f->field($form, "q")->input("search") ?>
</div>

<?= Html::submitButton("Buscar", ["class" => "btn btn-primary"]) ?>

<?php $f->end() ?>

<h3><?= $search ?></h3>

<h3>Listado de viviendas</h3>
<table class="table table-bordered">
    <tr>
        <th>Tipo de Vivienda</th>
        <th>Propietario</th>
        <th>Direcci&oacute;n</th>
        <th>Localidad</th>
        <th>Nº de Habitaciones</th>
        <th>Nº Cuartos de baño</th>
        <th>Superficie (m2)</th>
        <th></th>
        <th></th>

    </tr>
    <?php foreach($model as $row): ?>
    <tr>
        <td><?= $row->id_tipo ?></td>
        <td><?= $row->propietario ?></td>
        <td><?= $row->direccion ?></td>
        <td><?= $row->localidad ?></td>
        <td><?= $row->habitaciones ?></td>
        <td><?= $row->aseos ?></td>
        <td><?= $row->superficie ?></td>
        <td><a href="<?= Url::toRoute(["site/updatevivienda", "id_vivienda" => $row->id_vivienda]) ?>">Editar</a></td>
        <td>
           <a href="#" data-toggle="modal" data-target="#id_vivienda_<?= $row->id_vivienda ?>">Eliminar</a>
            <div class="modal fade" role="dialog" aria-hidden="true" id="id_vivienda_<?= $row->id_vivienda ?>">
                      <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    <h4 class="modal-title">Eliminar vivienda</h4>
                              </div>
                              <div class="modal-body">
                                    <p>¿Realmente deseas eliminar la vivienda del propietario: <?= $row->propietario ?>?</p>
                              </div>
                              <div class="modal-footer">
                              <?= Html::beginForm(Url::toRoute("site/delete"), "POST") ?>
                                    <input type="hidden" name="id_vivienda" value="<?= $row->id_vivienda ?>">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Eliminar</button>
                              <?= Html::endForm() ?>
                              </div>
                            </div><!-- /.modal-content -->
                      </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

        </td>
    </tr>
    <?php endforeach ?>
</table>

<?= LinkPager::widget([
    "pagination" => $pages,
]);