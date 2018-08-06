<?php

namespace app\models;
use Yii;
use yii\base\model;

class FormTipo extends model
{
    // Propiedades
    public $id_tipo;
    public $nombre_tipo;
    
    public function rules()
    {
        return [
            ['nombre_tipo', 'required', 'message' => 'Campo requerido'],
            ['nombre_tipo', 'match', 'pattern' => "/^.{3,50}$/", 'message' => 'Mínimo 3 y máximo 50 caracteres'],
            ['nombre_tipo', 'match', 'pattern' => "/^[0-9a-z]+$/i", 'message' => 'Sólo se aceptan letras y números'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'nombre_tipo' => 'Tipo de vivienda:',
        ];
    }
 
}