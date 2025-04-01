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
        $alertas = [];
        $usuario = new Usuario;

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            if(empty($alertas)) {
                $existeUsuario = Usuario::where('email', $usuario->email);
                if($existeUsuario) {
                    $usuario::setAlerta('error', 'El usuario ya existe');
                    $alertas = $usuario::getAlertas();
                } else {
                    $usuario->hashPassword();
                    //Elimina password2
                    unset($usuario->password2);
                    $usuario->crearToken();

                    //Crea usuario
                    $resultado = $usuario->guardar();

                    if($resultado) {
                        header('Location: /mensaje');
                    }
                }
            }
        }

        $router->render('auth/crear', [
            'titulo' => 'Crear cuenta',
            'usuario' => $usuario,
            'alertas' => $alertas
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
