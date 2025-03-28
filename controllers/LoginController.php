<?php

namespace Controllers;
use MVC\Router;

class LoginController {
    public static function login(Router $router) {
        if($_SERVER['REQUEST_METHOD']) {

        }

        $router->render('auth/login', [
            'titulo' => 'Iniciar sesión'
        ]);
    }

    public static function logout() {
        echo "Desde Logout";
    }

    public static function crear(Router $router) {

        if($_SERVER['REQUEST_METHOD']) {

        }

        $router->render('auth/crear', [
            'titulo' => 'Crear cuenta'
        ]);
    }

    public static function olvide(Router $router) {
        if($_SERVER['REQUEST_METHOD']) {

        }

        $router->render('auth/olvide', [
            'titulo' => 'Olvidé contraseña'
        ]);
    }

    public static function reestablecer() {
        echo "Desde reestablecer";

        if($_SERVER['REQUEST_METHOD']) {

        }
    }

    public static function mensaje() {
        echo "Desde  mensaje";
    }

    public static function confirmar() {
        echo "Desde  confirmar";
    }

}
