<?php

namespace Inventario\Controllers;

use Inventario\Exceptions\DbException;
use Inventario\Exceptions\NotFoundException;
use Inventario\Models\EquipoModel;
use Inventario\Domain\Equipo;
class EquipoController extends AbstractController {

     const PAGE_LENGTH = 15;

    public function registro(): string {
        // only logged in users can access    
        if (!isset($_SESSION['usuario_id'])) {
            $properties = ['errorMessage' => 'No  tienes acceso a esta ruta!'];
            return $this->render('login.twig',  $properties);
        }


         // use pattern POST-RESEND-GET
         if (!$this->request->isPost()) {
             $properties = [
            'usuario_nombre' => $_SESSION['usuario_nombre'] ];
            return $this->render('registro_equipo.twig', $properties);
        }

        // POST
        $params = $this->request->getParams();
        if (  !( $params->has('activo_fijo')        && 
                 $params->has('ubicacion')          && 
                 $params->has('laboratorio_id')     && 
                 $params->has('denominacion_af')    &&
                 $params->has('denominacion_cont')  && 
                 $params->has('numero_serie')       &&
                 $params->has('marca')              && 
                 $params->has('modelo')             && 
                 $params->has('material')           && 
                 $params->has ('tipo_activo')       && 
                 $params->has('factura'))  ) {                
            $properties = ['errorMessage' => 'No info provided. Fill all fields.'];
            return $this->render('registro_equipo.twig', $properties);
        }

        $activo_fijo            = $params->getString('activo_fijo');
        $ubicacion              = $params->getString('ubicacion');
        $laboratorio_id         = $params->getString('laboratorio_id');
        $denominacion_af        = $params->getString('denominacion_af');
        $denominacion_cont      = $params->getString('denominacion_cont');
        $numero_serie           = $params->getString('numero_serie');
        $marca                  = $params->getString('marca');
        $modelo                 = $params->getString('modelo');
        $material               = $params->getString('material');
        $tipo_activo            = $params->getString('tipo_activo');
        $factura                = $params->getString('factura');

        $equipoModel = new EquipoModel($this->db);

        try {
            $equipoModel->insert(
                new Equipo( 0                   , 
                            $activo_fijo        , 
                            $ubicacion          , 
                            $laboratorio_id     , 
                            $denominacion_af    , 
                            $denominacion_cont  , 
                            $numero_serie       , 
                            $marca              , 
                            $modelo             , 
                            $material           , 
                            $tipo_activo        ,
                            $factura
                )
            );
        } catch (DbException $e) {
             $properties = ['errorMessage' => $e->getMessage()];
              return $this->render('registro_equipo.twig', $properties);
            }

        // resend  & GET    
        header("Location: /", true,303);
        exit();
    }


    

    public function getAllWithPage($page): string {
         if (!isset($_SESSION['usuario_id'])) {
            $properties = ['errorMessage' => 'No  tienes acceso a esta ruta!'];
            return $this->render('login.twig',  $properties);
        }

        $page = (int)$page;
        $equipoModel = new EquipoModel($this->db);

        $equipos = $equipoModel->getAll($page, self::PAGE_LENGTH);

        $properties = [
            'usuario_nombre' => $_SESSION['usuario_nombre'],
            'equipos' => $equipos,
            'currentPage' => $page,
            'lastPage' => count($equipos) < self::PAGE_LENGTH
        ];
        return $this->render('equipos.twig', $properties);
    }

    public function getAll(): string {

        if (!isset($_SESSION['usuario_id'])) {
            $properties = ['errorMessage' => 'No  tienes acceso a esta ruta!'];
            return $this->render('login.twig',  $properties);
        }
        return $this->getAllWithPage(1);
    }

    public function get(int $id): string {
         if (!isset($_SESSION['usuario_id'])) {
            $properties = ['errorMessage' => 'No  tienes acceso a esta ruta!'];
            return $this->render('login.twig', []);
        }
        $equipoModel = new EquipoModel($this->db);

        try {
            $equipo = $equipoModel->get($id);
        } catch (\Exception $e) {
            //$this->log->error('Error getting equipo: ' . $e->getMessage());
            $properties = ['errorMessage' => 'equipo not found!'];
            return $this->render('error.twig', $properties);
        }

        $properties = [
            'usuario_nombre' => $_SESSION['usuario_nombre'],
            'equipo' => $equipo
        ];
        return $this->render('equipo.twig', $properties);
    }
  /*  
    public function registro(): string {
         // SESSION logged in
         if (!isset($_SESSION['usuario_id'])) {
            $properties = ['errorMessage' => 'No  tienes acceso a esta ruta!'];
            return $this->render('error.twig', $properties);
        }

        // use pattern POST-RESEND-GET
        // GET
        if (!$this->request->isPost()) {
            return $this->render('registro_equipo.twig', []);
        }
        // POST

        // resend  & GET
        header("Location: /", true,303);
        exit();

        $equipoModel = new EquipoModel($this->db);

        try {
            $equipo = $equipoModel->get($id);
        } catch (\Exception $e) {
            //$this->log->error('Error getting equipo: ' . $e->getMessage());
            $properties = ['errorMessage' => 'equipo not found!'];
            return $this->render('error.twig', $properties);
        }

        $properties = [
            'usuario_nombre' => $_SESSION['usuario_nombre'],
            'equipo' => $equipo
        ];
        return $this->render('registro_equipos.twig', $properties);
    }
*/
}

/*
    public function search(): string {
        $title = $this->request->getParams()->getString('title');
        $author = $this->request->getParams()->getString('author');

        $bookModel = new BookModel($this->db);
        $books = $bookModel->search($title, $author);

        $properties = [
            'books' => $books,
            'currentPage' => 1,
            'lastPage' => true
        ];
        return $this->render('books.twig', $properties);
    }

    public function getByUser(): string {
        $bookModel = new BookModel($this->db);

        $books = $bookModel->getByUser($this->customerId);

        $properties = [
            'books' => $books,
            'currentPage' => 1,
            'lastPage' => true
        ];
        return $this->render('books.twig', $properties);
    }

    public function borrow(int $bookId): string {
        $bookModel = new BookModel($this->db);

        try {
            $book = $bookModel->get($bookId);
        } catch (NotFoundException $e) {
            $this->log->warn('Book not found: ' . $bookId);
            $params = ['errorMessage' => 'Book not found.'];
            return $this->render('error.twig', $params);
        }

        if (!$book->getCopy()) {
            $params = ['errorMessage' => 'There are no copies left.'];
            return $this->render('error.twig', $params);
        }

        try {
            $bookModel->borrow($book, $this->customerId);
        } catch (DbException $e) {
            $this->log->warn('Error borrowing book: ' . $e->getMessage());
            $params = ['errorMessage' => 'Error borrowing book.'];
            return $this->render('error.twig', $params);
        }

        return $this->getByUser();
    }

    public function returnBook(int $bookId): string {
        $bookModel = new BookModel($this->db);

        try {
            $book = $bookModel->get($bookId);
        } catch (NotFoundException $e) {
            $this->log->warn('Book not found: ' . $bookId);
            $params = ['errorMessage' => 'Book not found.'];
            return $this->render('error.twig', $params);
        }

        $book->addCopy();

        try {
            $bookModel->returnBook($book, $this->customerId);
        } catch (DbException $e) {
            $this->log->warn('Error borrowing book: ' . $e->getMessage());
            $params = ['errorMessage' => 'Error borrowing book.'];
            return $this->render('error.twig', $params);
        }

        return $this->getByUser();
    }
    */
    
