<?php
class Database
{
    private $servidor = "localhost";
    private $usuario = "root";
    private $clave = "";
    private $basededatos = "mytiendaPeliculas";
    private $conexion;

    // Constructor: conecta automáticamente a la base de datos
    public function __construct()
    {
        $this->connect();
    }

    // Método para conectar a la base de datos
    public function connect()
    {
        $this->conexion = new mysqli($this->servidor, $this->usuario, $this->clave, $this->basededatos);

        // Comprobar errores en la conexión
        if ($this->conexion->connect_error) {
            die("Error al intentar conectar a la base de datos: " . $this->conexion->connect_error);
        }

        return $this->conexion;
    }

    // Método para realizar una consulta y devolver los datos como JSON
    public function queryToJson($sql)
    {
        $resultado = $this->conexion->query($sql);

        if ($resultado && $resultado->num_rows > 0) {
            // Convertir los datos a un arreglo asociativo
            $datos = $resultado->fetch_all(MYSQLI_ASSOC);
            // Devolver los datos en formato JSON
            return json_encode($datos);
        } else {
            // Devolver un JSON vacío si no hay resultados
            return json_encode([]);
        }
    }

    public function getAllMovies()
    {
        $stmt = $this->conexion->prepare("SELECT 
            p.id_pelicula,
            p.titulo,
            p.descripcion,
            p.imagen,
            pl.id_plataforma,
            pl.nombre AS nombre_plataforma,
            g.id_genero,
            g.nombre AS nombre_genero
        FROM 
            pelicula p
        INNER JOIN 
            plataforma pl
        ON 
            p.id_plataforma = pl.id_plataforma
        INNER JOIN 
        genero g
        ON 
        p.id_genero = g.id_genero");

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado
        $result = $stmt->get_result();

        // Verificar si hay resultados
        if ($result->num_rows > 0) {
            // Retornar los resultados como un array
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }

    }

    // Agregar película a 'continuar viendo'
    public function addPelicula($id_pelicula, $id_usuario)
    {
        // preparamos la consulta
        $stmt = $this->conexion->prepare("INSERT INTO continuarViendo (id_pelicula, id_usuario) VALUES (?, ?)");
        if (!$stmt) {
            die("Error en la preparación: " . $this->conexion->error);
        }
        // vinculamos los parametros con la consulta preparada
        $stmt->bind_param("ii", $id_pelicula, $id_usuario);
        // ejecutamos la consulta
        return $stmt->execute();
    }

    // DELETE
    // Eliminar película de 'continuar viendo'
    public function removePelicula($id_pelicula, $id_usuario)
    {
        $stmt = $this->conexion->prepare("DELETE FROM continuarViendo WHERE id_pelicula = ? AND id_usuario = ?");
        $stmt->bind_param("ii", $id_pelicula, $id_usuario);
        return $stmt->execute();
    }

    // esta funcion busca si hay una pelicula antes de agregarla 
    public function existePelicula($id_pelicula, $id_usuario)
    {
        $stmt = $this->conexion->prepare("SELECT COUNT(*) FROM continuarViendo WHERE id_pelicula = ? AND id_usuario = ?");
        if (!$stmt) {
            die("Error en la preparación: " . $this->conexion->error);
        }
        $stmt->bind_param("ii", $id_pelicula, $id_usuario);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        return $count > 0; // Retorna true si existe, false si no
    }

    // Método para obtener los datos de un usuario por su id_usuario
    public function getUsuarioById($id_usuario)
    {
        $sql = "SELECT * FROM usuario WHERE id_usuario = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('i', $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc(); // Devuelve un array asociativo con los datos del usuario
    }

    // funcion especifica para cambiar nombre en cuenta 
    public function actualizarNombreUsuario($id_usuario, $nuevoNombre)
    {
        $sql = "UPDATE usuario SET nombre = ? WHERE id_usuario = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('si', $nuevoNombre, $id_usuario);

        if ($stmt->execute()) {
            $stmt->close();
            return ['success' => true, 'message' => 'Nombre actualizado correctamente.'];
        } else {
            $stmt->close();
            return ['success' => false, 'message' => 'Error al actualizar el nombre.'];
        }
    }
    // funcion especifica para cambiar usuario en cuenta 
    public function cambiarContrasenia($id_usuario, $contraseniaForm, $contraseniaNuevaForm)
    {
        // obtengo los datos del usuario 
        $usuario = $this->getUsuarioById($id_usuario);
        // verifico si existe el usuario
        if (!$usuario) {
            return ['success' => false, 'message' => 'Usuario no encontrado.'];
        }

        // guardo la contrasenia que viene de la BD (la original)
        $contraseniaGuardada = $usuario['contrasenia'];

        // contraseniaForm es la contrasenia ingresada por el usuario en el formulario
        if ($contraseniaGuardada != $contraseniaForm) {
            return ['success' => false, 'message' => 'La contraseña ingresada es incorrecta.'];
        }

        // si la contrasenia actual obtenida en la BD es igual a la contrasenia que se quiere renovar en el formulario. error
        if ($contraseniaGuardada == $contraseniaNuevaForm) {
            return ['success' => false, 'message' => 'La nueva contraseña no puede ser igual a la actual.'];
        }

        // Actualizar la contraseña en la base de datos
        $sqlUpdate = "UPDATE usuario SET contrasenia = ? WHERE id_usuario = ?";
        $stmtUpdate = $this->conexion->prepare($sqlUpdate);
        $stmtUpdate->bind_param('si', $contraseniaNuevaForm, $id_usuario);

        if ($stmtUpdate->execute()) {
            $stmtUpdate->close();
            return ['success' => true, 'message' => 'Contraseña actualizada correctamente.'];
        } else {
            $stmtUpdate->close();
            return ['success' => false, 'message' => 'Error al actualizar la contraseña.'];
        }
    }

    // metodo para obtener todos los usuarios
    public function getAllUsuarios()
    {
        $sql = "SELECT * FROM usuario";  // Consulta para obtener todos los usuarios
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        $usuarios = [];
        while ($row = $result->fetch_assoc()) {
            $usuarios[] = $row;  // Agrega cada usuario al array
        }

        return $usuarios;  // Devuelve un array con todos los usuarios
    }

    // elimina el usuario por ID
    public function deteleUserById($id_usuario)
    {
        $sql = "DELETE FROM usuario WHERE id_usuario = ?";
        $stmt = $this->conexion->prepare($sql);
        // Verifica si la preparación de la consulta fue exitosa
        if ($stmt === false) {
            return false;
        }
        $stmt->bind_param("i", $id_usuario);
        $execute_result = $stmt->execute();

        // Si la ejecución fue exitosa, devuelve true
        return $execute_result;
    }


    public function updateUserById($userId, $userName, $userEmail, $userPassword)
    {
        // Preparamos la consulta SQL
        $sql = "UPDATE usuario
                SET nombre = ?, email = ?, contrasenia = ? 
                WHERE id_usuario = ?";

        // Preparamos la sentencia
        $stmt = $this->conexion->prepare($sql);

        if (!$stmt) {
            die("Error en la preparación: " . $this->conexion->error);
        } else {
            var_dump("Un exito la preparacion");
            echo "¡Éxito en la preparación de la consulta!";
        }

        // Vinculamos los parámetros (string, string, string, entero)
        $stmt->bind_param("sssi", $userName, $userEmail, $userPassword, $userId);

        // Ejecutamos la consulta
        $resultado = $stmt->execute();

        // Verificamos el resultado
        if (!$resultado) {
            die("Error en la ejecución: " . $stmt->error);
        }

        // Cerramos la sentencia

        $stmt->close();
        return $resultado;
    }

    // funcion para actualizar la información de las peliculas
    public function updateMovieById($id, $titulo, $descripcion, $imagen, $id_plataforma, $id_genero)
    {
        $sql = "UPDATE pelicula 
                SET titulo = ?, descripcion = ?, imagen = ?, id_plataforma = ?, id_genero = ? 
                WHERE id_pelicula = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('sssiii', $titulo, $descripcion, $imagen, $id_plataforma, $id_genero, $id);

        $resultado = $stmt->execute();
        $stmt->close();
        return $resultado;
    }

    // funcion para utilizar en categoriasPelicula y que traiga todas las peliculas por id_genero
    public function getMoviesByIdCategory($id_genero)
    {
        $sql = "SELECT * FROM pelicula WHERE id_genero = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('i', $id_genero);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_all(MYSQLI_ASSOC); // Devuelve un array asociativo con todas las películas
    }

// funcion utilizada en appPlataforma
    public function getMovieByPlataforma($id_plataforma)
    {
        $sql = "SELECT 
            p.id_pelicula,
            p.titulo,
            p.imagen,
            pl.id_plataforma,
            pl.icono AS icono_plataforma,
            pl.nombre AS nombre_plataforma
        FROM 
            pelicula p
        INNER JOIN 
            plataforma pl
        ON 
            p.id_plataforma = pl.id_plataforma
        WHERE pl.id_plataforma = ?";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param('i', $id_plataforma);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_all(MYSQLI_ASSOC); // Devuelve un array asociativo con todas las películas
    }

    public function prepare($query) {
        return $this->conexion->prepare($query);
    }
    // Método para cerrar la conexión
    public function close()
    {
        if ($this->conexion) {
            $this->conexion->close();
        }
    }
}
?>