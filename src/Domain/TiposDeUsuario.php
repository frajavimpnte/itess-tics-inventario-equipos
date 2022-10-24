<?php

namespace Inventario\Domain;

class TiposDeUsuario {
	const ADMINISTRADOR = 0;  // administrador del sistema, acceso total
	const COORDINADOR 	= 1;  // coordinador administra los equipos,llevan registro
	const ENCARGADO		= 2;  // administrar el sistema, mantener datos de equipos,revisar
	const LABORATORISTA = 3;  // administra el sistema,revisa datos de equipos
}