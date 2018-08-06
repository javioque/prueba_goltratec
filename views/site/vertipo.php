<?php
use yii\helpers\Url;
use yii\helpers\html;
use yii\widgets\ActiveForm;
use yii\data\Pagination;
use yii\widgets\LinkPager;
use yii\boostrap\modal;
?>

<a href="<?= Url::toRoute("site/creartipo") ?>">Introducir un nueva tipo de Vivienda</a>

<h3>Listado de viviendas</h3>
<table class="table table-bordered">
    <tr>
        <th>ID Tipo</th>
        <th>Tipo de Vivienda</th>
        <th></th>
        <th></th>
    </tr>
    <?php foreach($model as $row): ?>
    <tr>
        <td><?= $row->id_tipo ?></td>
        <td><?= $row->nombre_tipo ?></td>
        <td><a href="<?= Url::toRoute(["site/updatetipo", "id_tipo" => $row->id_tipo]) ?>">Editar</a></td>
        <td>
           <a href="#" data-toggle="modal" data-target="#id_tipo_<?= $row->id_tipo ?>">Eliminar</a>
            <div class="modal fade" role="dialog" aria-hidden="true" id="id_tipo_<?= $row->id_tipo ?>">
                      <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    <h4 class="modal-title">Eliminar tipo de vivienda</h4>
                              </div>
                              <div class="modal-body">
                                    <p>¿Realmente deseas eliminar la vivienda del propietario: <?= $row->nombre_tipo ?>?</p>
                              </div>
                              <div class="modal-footer">
                              <?= Html::beginForm(Url::toRoute("site/deletetipo"), "POST") ?>
                                    <input type="hidden" name="id_tipo" value="<?= $row->id_tipo ?>">
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
