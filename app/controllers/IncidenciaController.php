<?php
declare(strict_types=1);

require_once __DIR__ . '/../../config/conexion.php';
require_once __DIR__ . '/../repositories/IncidenciaRepository.php';
require_once __DIR__ . '/../usecases/RegistrarIncidencia.php';

final class IncidenciaController
{
    public function crear(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->responder(405, ['ok' => false, 'mensaje' => 'Método no permitido.']);
            return;
        }

        $datos = json_decode((string) file_get_contents('php://input'), true);
        if (!is_array($datos)) {
            $this->responder(400, ['ok' => false, 'mensaje' => 'La solicitud no tiene un formato válido.']);
            return;
        }

        try {
            $casoDeUso = new RegistrarIncidencia(new IncidenciaRepository(conexion()));
            $id = $casoDeUso->ejecutar($datos);
            $this->responder(201, [
                'ok' => true,
                'id' => $id,
                'mensaje' => "Incidencia #{$id} registrada con estado pendiente.",
            ]);
        } catch (InvalidArgumentException $e) {
            $this->responder(422, ['ok' => false, 'mensaje' => $e->getMessage()]);
        } catch (Throwable $e) {
            error_log($e->getMessage());
            $this->responder(500, ['ok' => false, 'mensaje' => 'No se pudo registrar la incidencia.']);
        }
    }

    private function responder(int $codigo, array $cuerpo): void
    {
        http_response_code($codigo);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($cuerpo, JSON_UNESCAPED_UNICODE);
    }
}
