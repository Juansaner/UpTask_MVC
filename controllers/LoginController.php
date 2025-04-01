<?php

namespace Controllers;
use MVC\Router;
use Model\Usuario;

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

        $usuario = new Usuario;

        if($_SERVER['REQUEST_METHOD']) {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();
            debuguear($alertas);
        }

        $router->render('auth/crear', [
            'titulo' => 'Crear cuenta',
            'usuario' => $usuario
        ]);
    }

    public static function olvide(Router $router) {
        if($_SERVER['REQUEST_METHOD']) {

        }

        $router->render('auth/olvide', [
            'titulo' => 'Olvidé contraseña'
        ]);
    }

    public static function reestablecer(Router $router) {
        if($_SERVER['REQUEST_METHOD']) {

        }

        $router->render('auth/reestablecer', [
            'titulo' => 'Reestablecer contraseña'
        ]);
    }   

    public static function mensaje(Router $router) {
        $router->render('auth/mensaje', [
            'titulo' => 'Cuenta creada'
        ]);
    }

    public static function confirmar(Router $router) {
        $router->render('auth/confirmar', [
            'titulo' => 'Confirmar cuenta'
        ]);
    }
}
