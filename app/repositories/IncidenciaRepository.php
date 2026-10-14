<?php
declare(strict_types=1);

final class IncidenciaRepository
{
    public function __construct(private mysqli $db)
    {
    }

    /** Inserta la incidencia y su primer registro de historial en una sola transacción. */
    public function guardar(int $empleadoId, string $tipo, string $inicio, string $fin, string $motivo): int
    {
        $this->db->begin_transaction();
        try {
            $stmt = $this->db->prepare(
                'INSERT INTO incidencias (empleado_id, tipo, fecha_inicio, fecha_fin, motivo) VALUES (?, ?, ?, ?, ?)'
            );
            $stmt->bind_param('issss', $empleadoId, $tipo, $inicio, $fin, $motivo);
            $stmt->execute();
            $id = (int) $stmt->insert_id;

            $historial = $this->db->prepare(
                "INSERT INTO incidencias_historial (incidencia_id, estado) VALUES (?, 'pendiente')"
            );
            $historial->bind_param('i', $id);
            $historial->execute();

            $this->db->commit();
            return $id;
        } catch (Throwable $e) {
            $this->db->rollback();
            throw $e;
        }
    }
}
