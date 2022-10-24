<?php

namespace Inventario\Exceptions;

use Exception;

class DbIntegrityException extends Exception {
	public function __construct($message = null) {
        $message = $message ?: 'Invalid id provided.';
        parent::__construct($message);
    }
}