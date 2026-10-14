<?php
declare(strict_types=1);

// Punto de entrada: POST incidents/create
require __DIR__ . '/../../app/controllers/IncidenciaController.php';

(new IncidenciaController())->crear();
