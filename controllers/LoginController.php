<?php

namespace Controllers;
use MVC\Router;
use Model\Usuario;
use Classes\Email;

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

                    //Enviar correo
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarConfirmacion();

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
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario($_POST);
            $alertas =$usuario->validarEmail();
            
            if(empty($alertas)) {
                $usuarioExiste = Usuario::where('email', $usuario->email);
                //Validar que el usuario exista y este confirmado
                if($usuarioExiste && $usuario->confirmado === 1) {
                    //Crear token
                    $usuario->crearToken();
                    //Actualizar usuario
                    $usuario->guardar();
                } else {
                    $usuario::setAlerta('error', 'El usuario no existe o no se encuentra confirmado');
                    $alertas = $usuario::getAlertas();
                }
            }

        }

        $router->render('auth/olvide', [
            'titulo' => 'Olvidé contraseña',
            'alertas' => $alertas
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
        $token = s($_GET['token']);

        if(!$token) {
            header('Location: /');
        }
        //Encontrar usuario con ese token
        $usuario = Usuario::where('token', $token);

        if(empty($usuario)) {
            Usuario::setAlerta('error', 'Token no válido');
        } else {
            $usuario->confirmado = 1;
            $usuario->token = null;
            unset($usuario->password2);
            
            //Guardar en la BD
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta confirmada correctamente');
        }
        
        $alertas = Usuario::getAlertas();

        $router->render('auth/confirmar', [
            'titulo' => 'Confirmar cuenta',
            'alertas' => $alertas
        ]);
    }
}
