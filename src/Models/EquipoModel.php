<?php

namespace Inventario\Models;

use Inventario\Domain\Equipo;
use Inventario\Exceptions\DbException;
use Inventario\Exceptions\NotFoundException;
use PDO;

class EquipoModel extends AbstractModel {
    const CLASSNAME = '\Inventario\Domain\Equipo';

    public function insert(Equipo $equipo) {
       
        $query = 'INSERT INTO equipo (activo_fijo, ubicacion, laboratorio_id, denominacion_af, denominacion_cont, numero_serie, marca, modelo, material, tipo_activo, factura) values (:activo_fijo, :ubicacion, :laboratorio_id, :denominacion_af, :denominacion_cont, :numero_serie, :marca, :modelo, :material, :tipo_activo, :factura)';
        $sth = $this->db->prepare($query);
         try {
            $sth->execute([
                       'activo_fijo'         => $equipo->getActivo_fijo(),
                       'ubicacion'           => $equipo->getUbicacion(),
                       'laboratorio_id'      => $equipo->getLaboratorio_id(),
                       'denominacion_af'     => $equipo->getDenominacion_af(),
                       'denominacion_cont'   => $equipo->getDenominacion_cont(),
                       'numero_serie'        => $equipo->getNumero_serie(),
                       'marca'               => $equipo->getMarca(),
                       'modelo'              => $equipo->getModelo(),
                       'material'            => $equipo->getMaterial(),
                       'tipo_activo'         => $equipo->getTipo_activo(),
                       'factura'             => $equipo->getFactura()
                     ]);
        } catch (PDOException $e) {
            // integrity
           throw new DbException( $equipo->getActivo_fijo() . ' ya esta USADO, ingrese otro nombre');
        }
    }

    public function get(int $id): Equipo {
        $query = 'SELECT * FROM equipo WHERE id = :id';
        $sth = $this->db->prepare($query);

        $sth->execute(['id' => $id]);

        $args=[0,"","","","","","","","","","",""];
        //$equipos = $sth->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
        $equipos = $sth->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, self::CLASSNAME, $args);
        if (empty($equipos)) {
            throw new NotFoundException();
        }

        return $equipos[0];
    }

    public function getAll(int $page, int $pageLength): array {
        $start = $pageLength * ($page - 1);

        $query = 'SELECT * FROM equipo LIMIT :page, :length';
        $sth = $this->db->prepare($query);
        $sth->bindParam('page', $start, PDO::PARAM_INT);
        $sth->bindParam('length', $pageLength, PDO::PARAM_INT);
        $sth->execute();

        
        //$result = $sth->fetch(PDO::FETCH_LAZY);
        //print_r($result);
        $args=[0,"","","","","","","","","","",""];
        //return $sth->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME, $args);
        //return $sth->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
        return $sth->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, self::CLASSNAME, $args);
    }

/*
    public function getByUser(int $userId): array {
        $query = <<<SQL
SELECT b.*
FROM borrowed_books bb LEFT JOIN book b ON bb.book_id = b.id
WHERE bb.customer_id = :id
SQL;
        $sth = $this->db->prepare($query);
        $sth->execute(['id' => $userId]);

        return $sth->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
    }

    public function borrow(Book $book, int $userId) {
        $query = <<<SQL
INSERT INTO borrowed_books (book_id, customer_id, start)
VALUES(:book, :user, NOW())
SQL;
        $sth = $this->db->prepare($query);
        $sth->bindValue('book', $book->getId());
        $sth->bindValue('user', $userId);
        if (!$sth->execute()) {
            throw new DbException($sth->errorInfo()[2]);
        }

        $this->updateBookStock($book);
    }

    public function returnBook(Book $book, int $userId) {
        $query = <<<SQL
UPDATE borrowed_books SET end = NOW()
WHERE book_id = :book AND customer_id = :user AND end IS NULL
SQL;
        $sth = $this->db->prepare($query);
        $sth->bindValue('book', $book->getId());
        $sth->bindValue('user', $userId);
        if (!$sth->execute()) {
            throw new DbException($sth->errorInfo()[2]);
        }

        $this->updateBookStock($book);
    }

    private function updateBookStock(Book $book) {
        $query = 'UPDATE book SET stock = :stock WHERE id = :id';
        $sth = $this->db->prepare($query);
        $sth->bindValue('id', $book->getId());
        $sth->bindValue('stock', $book->getStock());
        if (!$sth->execute()) {
            throw new DbException($sth->errorInfo()[2]);
        }
    }

    public function search(string $title, string $author): array {
        $query = <<<SQL
SELECT * FROM book
WHERE title LIKE :title AND author LIKE :author
SQL;
        $sth = $this->db->prepare($query);
        $sth->bindValue('title', "%$title%");
        $sth->bindValue('author', "%$author%");
        $sth->execute();

        return $sth->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);
    }
    */
}