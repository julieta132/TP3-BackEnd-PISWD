CREATE DATABASE IF NOT EXISTS tecnica6moron;/*crear base de datos*/

USE tecnica6moron;/*seleccionar base de datos*/

CREATE TABLE IF NOT EXISTS Alumno ( /*crear tabla Alumnos*/
    Id smallint primary key,
    Apellido varchar (20) not null,
    Nombre varchar (15) not null,
    Anio int,
    Division int,
    Tipo_Documento varchar (3),
    Nro_Documento varchar (10)
    
);
