<?php 

namespace Controllers;
use MVC\Router;
use Model\Proyecto;

class DashboardController {
    public static function index(Router $router) {
        session_start();
        isAuth();
        $router->render('dashboard/index', [
            'titulo' => 'Proyectos'
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

    public static function perfil(Router $router){
        session_start();
        $router->render('dashboard/perfil', [
            'titulo' => 'Perfil'
        ]);
    }
}
?>