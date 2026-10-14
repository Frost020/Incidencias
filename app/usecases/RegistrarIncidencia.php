<?php
declare(strict_types=1);

final class RegistrarIncidencia
{
    private const TIPOS = ['falta', 'retardo', 'permiso', 'incapacidad', 'vacaciones'];

    public function __construct(private IncidenciaRepository $repositorio)
    {
    }

    /** Valida la incidencia en el servidor y la guarda con estado inicial "pendiente". */
    public function ejecutar(array $datos): int
    {
        $empleadoId = filter_var($datos['empleado_id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        if ($empleadoId === false) {
            throw new InvalidArgumentException('El ID del empleado debe ser un número entero positivo.');
        }

        $tipo = (string) ($datos['tipo'] ?? '');
        if (!in_array($tipo, self::TIPOS, true)) {
            throw new InvalidArgumentException('El tipo de incidencia no es válido.');
        }

        $inicio = $this->fecha($datos['fecha_inicio'] ?? '', 'inicio');
        $fin = $this->fecha($datos['fecha_fin'] ?? '', 'fin');
        if ($fin < $inicio) {
            throw new InvalidArgumentException('La fecha de fin no puede ser anterior a la fecha de inicio.');
        }

        $motivo = trim((string) ($datos['motivo'] ?? ''));
        if ($motivo === '' || mb_strlen($motivo) > 255) {
            throw new InvalidArgumentException('El motivo es obligatorio y admite hasta 255 caracteres.');
        }

        return $this->repositorio->guardar($empleadoId, $tipo, $inicio, $fin, $motivo);
    }

    private function fecha(mixed $valor, string $campo): string
    {
        $fecha = DateTime::createFromFormat('!Y-m-d', (string) $valor);
        if ($fecha === false || $fecha->format('Y-m-d') !== $valor) {
            throw new InvalidArgumentException("La fecha de {$campo} no es válida.");
        }
        return $valor;
    }
}
