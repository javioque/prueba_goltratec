<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\widgets\ActiveForm;
use yii\web\Response;
use app\models\FormVivienda;
use app\models\Vivienda;
use app\models\FormBuscar;
use yii\helpers\Html;
use yii\data\Pagination;
use app\models\FormUsuario;
use app\models\Usuarios;
use yii\web\Session;
use app\models\FormRecuperaPass;
use app\models\FormResetPass;
use app\models\FormTipo;
use app\models\TipoVivienda;

class SiteController extends Controller
{   
    /*
     * Funciones relacionadas con los tipos de vivienda
     */
    public function actionCreartipo()
    {
        $model = new FormTipo;
        $msg = null;
        
        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->validate())
            {
                $table = new TipoVivienda;
                $table->nombre_tipo = $model->nombre_tipo;
                if ($table->insert())
                {
                    $msg = "El tipo de vivienda se ha añadido correctamente";
                }
                else
                {
                    $msg = "No se ha podido introducir el nuevo tipo de vivienda";
                    
                }
            }
            else
            {
                $model->getErrors();
            }
        }
        return $this->render("creartipo", ["model" => $model, "msg" => $msg]);
    }
    
    public function actionVertipo()
    {
        $model = new FormTipo;
        $table = new TipoVivienda;
        $model = $table->find()->all();
        return $this->render("vertipo", ["model" => $model]);
    }
    
    public function actionDeletetipo()
    {
        if(Yii::$app->request->post())
        {
            $id_tipo = Html::encode($_POST["id_tipo"]);
            if((int) $id_tipo)
            {
                if(TipoVivienda::deleteAll("id_tipo=:id_tipo", [":id_tipo" => $id_tipo]))
                {
                    echo "el tipo de vievo9enda con id $id_tipo eliminado con éxito, redireccionando ...";
                    echo "<meta http-equiv='refresh' content='3; ".Url::toRoute("site/vertipo")."'>";
                }
                else
                {
                    echo "Ha ocurrido un error al eliminar el tipo de vivienda, redireccionando ...";
                    echo "<meta http-equiv='refresh' content='3; ".Url::toRoute("site/vertipo")."'>"; 
                }
            }
            else
            {
                echo "Ha ocurrido un error al eliminar el tipo de vivienda, redireccionando ...";
                echo "<meta http-equiv='refresh' content='3; ".Url::toRoute("site/vertipo")."'>";
            }
        }
        else
        {
            return $this->redirect(["site/vertipo"]);
        }
    }
    
    public function actionUpdatetipo()
    {
        $model = new FormTipo;
        $msg = null;
        $table = new TipoVivienda;
        if($model->load(Yii::$app->request->post('id_tpo')))
        {
            if($model->validate())
            {
                $table = TipoVivienda::findOne($model->id_tipo);
                if($table)
                {
                    $table->nombre_tipo = $model->nombre_tipo;
                    if ($table->update())
                    {
                        $msg = "El tipo de vivienda ha sido actualizado correctamente";
                    }
                    else
                    {
                        $msg = "el tipo vivienda no ha podido ser actualizado";
                    }
                    
                }
                else
                {
                    $msg = "El tipo de vivienda seleccionado no ha sido encontrado";
                }
            }
            else
            {
                $model->getErrors();
            }
        }
        if (Yii::$app->request->get())
        {
            $id_tipo = Html::encode($_GET["id_tipo"]);
            if ((int) $id_tipo)
            {
                $table = TipoVivienda::findOne($id_tipo);
                if($table)
                {
                    $model->id_tipo = $table->id_tipo;
                    $model->nombre_tipo = $table->nombre_tipo;
                }
                else
                {
                    return $this->redirect(["site/vertipo"]);
                }
            }
            else
            {
                return $this->redirect(["site/vertipo"]);
            }
        }
        else
        {
            return $this->redirect(["site/vertipo"]);
        }
        return $this->render("updatetipo", ["model" => $model, "msg" => $msg]);
    }
    
    /*
     * Funciones relacionadas con los usuarios
     */
    public function actionRecuperapass()
    {
        //Instancia para validar el formulario
        $model = new FormRecoverPass;
  
        //Mensaje que será mostrado al usuario en la vista
        $msg = null;
  
        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->validate())
            {
                //Buscar al usuario a través del email
                $table = Usuarios::find()->where("email=:email", [":email" => $model->email]);
    
                //Si el usuario existe
                if ($table->count() == 1)
                {
                    //Crear variables de sesión para limitar el tiempo de restablecido del password
                    //hasta que el navegador se cierre
                    $session = new Session;
                    $session->open();
                    //Esta clave aleatoria se cargará en un campo oculto del formulario de reseteado
                    $session["recover"] = $this->randKey("abcdef0123456789", 200);
                    $recover = $session["recover"];
                    /* También almacenaremos el id del usuario en una variable de sesión
                     * El id del usuario es requerido para generar la consulta a la tabla users y 
                     * restablecer el password del usuario
                     */
                    $table = Users::find()->where("email=:email", [":email" => $model->email])->one();
                    $session["id_recover"] = $table->id;
                    /* Esta variable contiene un número hexadecimal que será enviado en el correo al usuario 
                    * para que lo introduzca en un campo del formulario de reseteado
                    * Es guardada en el registro correspondiente de la tabla users
                    */
                    $verification_code = $this->randKey("abcdef0123456789", 8);
                    //Columna verification_code
                    $table->verification_code = $verification_code;
                    //Guardamos los cambios en la tabla users
                    $table->save();
                    //Creamos el mensaje que será enviado a la cuenta de correo del usuario
                    $subject = "Recuperar password";
                    $body = "<p>Copie el siguiente código de verificación para restablecer su password ... ";
                    $body .= "<strong>".$verification_code."</strong></p>";
                    $body .= "<p><a href='http://yii.local/index.php?r=site/resetpass'>Recuperar password</a></p>";
                    //Enviamos el correo
                    Yii::$app->mailer->compose()
                    ->setTo($model->email)
                    ->setFrom([Yii::$app->params["adminEmail"] => Yii::$app->params["title"]])
                    ->setSubject($subject)
                    ->setHtmlBody($body)
                    ->send();
                    //Vaciar el campo del formulario
                    $model->email = null;
                    //Mostrar el mensaje al usuario
                    $msg = "Le hemos enviado un mensaje a su cuenta de correo para que pueda resetear su password";
                }
                else //El usuario no existe
                {
                    $msg = "Ha ocurrido un error";
                }
            }
            else
            {
                $model->getErrors();
            }
        }
        return $this->render("recoverpass", ["model" => $model, "msg" => $msg]);
    }
 
    public function actionResetpass()
    {
        //Instancia para validar el formulario
        $model = new FormResetPass;
        //Mensaje que será mostrado al usuario
        $msg = null;
        //Abrimos la sesión
        $session = new Session;
        $session->open();
        //Si no existen las variables de sesión requeridas lo expulsamos a la página de inicio
        if (empty($session["recover"]) || empty($session["id_recover"]))
        {
            return $this->redirect(["site/index"]);
        }
        else
        {
            $recover = $session["recover"];
            //El valor de esta variable de sesión la cargamos en el campo recover del formulario
            $model->recover = $recover;
            //Esta variable contiene el id del usuario que solicitó restablecer el password
            //La utilizaremos para realizar la consulta a la tabla users
            $id_recover = $session["id_recover"];
        }
        //Si el formulario es enviado para resetear el password
        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->validate())
            {
                //Si el valor de la variable de sesión recover es correcta
                if ($recover == $model->recover)
                {
                    //Preparamos la consulta para resetear el password, requerimos el email, el id 
                    //del usuario que fue guardado en una variable de session y el código de verificación
                    //que fue enviado en el correo al usuario y que fue guardado en el registro
                    $table = Users::findOne(["email" => $model->email, "id" => $id_recover, "verification_code" => $model->verification_code]);
                    //Encriptar el password
                    $table->password = crypt($model->password, Yii::$app->params["salt"]);
                    //Si la actualización se lleva a cabo correctamente
                    if ($table->save())
                    {
                        //Destruir las variables de sesión
                        $session->destroy();
                        //Vaciar los campos del formulario
                        $model->email = null;
                        $model->password = null;
                        $model->password_repeat = null;
                        $model->recover = null;
                        $model->verification_code = null;
                        $msg = "Enhorabuena, password reseteado correctamente, redireccionando a la página de login ...";
                        $msg .= "<meta http-equiv='refresh' content='5; ".Url::toRoute("site/login")."'>";
                    }
                    else
                    {
                        $msg = "Ha ocurrido un error";
                    }
                }
                else
                {
                    $model->getErrors();
                }
            }
        }
        return $this->render("resetpass", ["model" => $model, "msg" => $msg]);
    }
    
    
    private function randKey($str='', $long=0)
    {
        $key = null;
        $str = str_split($str);
        $start = 0;
        $limit = count($str)-1;
        for($x=0; $x<$long; $x++)
        {
            $key .= $str[rand($start, $limit)];
        }
        return $key;
    }
  
    public function actionConfirm()
    {
        $table = new Usuarios;
        if (Yii::$app->request->get())
        {
   
            //Obtenemos el valor de los parámetros get
             $id = Html::encode($_GET["id"]);
             $authKey = $_GET["authKey"];
    
            if ((int) $id)
            {
                //Realizamos la consulta para obtener el registro
                $model = $table
                ->find()
                ->where("id=:id", [":id" => $id])
                ->andWhere("authKey=:authKey", [":authKey" => $authKey]);
 
                //Si el registro existe
                if ($model->count() == 1)
                {
                    $activar = Users::findOne($id);
                    $activar->activate = 1;
                    if ($activar->update())
                    {
                        echo "Enhorabuena registro llevado a cabo correctamente, redireccionando ...";
                        echo "<meta http-equiv='refresh' content='8; ".Url::toRoute("site/login")."'>";
                    }
                    else
                    {
                        echo "Ha ocurrido un error al realizar el registro, redireccionando ...";
                        echo "<meta http-equiv='refresh' content='8; ".Url::toRoute("site/login")."'>";
                    }
                }
                else //Si no existe redireccionamos a login
                {
                    return $this->redirect(["site/login"]);
                }
            }
            else //Si id no es un número entero redireccionamos a login
            {
                return $this->redirect(["site/login"]);
            }
        }
    }
 
    public function actionCrearusuario()
    {
        //Creamos la instancia con el model de validación
        $model = new FormUsuario;
   
        //Mostrará un mensaje en la vista cuando el usuario se haya registrado
        $msg = null;
   
        //Validación mediante ajax
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax)
        {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
   
        /* Validación cuando el formulario es enviado vía post
        * Esto sucede cuando la validación ajax se ha llevado a cabo correctamente
        * También previene por si el usuario tiene desactivado javascript y la
        * validación mediante ajax no puede ser llevada a cabo
        */
        if ($model->load(Yii::$app->request->post()))
        {
            if($model->validate())
            {
                //Preparamos la consulta para guardar el usuario
                $table = new Usuarios;
                $table->username = $model->username;
                $table->email = $model->email;
                //Encriptamos el password
                $table->password = crypt($model->password, Yii::$app->params["salt"]);
                //Creamos una cookie para autenticar al usuario cuando decida recordar la sesión, esta misma
                //clave será utilizada para activar el usuario
                $table->authKey = $this->randKey("abcdef0123456789", 200);
                //Creamos un token de acceso único para el usuario
                $table->accessToken = $this->randKey("abcdef0123456789", 200);
     
                //Si el registro es guardado correctamente
                if ($table->insert())
                {
                    //Nueva consulta para obtener el id del usuario
                    //Para confirmar al usuario se requiere su id y su authKey
                    $user = $table->find()->where(["email" => $model->email])->one();
                    $id = urlencode($user->id);
                    $authKey = urlencode($user->authKey);
      
                    $subject = "Confirmar registro";
                    $body = "<h1>Haga click en el siguiente enlace para finalizar tu registro</h1>";
                    $body .= "<a href='http://yii.local/index.php?r=site/confirm&id=".$id."&authKey=".$authKey."'>Confirmar</a>";
      
                    //Enviamos el correo
                    Yii::$app->mailer->compose()
                    ->setTo($user->email)
                    ->setFrom([Yii::$app->params["adminEmail"] => Yii::$app->params["title"]])
                    ->setSubject($subject)
                    ->setHtmlBody($body)
                    ->send();
     
                    $model->username = null;
                    $model->email = null;
                    $model->password = null;
                    $model->password_repeat = null;
     
                    $msg = "Enhorabuena, ahora sólo falta que confirmes tu registro en tu cuenta de correo";
                }
                else
                {
                    $msg = "Ha ocurrido un error al llevar a cabo tu registro";
                }
     
            }
            else
            {
                $model->getErrors();
            }
        }
        return $this->render("crearusuario", ["model" => $model, "msg" => $msg]);
    }      
    
    /*
     * Funciones relacionadas con el apartado viviendas
     */
    public function actionUpdatevivienda()
    {
        $model = new FormVivienda;
        $msg = null;
        $table = new Vivienda;
        if($model->load(Yii::$app->request->post()))
        {
            if($model->validate())
            {
                $table = Vivienda::findOne($model->id_vivienda);
                if($table)
                {
                    $table->id_tipo = $model->id_tipo;
                    $table->propietario = $model->propietario;
                    $table->direccion = $model->direccion;
                    $table->localidad = $model->localidad;
                    $table->habitaciones = $model->habitaciones;
                    $table->aseos = $model->aseos;
                    $table->superficie = $model->superficie;
                    if ($table->update())
                    {
                        $msg = "La vivienda ha sido actualizado correctamente";
                    }
                    else
                    {
                        $msg = "La vivienda no ha podido ser actualizado";
                    }
                }
                else
                {
                    $msg = "La vivienda seleccionado no ha sido encontrada";
                }
            }
            else
            {
                $model->getErrors();
            }
        }
        if (Yii::$app->request->get("id_vivienda"))
        {
            $id_vivienda = Html::encode($_GET["id_vivienda"]);
            if ((int) $id_vivienda)
            {
                $table = Vivienda::findOne($id_vivienda);
                if($table)
                {
                    $model->id_vivienda = $table->id_vivienda;
                    $model->id_tipo = $table->id_tipo;
                    $model->propietario = $table->propietario;
                    $model->direccion = $table->direccion;
                    $model->localidad = $table->localidad;
                    $model->habitaciones = $table->habitaciones;
                    $model->aseos = $table->aseos;
                    $model->superficie = $table->superficie;
                }
                else
                {
                    return $this->redirect(["site/vervivienda"]);
                }
            }
            else
            {
                return $this->redirect(["site/vervivienda"]);
            }
        }
        else
        {
            return $this->redirect(["site/vervivienda"]);
        }
        return $this->render("updatevivienda", ["model" => $model, "msg" => $msg]);
    }

    /*
     * Eliminar vivienda a través de una aacción por medio de un diálogo modal
     */
    public function actionDelete()
    {
        if(Yii::$app->request->post())
        {
            $id_vivienda = Html::encode($_POST["id_vivienda"]);
            if((int) $id_vivienda)
            {
                if(Vivienda::deleteAll("id_vivienda=:id_vivienda", [":id_vivienda" => $id_vivienda]))
                {
                    echo "Alumno con id $id_vivienda eliminado con éxito, redireccionando ...";
                    echo "<meta http-equiv='refresh' content='3; ".Url::toRoute("site/vervivienda")."'>";
                }
                else
                {
                    echo "Ha ocurrido un error al eliminar el alumno, redireccionando ...";
                    echo "<meta http-equiv='refresh' content='3; ".Url::toRoute("site/vervivienda")."'>"; 
                }
            }
            else
            {
                echo "Ha ocurrido un error al eliminar el alumno, redireccionando ...";
                echo "<meta http-equiv='refresh' content='3; ".Url::toRoute("site/vervivienda")."'>";
            }
        }
        else
        {
            return $this->redirect(["site/vervivienda"]);
        }
    }
    
    public function actionVervivienda()
    {
        $form = new FormBuscar;
        $search = null;
        if($form->load(Yii::$app->request->get()))
        {
            if ($form->validate())
            {
                $search = Html::encode($form->q);
                $table = Vivienda::find()
                        ->where(["like", "propietario", $search])
                        ->orWhere(["like", "direccion", $search])
                        ->orWhere(["like", "localidad", $search])
                        ->orWhere(["like", "habitaciones", $search])
                        ->orWhere(["like", "aseos", $search])
                        ->orWhere(["like", "superficie", $search]);
                $count = clone $table;
                $pages = new Pagination([
                    "pageSize" => 2,
                    "totalCount" => $count->count()
                ]);
                $model = $table
                        ->offset($pages->offset)
                        ->limit($pages->limit)
                        ->all();
            }
            else
            {
                $form->getErrors();
            }
        }
        else
        {
            $table = Vivienda::find();
            $count = clone $table;
            $pages = new Pagination([
                "pageSize" => 2,
                "totalCount" => $count->count(),
            ]);
            $model = $table
                    ->offset($pages->offset)
                    ->limit($pages->limit)
                    ->all();
        }
        return $this->render("vervivienda", ["model" => $model, "form" => $form, "search" => $search, "pages" => $pages]);
    }
    

    
    public function actionCrearvivienda()
    {
        $model = new FormVivienda;
        $msg = "mensaje";
        if($model->load(Yii::$app->request->post()))
        {
            if($model->validate())
            {
                $table = new Vivienda;
                $table->id_tipo = $model->id_tipo;
                $table->propietario = $model->propietario;
                $table->direccion = $model->direccion;
                $table->localidad = $model->localidad;
                $table->habitaciones = $model->habitaciones;
                $table->aseos = $model->aseos;
                $table->superficie = $model->superficie;
                if ($table->insert())
                {
                    $msg = "Enhorabuena registro guardado correctamente";
                    $model->id_tipo = null;
                    $model->propietario = null;
                    $model->direccion = null;
                    $model->localidad = null;
                    $model->habitaciones = null;
                    $model->aseos = null;
                    $model->superficie = null;
                }
                else
                {
                    $msg = "Ha ocurrido un error al insertar el registro";
                }
            }
            else
            {
                $model->getErrors();
            }
        }
        return $this->render("crearvivienda", ['model' => $model, 'msg' => $msg]);
    }
    
        
    /*
     * Funciones del esqueleto de la aplicación
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
}
