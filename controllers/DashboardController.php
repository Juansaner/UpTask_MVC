<?php 

namespace Controllers;
use MVC\Router;
use Model\Proyecto;
use Model\Usuario;

class DashboardController {
    public static function index(Router $router) {
        session_start();
        isAuth();
        //Obtener los proyectos del usuario
        $id = $_SESSION['id'];
        $proyectos = Proyecto::belongsTo('propietarioId', $id);
        $router->render('dashboard/index', [
            'titulo' => 'Proyectos',
            'proyectos' => $proyectos
        ]);
    }

    public static function proyecto(Router $router) {
        session_start();
        isAuth();
        $token = $_GET['id'];
        if(!$token) {
            header('Location: /dashboard');
        }
        //Revisar que la persona que visita el proyecto es quien lo creo
        $proyecto = Proyecto::where('url', $token);
        if($proyecto->propietarioId !== $_SESSION['id']){
            header('Location: /dashboard');
        }
        $titulo = $proyecto->proyecto;
        $router->render('dashboard/proyecto', [
            'titulo' => $titulo
        ]);
    }

    public static function crear_proyecto(Router $router){
        session_start();
        isAuth();
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $proyecto = new Proyecto($_POST);
            $alertas = $proyecto->validarProyecto();

            if(empty($alertas)) {
                //Genera URL unica 
                $proyecto->url = md5(uniqid());
                //Almacena creador del proyecto
                $proyecto->propietarioId = $_SESSION['id'];
                //Guardar proyecto
                $proyecto->guardar();
                //Redireccionar
                header('Location: /proyecto?id=' . $proyecto->url);
            }
        }

        $router->render('dashboard/crear-proyecto', [
            'alertas' => $alertas,
            'titulo' => 'Crear proyecto'
        ]);
    }

    public static function eliminar_proyecto() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

        }
        
    }

    public static function perfil(Router $router){
        session_start();
        isAuth();
        $alertas = [];

        $usuario = Usuario::find($_SESSION['id']);

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validar_perfil();
            if(empty($alertas)) {

                $existeUsuario = Usuario::where('email', $usuario->email);
                if($existeUsuario && $existeUsuario->id !== $usuario->id) {
                    //Mensaje de error
                    Usuario::setAlerta('error', 'Correo no válido, la cuenta pertenece a otro correo');
                    $alertas = Usuario::getAlertas();
                } else {
                    //Guardar el usuario
                    $usuario->guardar();
                    Usuario::setAlerta('exito', 'Usuario actualizado correctamente');
                    $alertas = Usuario::getAlertas();
                    //Guardar el nombre en la sesion
                    $_SESSION['nombre'] = $usuario->nombre;
                }
            }
        }

        $router->render('dashboard/perfil', [
            'titulo' => 'Perfil',
            'alertas' => $alertas,
            'usuario'=> $usuario
        ]);
    }

    public static function cambiar_password(Router $router) {
        session_start();
        isAuth();
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario = Usuario::find($_SESSION['id']);
            //Sincronizar con los datos del usuario
            $usuario->sincronizar($_POST);
            $alertas = $usuario->nuevo_password();

            if(empty($alertas)) {
                $resultado =$usuario->comprobar_password();

                if($resultado) {
                    //Guardar la contraseña nueva
                    $usuario->password = $usuario->password_nuevo;
                    //Eliminar propiedades no deseadas
                    unset($usuario->password_actual);
                    unset($usuario->password_nuevo);
                    //Hashear la contraseña nueva
                    $usuario->hashPassword();

                    //Actualizar el usuario
                    $resultado = $usuario->guardar();
                    if($resultado) {
                        Usuario::setAlertas('exito', 'Contraseña actualizada correctamente');
                        $alertas = Usuario::getAlertas();
                    }
                } else {
                    Usuario::setAlerta('error', 'Contraseña incorrecta');
                    $alertas = Usuario::getAlertas();
                }
            }
        }

        $router->render('dashboard/cambiar-password', [
            'titulo' => 'Cambiar contraseña',
            'alertas' => $alertas
        ]);
    } 
}
?>