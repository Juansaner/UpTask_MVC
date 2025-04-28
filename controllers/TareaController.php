<?php

namespace Controllers;
use Model\Proyecto;
use Model\Tarea;

class TareaController {
    public static function index() {
        $proyectoId = $_GET['id'];
        $proyecto = Proyecto::where('url', $proyectoId);
        session_start();
        if(!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) {
            header('Location: /404');
        }
        $tarea = Tarea::belongsTo('proyectoId', $proyecto->id);
        echo json_encode(['tareas' => $tarea]);
    }

    public static function crear() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            $proyectoId = $_POST['proyectoId'];
            $proyecto = Proyecto::where('url', $proyectoId);

            if(!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) { 
                $respuesta = [ 
                    'tipo' => 'error',
                    'mensaje' => 'Hubo un error al crear la tarea'
                 ];
                 echo json_encode($respuesta);
                 return;
            } 
            //Instanciar y guardar la tarea
            $tarea = new Tarea($_POST);
            $tarea->proyectoId = $proyecto->id;
            $resultado = $tarea->guardar();
            $respuesta = [
                'tipo' => 'exito',
                'id' => $resultado['id'],
                'mensaje' => 'Tarea creada correctamente',
                'proyectoId' => $proyecto->id
            ];
            echo json_encode($respuesta);
        }
    }

    public static function actualizar() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            //Verificar que el proyecto exista
            $proyecto = Proyecto::where('url', $_POST['proyectoId']);
            if(!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) { 
                $respuesta = [ 
                    'tipo' => 'error',
                    'mensaje' => 'Hubo un error al actualizar la tarea'
                 ];
                 echo json_encode($respuesta);
                 return;
            }
            //Instancia la tarea
            $tarea = new Tarea($_POST);
            //Modifica el id del proyecto
            $tarea->proyectoId = $proyecto->id;
            $resultado = $tarea->guardar();
            if($resultado) {
                $respuesta = [
                    'tipo' => 'exito',
                    'id' => $tarea->id,
                    'proyectoId' => $proyecto->id,
                    'mensaje' => 'Estado actualizado correctamente'
                ];
                echo json_encode(['respuesta' => $respuesta]);
            }
        }
    }

    public static function eliminar() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
        }
    }
}