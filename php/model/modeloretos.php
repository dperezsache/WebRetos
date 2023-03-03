<?php
    require_once('modelodb.php');

    /**
     * Clase ModeloRetos.
     * Clase que ejecuta los procesos del CRUD de retos.
     */
    class ModeloRetos
    {
        private $conexion;
        public $listaRetos;

        /** 
         * Obtiene la conexión a la BBDD.
         */
        public function obtenerConexion()
        {
            $objConectar = new modelodb();
            $this->conexion = $objConectar->conexion;
        }

        /**
         * Devuelve el listado de categorias
         * @return mixed
         */
        public function listadoCategorias()
        {
            try
            {
                $this->obtenerConexion();

                if ($this->conexion != null)
                {
                    $sql = "SELECT * FROM categorias ORDER BY idCategoria ASC";
                    $consulta = $this->conexion->prepare($sql);
                    $consulta->execute();
                    $resultado = $consulta->get_result();

                    $consulta->close();
                    $this->conexion->close();

                    if ($resultado->num_rows > 0)
                    {
                        return $resultado;
                    }
                    else
                    {
                        return null;
                    }
                }
                else
                {
                    return null;
                }
            }
            catch(mysqli_sql_exception $e)
            {
                return null;
            }
        }

        /**
         * Devuelve el nombre de la categoría
         * @param Number $id ID de la categoría a sacar.
         * @return String Categoría.
         */
        public function obtenerCategoria($id)
        {
            try
            {
                $this->obtenerConexion();
                
                if ($this->conexion != null)
                {
                    $sql = "SELECT nombreCategoria FROM categorias WHERE idCategoria=?";
                    $consulta = $this->conexion->prepare($sql);
                    $consulta->bind_param('i', $id);
                    $consulta->execute();
                    $resultado = $consulta->get_result();

                    $consulta->close();
                    $this->conexion->close();

                    if ($resultado->num_rows > 0)
                    {
                        $fila = $resultado->fetch_array(MYSQLI_ASSOC);
        
                        if (isset($fila['nombreCategoria']) && !empty($fila['nombreCategoria']))
                        {
                            return $fila['nombreCategoria'];
                        }
                        else
                        {
                            return '';
                        }
                    }
                }
                else
                {
                    return '';
                }
            }
            catch(mysqli_sql_exception $e)
            {
                return '';
            }
        }

        /**
         * Devuelve el listado de los retos encontrados.
         * @param String $busqueda Nombre de el/los reto/s a buscar.
         * @param String|Null $filtrado Filtrado por categoría.
         * @return Number Código éxito/error.
         */
        public function listadoBusqueda($busqueda, $filtrado)
        {
            try
            {
                $this->obtenerConexion();
                
                if ($this->conexion != null)
                {
                    $idProfesor = $_SESSION['idProfesor'];

                    if ($busqueda != null && $filtrado != null) // Buscar y filtrar
                    {
                        $busqueda = "%" . $busqueda . "%";
                        $sql = "SELECT * FROM retos WHERE nombreReto LIKE ? AND idCategoria = ? AND idProfesor = ?";
                        $consulta = $this->conexion->prepare($sql);
                        $consulta->bind_param('sii', $busqueda, $filtrado, $idProfesor);
                    }
                    else if ($busqueda != null) // Buscar
                    {
                        $busqueda = "%" . $busqueda . "%";
                        $sql = "SELECT * FROM retos WHERE nombreReto LIKE ? AND idProfesor = ?";
                        $consulta = $this->conexion->prepare($sql);
                        $consulta->bind_param('si', $busqueda, $idProfesor);
                    }
                    else if ($filtrado != null) // Filtrar
                    {
                        $sql = "SELECT * FROM retos WHERE idCategoria = ? AND idProfesor = ?";
                        $consulta = $this->conexion->prepare($sql);
                        $consulta->bind_param('ii', $filtrado, $idProfesor);
                    }

                    $consulta->execute();
                    $resultado = $consulta->get_result();

                    $consulta->close();
                    $this->conexion->close();

                    if ($resultado->num_rows > 0)
                    {
                        $this->listaRetos = $resultado;
                        return 1;
                    }
                    else
                    {
                        $this->listaRetos = null;
                        return 0;
                    }
                }
                else
                {
                    return -1;
                }
            }
            catch(mysqli_sql_exception $e)
            {
                $this->listaRetos = null;
                return $e->getCode();
            }
        }

        /**
         * Borra un reto.
         * @param Number $id ID del reto.
         * @return Number Nº del resultado.
         */
        public function borrarReto($id)
        {
            try
            {
                $this->obtenerConexion();
                
                if ($this->conexion != null)
                {
                    $idProfesor = $_SESSION['idProfesor'];
                    $sql = "DELETE FROM retos WHERE idReto=? AND idProfesor=?";

                    $consulta = $this->conexion->prepare($sql);
                    $consulta->bind_param('ii', $id, $idProfesor);
                    $consulta->execute();
                  
                    $this->conexion->close();

                    if ($consulta->affected_rows > 0)
                    {
                        $consulta->close();
                        return 1;
                    }
                    else
                    {
                        $consulta->close();
                        return 0;
                    }
                }
                else
                {
                    return -1;
                }
            }
            catch(mysqli_sql_exception $e)
            {
                return $e->getCode();
            }
        }

        /**
         * Publicar un reto.
         * @param Number $id ID del reto.
         * @return Number Nº del resultado.
         */
        public function publicarReto($id)
        {
            try
            {
                $reto = $this->obtenerReto($id);
                $this->obtenerConexion();

                if ($this->conexion != null)
                {
                    $idProfesor = $_SESSION['idProfesor'];

                    // Comprobar que el reto no haya sido ya publicado.
                    if ($reto != null && $reto['publicado'] == 1) return 2;

                    $fechaPublicacion = $this->obtenerFechaActual();
                    $publicado = 1;

                    $sql = "UPDATE retos SET fechaPublicacion=?, publicado=? WHERE idReto=? AND idProfesor=?";
                    $consulta = $this->conexion->prepare($sql);
                    $consulta->bind_param('siii', $fechaPublicacion, $publicado, $id, $idProfesor);
                    $consulta->execute();
    
                    $this->conexion->close();
    
                    if ($consulta->affected_rows > 0)
                    {
                        $consulta->close();
                        return 1;
                    }
                    else
                    {
                        $consulta->close();
                        return 0;
                    }
                }
                else
                {
                    return -1;
                }
            }
            catch(mysqli_sql_exception $e)
            {
                return $e->getCode();
            }
        }

        /**
         * Obtiene el listado de los retos.
         * @return Number Código éxito/error.
         */
        public function listadoRetos()
        {
            try
            {
                $this->obtenerConexion();
                
                if ($this->conexion != null)
                {
                    $idProfesor = $_SESSION['idProfesor'];
                    $sql = "SELECT * FROM retos WHERE idProfesor=? ORDER BY idReto ASC";

                    $consulta = $this->conexion->prepare($sql);
                    $consulta->bind_param('i', $idProfesor);
                    $consulta->execute();
                    $resultado = $consulta->get_result();

                    $consulta->close();
                    $this->conexion->close();
                    
                    if ($resultado->num_rows > 0)
                    {
                        $this->listaRetos = $resultado;
                        return 1;
                    }
                    else
                    {
                        $this->listaRetos = null;
                        return 0;
                    }
                }
                else
                {
                    return -1;
                }
            }
            catch(mysqli_sql_exception $e)
            {
                $this->listaRetos = null;
                return $e->getCode();
            }
        }

        /**
         * Obtiene el nombre del reto.
         * @param Number $id ID del reto.
         * @return String Nombre del reto.
         */
        public function obtenerNombreReto($id)
        {
            try
            {
                $this->obtenerConexion();
                
                if ($this->conexion != null)
                {
                    $sql = "SELECT nombreReto FROM retos WHERE idReto=?";

                    $consulta = $this->conexion->prepare($sql);
                    $consulta->bind_param('i', $id);
                    $consulta->execute();
                    $resultado = $consulta->get_result();

                    $consulta->close();
                    $this->conexion->close();
                    
                    if ($resultado->num_rows > 0)
                    {
                        $fila = $resultado->fetch_array(MYSQLI_ASSOC);

                        if (isset($fila['nombreReto']) && !empty($fila['nombreReto']))
                        {
                            return $fila['nombreReto'];
                        }
                        else
                        {
                            return '';
                        }
                    }
                    else
                    {
                        return '';
                    }
                }
                else
                {
                    return '';
                }
            }
            catch(mysqli_sql_exception $e)
            {
                return '';
            }
        }

        /**
         * Obtiene el reto.
         * @param Number $id ID del reto.
         * @return mixed Datos del reto.
         */
        public function obtenerReto($id)
        {
            try
            {
                $this->obtenerConexion();
    
                if ($this->conexion != null)
                {
                    $idProfesor = $_SESSION['idProfesor'];
                    $sql = "SELECT * FROM retos WHERE idReto=? AND idProfesor=?";

                    $consulta = $this->conexion->prepare($sql);
                    $consulta->bind_param('ii', $id, $idProfesor);
                    $consulta->execute();
                    $resultado = $consulta->get_result();

                    $consulta->close();
                    $this->conexion->close();
                    
                    if ($resultado != null)
                    {
                        $fila = $resultado->fetch_array(MYSQLI_ASSOC);
                        return $fila;
                    }
                    else
                    {
                        return null;
                    }
                }
                else
                {
                    return null;
                }
            }
            catch(mysqli_sql_exception $e)
            {
                return null;
            }
        }

        /**
         * Obtiene el nombre del profesor.
         * @return String Nombre del profesor.
         */
        public function obtenerNombreProfesor()
        {
            try
            {
                $this->obtenerConexion();

                if ($this->conexion != null)
                {
                    $idProfesor = $_SESSION['idProfesor'];
                    $sql = "SELECT nombre FROM profesores WHERE idProfesor=?";

                    $consulta = $this->conexion->prepare($sql);
                    $consulta->bind_param('i', $idProfesor);
                    $consulta->execute();

                    $resultado = $consulta->get_result();

                    $consulta->close();
                    $this->conexion->close();
                    
                    if ($resultado->num_rows > 0)
                    {
                        $fila = $resultado->fetch_array(MYSQLI_ASSOC);
                        
                        if (isset($fila['nombre']) && !empty($fila['nombre']))
                        {
                            return $fila['nombre'];
                        }
                        else
                        {
                            return '';
                        }
                    }
                    else
                    {
                        return '';
                    }
                }
                else
                {
                    return '';
                }
            }
            catch(mysqli_sql_exception $e)
            {
                return '';
            }
        }

        /**
         * Añade un reto.
         * @param Array $array Array de datos.
         * @return Number Nº del código de error o éxito.
         */
        public function altaReto($array)
        {
            try
            {
                $this->obtenerConexion();
                
                if ($this->conexion != null)
                {
                    $nombre = $array['nombre'];
                    $dirigido = $array['dirigido'];

                    if (empty($array['descReto'])) $descripcion = NULL;
                    else $descripcion = $array['descReto'];

                    $fechaInicioInscripcion = $array['fechaInicioIns'];
                    $fechaFinInscripcion = $array['fechaFinIns'];
                    $fechaInicioReto = $array['fechaInicioReto'];
                    $fechaFinReto = $array['fechaFinReto'];
                    $fechaPublicacion = '2023-12-31 23:59:50';
                    $publicado = $array['publicacion'];
                    $idProfesor = $_SESSION['idProfesor'];
                    $idCategoria = $array['categoria'];

                    if ($publicado == 1)
                    {
                        $fechaPublicacion = $this->obtenerFechaActual();
                    }
                    else
                    {
                        $fechaPublicacion = '1970-01-01 00:00:00';
                    }
                    
                    $sql = "INSERT INTO retos(nombreReto, dirigido, descripcion, fechaInicioInscripcion, fechaFinInscripcion, fechaInicioReto, fechaFinReto, fechaPublicacion, publicado, idProfesor, idCategoria) VALUES(?,?,?,?,?,?,?,?,?,?,?)";
                    $consulta = $this->conexion->prepare($sql);
                    $consulta->bind_param('ssssssssiii', $nombre, $dirigido, $descripcion, $fechaInicioInscripcion, $fechaFinInscripcion, $fechaInicioReto, $fechaFinReto, $fechaPublicacion, $publicado, $idProfesor, $idCategoria);
                    $consulta->execute();

                    $this->conexion->close();

                    if ($consulta->affected_rows > 0)
                    {
                        $consulta->close();
                        return 1;
                    }
                    else
                    {
                        $consulta->close();
                        return 0;
                    }
                }
                else
                {
                    return -1;
                }
            }
            catch(mysqli_sql_exception $e)
            {
                return $e->getCode();
            }
        }


        /**
         * Devuelve la fecha y hora actuales del sistema.
         * @return String Fecha y hora.
         */
        public function obtenerFechaActual()
        {
            $d = new DateTime('now');
            $fecha = $d->format('Y-m-d H:i:s');
            return $fecha;
        }

        /**
         * Modifica un reto.
         * @param Array $arrayGet Array de datos.
         * @param Array $arrayPost Array de datos.
         * @return Number Nº del código de error o éxito.
         */
        public function modificarReto($arrayGet, $arrayPost)
        {
            try
            {
                $this->obtenerConexion();

                if ($this->conexion != null)
                {
                    $nombre = $arrayPost['nombre'];
                    $dirigido = $arrayPost['dirigido'];
                    
                    if (empty($array['descReto'])) $descripcion = NULL;
                    else $descripcion = $array['descReto'];

                    $fechaInicioInscripcion = $arrayPost['fechaInicioIns'];
                    $fechaFinInscripcion = $arrayPost['fechaFinIns'];
                    $fechaInicioReto = $arrayPost['fechaInicioReto'];
                    $fechaFinReto = $arrayPost['fechaFinReto'];
                    $idProfesor = $_SESSION['idProfesor'];
                    $idCategoria = $arrayPost['categoria'];

                    $idReto = $arrayGet['id'];
                    if ($idReto == null) $idReto = $arrayPost['reto'];
                    
                    $sql = "UPDATE retos SET nombreReto=?, dirigido=?, descripcion=?, fechaInicioInscripcion=?, fechaFinInscripcion=?, fechaInicioReto=?, fechaFinReto=?, idCategoria=? WHERE idReto=? AND idProfesor=?";
                    $consulta = $this->conexion->prepare($sql);
                    $consulta->bind_param('sssssssiii', $nombre, $dirigido, $descripcion, $fechaInicioInscripcion, $fechaFinInscripcion, $fechaInicioReto, $fechaFinReto, $idCategoria, $idReto, $idProfesor);
                    $consulta->execute();

                    $this->conexion->close();
    
                    if ($consulta->affected_rows > 0)
                    {
                        $consulta->close();
                        return 1;
                    }
                    else
                    {
                        $consulta->close();
                        return 0;
                    }
                }
                else
                {
                    return -1;
                }
            }
            catch(mysqli_sql_exception $e)
            {
                return $e->getCode();
            }
        }
    }