<?php

namespace Inventario\Models;

use Inventario\Domain\Usuario;
//use Inventario\Domain\Usuario\UsuarioFactory;|
use Inventario\Exceptions\NotFoundException;
use Inventario\Exceptions\DbException;
use Exception;
use PDOException;

class UsuarioModel extends AbstractModel {
    public function addUsuario(Usuario $usuario) {
       
        $query = 'INSERT INTO usuario (nombre, clave, tipo) values (:nombre, :clave, :tipo)';
        $sth = $this->db->prepare($query);
         try {
            $sth->execute([
                       'nombre' => $usuario->getNombre(),
                       'clave'  => $usuario->getClave(),
                       'tipo'   => $usuario->getTipo()
                     ]);
        } catch (PDOException $e) {
            // integrity
           throw new DbException( $usuario->getNombre() . ' ya esta USADO, ingrese otro nombre');
        }
    }
    public function getById(int $userId): Usuario {
        $query = 'SELECT * FROM usuario WHERE id = :userId';
        $sth = $this->db->prepare($query);
        $sth->execute(['userId' => $userId]);
        $row = $sth->fetch();

        if (empty($row)) {
            throw new NotFoundException();
        }
        return new Usuario( 
            $row['id'], 
            $row['nombre'], 
            $row['clave'], 
            $row['tipo']
        );
    }

    public function getByNombre(string $nombre): Usuario {
        $query = 'SELECT * FROM usuario WHERE nombre = :nombre';
        $sth = $this->db->prepare($query);
        $sth->execute(['nombre' => $nombre]);

        $row = $sth->fetch();

        if (empty($row)) {
            throw new NotFoundException();
        }

        return new Usuario( 
            $row['id'], 
            $row['nombre'], 
            $row['clave'], 
            $row['tipo']
        );
    }
}