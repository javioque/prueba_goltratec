<?php

namespace app\models;
use Yii;
use yii\base\model;

class FormVivienda extends model{
    // propiedades
    public $id_vivienda;
    public $id_tipo;
    public $propietario;
    public $direccion;
    public $localidad;
    public $habitaciones;
    public $aseos;
    public $superficie;
    
    public function rules()
    {
    return [
        ['id_tipo', 'required', 'message' => 'Campo requerido'],
        ['id_tipo', 'integer', 'message' => 'Sólo números enteros'],
        ['propietario', 'required', 'message' => 'Campo requerido'],
        //['propìetario', 'match', 'pattern' => '/^[a-záéíóúñ\s]+$/i', 'message' => 'Sólo se aceptan letras'],
        ['propietario', 'match', 'pattern' => '/^.{3,50}$/', 'message' => 'Mínimo 3 máximo 50 caracteres'],
        ['direccion', 'required', 'message' => 'Campo requerido'],
        //['direccion', 'match', 'pattern' => '/^[a-záéíóúñ\s]+$/i', 'message' => 'Sólo se aceptan letras'],
        ['direccion', 'match', 'pattern' => '/^.{3,80}$/', 'message' => 'Mínimo 3 máximo 80 caracteres'],
        ['localidad', 'required', 'message' => 'Campo requerido'],
        ['localidad', 'match', 'pattern' => '/^[a-záéíóúñ\s]+$/i', 'message' => 'Sólo se aceptan letras'],
        ['localidad', 'match', 'pattern' => '/^.{2,120}$/', 'message' => 'Mínimo 2 máximo 120 caracteres'],
        ['habitaciones', 'required', 'message' => 'Campo requerido'],
        ['habitaciones', 'integer', 'message' => 'Sólo números enteros'],
        ['aseos', 'required', 'message' => 'Campo requerido'],
        ['aseos', 'integer', 'message' => 'Sólo números enteros'],
        ['superficie', 'required', 'message' => 'Campo requerido'],
        ['superficie', 'number', 'message' => 'Sólo números'],
        ];
    }
 
}