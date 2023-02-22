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

                if($this->conexion != null)
                {
                    $consulta = $this->conexion->prepare('SELECT * FROM categorias ORDER BY idCategoria ASC');
                    $consulta->execute();
                    $resultado = $consulta->get_result();

                    $consulta->close();
                    $this->conexion->close();

                    if($resultado->num_rows > 0)
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
                
                if($this->conexion != null)
                {
                    $consulta = $this->conexion->prepare("SELECT nombreCategoria FROM categorias WHERE idCategoria=?");
                    $consulta->bind_param('i', $id);
                    $consulta->execute();
                    $resultado = $consulta->get_result();

                    $consulta->close();
                    $this->conexion->close();

                    if($resultado->num_rows > 0)
                    {
                        $fila = $resultado->fetch_assoc();
        
                        if(isset($fila['nombreCategoria']) && !empty($fila['nombreCategoria']))
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
                
                if($this->conexion != null)
                {
                    if ($busqueda != null && $filtrado != null) // Buscar y filtrar
                    {
                        $busqueda = "%" . $busqueda . "%";
                        $consulta = $this->conexion->prepare("SELECT * FROM retos WHERE nombreReto LIKE ? AND idCategoria = ?");
                        $consulta->bind_param('si', $busqueda, $filtrado);
                    }
                    else if ($busqueda != null) // Buscar
                    {
                        $busqueda = "%" . $busqueda . "%";
                        $consulta = $this->conexion->prepare("SELECT * FROM retos WHERE nombreReto LIKE ?");
                        $consulta->bind_param('s', $busqueda);
                    }
                    else if ($filtrado != null) // Filtrar
                    {
                        $consulta = $this->conexion->prepare("SELECT * FROM retos WHERE idCategoria = ?");
                        $consulta->bind_param('i', $filtrado);
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
                
                if($this->conexion != null)
                {
                    $consulta = $this->conexion->prepare("DELETE FROM retos WHERE idReto=?");
                    $consulta->bind_param('i', $id);
                    $consulta->execute();
                  
                    $this->conexion->close();

                    if($consulta->affected_rows > 0)
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
                $this->obtenerConexion();

                if($this->conexion != null)
                {
                    $fechaPublicacion = $this->obtenerFechaActual();
                    $publicado = 1;

                    $consulta = $this->conexion->prepare("UPDATE retos SET fechaPublicacion=?, publicado=? WHERE idReto=?");
                    $consulta->bind_param('sii', $fechaPublicacion, $publicado, $id);
                    $consulta->execute();
    
                    $this->conexion->close();
    
                    if($consulta->affected_rows > 0)
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
                
                if($this->conexion != null)
                {
                    $consulta = $this->conexion->prepare('SELECT * FROM retos ORDER BY idReto ASC');
                    $consulta->execute();
                    $resultado = $consulta->get_result();

                    $consulta->close();
                    $this->conexion->close();
                    
                    if($resultado->num_rows > 0)
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
                
                if($this->conexion != null)
                {
                    $consulta = $this->conexion->prepare("SELECT nombreReto FROM retos WHERE idReto=?");
                    $consulta->bind_param('i', $id);
                    $consulta->execute();
                    $resultado = $consulta->get_result();

                    $consulta->close();
                    $this->conexion->close();
                    
                    if($resultado->num_rows > 0)
                    {
                        $fila = $resultado->fetch_assoc();

                        if(isset($fila['nombreReto']) && !empty($fila['nombreReto']))
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
    
                if($this->conexion != null)
                {
                    $consulta = $this->conexion->prepare("SELECT * FROM retos WHERE idReto=?");
                    $consulta->bind_param('i', $id);
                    $consulta->execute();
                    $resultado = $consulta->get_result();

                    $consulta->close();
                    $this->conexion->close();
                    
                    if($resultado != null)
                    {
                        $fila = $resultado->fetch_assoc();
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
         * Añade un reto.
         * @param Array $array Array de datos.
         * @return Number Nº del código de error o éxito.
         */
        public function altaReto($array)
        {
            try
            {
                $this->obtenerConexion();
                
                if($this->conexion != null)
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
                    $idProfesor = 1;
                    $idCategoria = $array['categoria'];

                    if($publicado == 1)
                    {
                        $fechaPublicacion = $this->obtenerFechaActual();
                    }
                    else
                    {
                        $fechaPublicacion = '1970-01-01 00:00:00';
                    }
                    
                    $consulta = $this->conexion->prepare("INSERT INTO retos(nombreReto, dirigido, descripcion, fechaInicioInscripcion, fechaFinInscripcion, fechaInicioReto, fechaFinReto, fechaPublicacion, publicado, idProfesor, idCategoria) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
                    $consulta->bind_param('ssssssssiii', $nombre, $dirigido, $descripcion, $fechaInicioInscripcion, $fechaFinInscripcion, $fechaInicioReto, $fechaFinReto, $fechaPublicacion, $publicado, $idProfesor, $idCategoria);
                    $consulta->execute();

                    $this->conexion->close();

                    if($consulta->affected_rows > 0)
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

                if($this->conexion != null)
                {
                    $nombre = $arrayPost['nombre'];
                    $dirigido = $arrayPost['dirigido'];
                    
                    if (empty($array['descReto'])) $descripcion = NULL;
                    else $descripcion = $array['descReto'];

                    $fechaInicioInscripcion = $arrayPost['fechaInicioIns'];
                    $fechaFinInscripcion = $arrayPost['fechaFinIns'];
                    $fechaInicioReto = $arrayPost['fechaInicioReto'];
                    $fechaFinReto = $arrayPost['fechaFinReto'];
                    $fechaPublicacion = '2023-12-31 23:59:50';
                    $publicado = 1;
                    $idProfesor = 1;
                    $idCategoria = $arrayPost['categoria'];
                    
                    $idReto = $arrayGet['id'];
                    if ($idReto == null) $idReto = $arrayPost['reto'];

                    $consulta = $this->conexion->prepare("UPDATE retos SET nombreReto=?, dirigido=?, descripcion=?, fechaInicioInscripcion=?, fechaFinInscripcion=?, fechaInicioReto=?, fechaFinReto=?, fechaPublicacion=?, publicado=?, idProfesor=?, idCategoria=? WHERE idReto=?");
                    $consulta->bind_param('ssssssssiiii', $nombre, $dirigido, $descripcion, $fechaInicioInscripcion, $fechaFinInscripcion, $fechaInicioReto, $fechaFinReto, $fechaPublicacion, $publicado, $idProfesor, $idCategoria, $idReto);
                    $consulta->execute();

                    $this->conexion->close();
    
                    if($consulta->affected_rows > 0)
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
