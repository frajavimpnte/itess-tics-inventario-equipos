<?php

namespace Inventario\Domain;

class Usuario {
    private $id;            // id: es un numero que se usa en la base de datos, i.e. 1
    private $nombre;        // nombre: es un string nombre de usuario, debe ser unico,  i.e. juan23
    private $clave;         // contraseña: es un string con la contraseña, (posiblemente md5) i.e. asdfq341
    private $tipo;          // tipo: es el tipo de usuario definido en TiposDeUsuario
    
    public function __construct($id, $nombre, $clave, $tipo){
        $this->id           = $id;
        $this->nombre       = $nombre;
        $this->clave        = $clave;
        $this->tipo         = $tipo;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function getClave(): string {
        return $this->clave;
    }
    public function getTipo(): string {
        return $this->tipo;
    }
}
