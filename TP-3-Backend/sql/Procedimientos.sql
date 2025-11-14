USE tecnica6moron;

DELIMITER //

CREATE PROCEDURE IF NOT EXISTS SeleccionarTodosLosAlumnos()
    BEGIN 
       SELECT * FROM Alumno;
    END //

CREATE PROCEDURE IF NOT EXISTS InsertarAlumno(
    IN ape VARCHAR(20),
    IN nom VARCHAR(15),
    IN an INT,
    IN divi INT,
    IN tipo VARCHAR(3),
    IN nro VARCHAR(10)
)
BEGIN
    IF NOT EXISTS (SELECT * FROM Alumno AS Al WHERE Al.Nro_Documento = nro) 
    THEN
        INSERT INTO Alumno (Apellido, Nombre, Anio, Division, Tipo_Documento, Nro_Documento)
        VALUES (ape, nom, an, divi, tipo, nro);
    ELSE
        SELECT 'Nro de documento existente from procedure' AS mensaje;
    END IF;
END //



CREATE PROCEDURE IF NOT EXISTS EliminarAlumno(IN idAlumno INT)
BEGIN
    DELETE FROM Alumno WHERE id = idAlumno;
END //


CREATE PROCEDURE IF NOT EXISTS ActualizarAlumno(
    IN p_id INT,
    IN ape VARCHAR(20),
    IN nom VARCHAR(15),
    IN an INT,
    IN divi INT,
    IN tipo VARCHAR(3),
    IN nro VARCHAR(10)
)
BEGIN 
    IF EXISTS (SELECT 1 FROM Alumno WHERE id = p_id) THEN

        UPDATE Alumno
        SET Apellido = ape,
            Nombre = nom,
            Anio = an,
            Division = divi,
            Tipo_Documento = tipo,
            Nro_Documento = nro
        WHERE id = p_id;

    ELSE
        SELECT 'Alumno inexistente (id invalido)' AS mensaje;
    END IF;

END //

DELIMITER ;

DELIMITER;

