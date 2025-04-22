<?php 

namespace Model;

class Tarea extends ActiveRecord {
    protected static $tabla = 'tareas';
    protected static $columnasDB = ['id', 'titulo', 'estado', 'proyectoId'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->estado = $args['estado'] ?? 0;
        $this->proyectoId = $args['proyectoId'] ?? '';
    }
}

?>