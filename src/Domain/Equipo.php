<?php

namespace Inventario\Domain;

class Equipo {
private $id;                             // id: es un numero que se usa en la base de datos, i.e. 1
private $activo_fijo;                   // activo_fijo:es un string con el activo_fijo(posiblemente 30100725)
private $ubicacion;                    // ubicacion: es un string con la ubicacion (posiblemente mesa 2)
private $laboratorio;                 // laboratorio: es un string de laboratorio (posiblemente ELE)
private $denominacion_af;            // denominacion_af:es un string de denominacion_af (posiblemente MICROCONTROLADOR)
private $denominacion_cont;         // denominacion_cont: es un string de denominacion_cont(posiblemente LABORATORIO MOD.PROG.FPGA Y DISP.ELECT.)
private $numero_serie;             // numero_serie: es un string de numero_de_serie(posiblemente U01473049)
private $marca;                   // marca: es un string de marca(posiblemente STEREN)
private $modelo;                 // modelo: es un string de modelo(posiblemente UNO R3)
private $material;              // material: es un string de material(posiblemente LAMINA CALIBRE 24)
private $tipo_activo;          // tipo_activo: es un string de tipo_activo(posiblemente OSCILOSCOPIO)
private $factura;             // factura: es un string de factura(posiblemente 598 o L 015518)


 // Constructor
public function __construct($id, $activo_fijo, $ubicacion,$laboratorio,$denominacion_af,$denominacion_cont,$numero_serie,$marca,$modelo,$material,$tipo_activo,$factura){
        $this->id                        = $id;                 
        $this->activo_fijo               = $activo_fijo;
        $this->ubicacion                 = $ubicacion;
        $this->laboratorio               = $laboratorio;
        $this->denominacion_af           = $denominacion_af;
        $this->denominacion_cont         = $denominacion_cont;
        $this->numero_serie              = $numero_serie;
        $this->marca                     = $marca;
        $this->modelo                    = $modelo;
        $this->material                  = $material;
        $this->tipo_activo               = $tipo_activo;
        $this->factura                   = $factura;
    }
 


    public function getId(): int {
        return $this->id;
    }

    public function getActivo_fijo(): string {
        return $this->activo_fijo;
    }

    public function getUbicacion(): string {
        return $this->ubicacion;
    }

    public function getLaboratorio_id(): string {
        return $this->laboratorio;
    }

    public function getDenominacion_af(): string {
        return $this->denominacion_af;
    }

    public function getDenominacion_cont(): string {
        return $this->denominacion_cont;
    }

    public function getNumero_serie(): string {
        return $this->numero_serie;
    }

    public function getMarca(): string {
        return $this->marca;
    }

    public function getModelo(): string {
        return $this->modelo;
    }

    public function getMaterial(): string {
        return $this->material;
    }
    public function getTipo_activo(): string {
        return $this->tipo_activo;
    }

    public function getFactura(): string {
        return $this->factura;
    }
}