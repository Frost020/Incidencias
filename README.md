# Incidencias

Módulo de **Gestión de Incidencias** del ERP desarrollado en la materia de Desarrollo Web
(Ingeniería en Gestión y Desarrollo de Software, UTTN).

El módulo registra, autoriza y conserva los eventos que afectan la jornada laboral de un
empleado (faltas, retardos, permisos, incapacidades) y expone únicamente las incidencias
aprobadas para que el módulo de Prenómina calcule los resultados de cada periodo.

## Tecnologías

- HTML y CSS para la interfaz
- JavaScript vanilla para validaciones y envío asíncrono
- PHP para el procesamiento en el servidor
- MySQL con MySQLi (consultas preparadas) para el almacenamiento

## Estructura

```
Incidencias/
├── public/              Lo que sirve el navegador (cliente)
│   ├── index.html       Pantalla de registro de incidencias
│   ├── css/             Estilos del módulo
│   ├── js/              Validaciones de experiencia y envío asíncrono
│   └── incidents/       Puntos de entrada HTTP (POST incidents/create)
├── app/                 Lógica del servidor (PHP)
│   ├── controllers/     Recibe la petición y devuelve la respuesta JSON
│   ├── usecases/        Reglas de negocio y validación dura
│   └── repositories/    Acceso a datos con MySQLi y consultas preparadas
├── config/              Configuración (config.php no se versiona)
└── database/            Script de creación de la base de datos
```

## Instalación local (XAMPP)

1. Copiar la carpeta del proyecto dentro de `htdocs`.
2. Ejecutar `database/schema.sql` en phpMyAdmin o en la consola de MySQL.
3. Copiar `config/config.example.php` como `config/config.php` y ajustar las credenciales.
4. Abrir `http://localhost/Incidencias/public/` en el navegador.

## Flujo de trabajo

- `main` contiene siempre la versión estable.
- Cada función del backlog se desarrolla en una rama `feature/<nombre>`.
- Los cambios llegan a `main` solo mediante un pull request revisado por otro integrante.

## Equipo

- Daniel Reyna Badillo
- Ernesto Esau Ochoa Castellanos
- Victor Ruiz Garcia
- David Eliud Bartolo Mendez
- Samuel Oviedo Espinoza
- Andrés Armando Azuara Tovar
