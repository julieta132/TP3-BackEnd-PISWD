USE tecnica6moron;

SELECT * FROM Alumno; /*todas las filas*/

SELECT Apellido, Nombre FROM Alumno WHERE NroMatricula>3000;

/*actualizar datos*/

/*UPDATE Alumno SET Apellido='Perez', Nombre='Luis' WHERE NroMatricula=1000;*/

CALL SeleccionarTodosLosAlumnos (); /*invocando al procedimiento almacenado en lugar de la consulta sql pra mas seguridad*/

CALL EliminarAlumno(5000);