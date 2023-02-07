<?php
    require_once('../modelo/modelodb.php');

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
                $consulta = 'SELECT * FROM categorias ORDER BY idCategoria ASC';

                if($this->conexion != null)
                {
                    $datos = $this->conexion->query($consulta);

                    if($datos->num_rows > 0)
                    {
                        $this->conexion->close();
                        return $datos;
                    }
                    else
                    {
                        $this->conexion->close();
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
                $consulta = "SELECT nombreCategoria FROM categorias WHERE idCategoria='$id'";
    
                if($this->conexion != null)
                {
                    $datos = $this->conexion->query($consulta);
                    $fila = $datos->fetch_array(MYSQLI_ASSOC);
    
                    if(isset($fila['nombreCategoria']) && !empty($fila['nombreCategoria']))
                    {
                        return $fila['nombreCategoria'];
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
         * Devuelve el listado de los retos encontrados.
         * @param String $busqueda Nombre de el/los reto/s a buscar.
         * @return Number Código éxito/error.
         */
        public function listadoBusqueda($busqueda)
        {
            try
            {
                $this->obtenerConexion();
                $consulta = "SELECT * FROM retos WHERE nombreReto LIKE '%$busqueda%'";
    
                if($this->conexion != null)
                {
                    $datos = $this->conexion->query($consulta);
    
                    if($datos->num_rows > 0)
                    {
                        $this->conexion->close();
                        $this->listaRetos = $datos;
                        return 1;
                    }
                    else
                    {
                        $this->conexion->close();
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
                $consulta = "DELETE FROM retos WHERE idReto='$id'";
    
                if($this->conexion != null)
                {
                    $this->conexion->query($consulta);
    
                    if($this->conexion->affected_rows > 0)
                    {
                        $this->conexion->close();
                        return 1;
                    }
                    else
                    {
                        $this->conexion->close();
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
                $consulta = 'SELECT * FROM retos ORDER BY idReto ASC';
    
                if($this->conexion != null)
                {
                    $datos = $this->conexion->query($consulta);
    
                    if($datos->num_rows > 0)
                    {
                        $this->conexion->close();
                        $this->listaRetos = $datos;
                        return 1;
                    }
                    else
                    {
                        $this->conexion->close();
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
                $consulta = "SELECT nombreReto FROM retos WHERE idReto='$id'";
    
                if($this->conexion != null)
                {
                    $datos = $this->conexion->query($consulta);
                    $fila = $datos->fetch_array(MYSQLI_ASSOC);
    
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
                $consulta = "SELECT * FROM retos WHERE idReto='$id'";
    
                if($this->conexion != null)
                {
                    $datos = $this->conexion->query($consulta);

                    if($datos != null)
                    {
                        $fila = $datos->fetch_array(MYSQLI_ASSOC);
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
                $consulta = "INSERT INTO retos(nombreReto, dirigido, descripcion, fechaInicioInscripcion, fechaFinInscripcion, fechaInicioReto, fechaFinReto, fechaPublicacion, publicado, idProfesor, idCategoria) 
                            VALUES('" . $array['nombre'] . "','" . $array['dirigido'] . "','" . $array['descReto'] . "','" . $array['fechaInicioIns'] . "','" . $array['fechaFinIns'] . "','" . $array['fechaInicioReto'] . "','" . $array['fechaFinReto']. "','" . '31-12-23 12:30:50' . "'," . 0 . "," . 1 . "," . $array['categoria'] . ");";

                if($this->conexion != null)
                {
                    $this->conexion->query($consulta);
    
                    if($this->conexion->affected_rows > 0)
                    {
                        $this->conexion->close();
                        return 1;
                    }
                    else
                    {
                        $this->conexion->close();
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
                $consulta = "UPDATE retos 
                            SET nombreReto='" . $arrayPost['nombre'] . "', 
                            dirigido='" . $arrayPost['dirigido'] . "', 
                            descripcion='" . $arrayPost['descReto'] . "', 
                            fechaInicioInscripcion='" . $arrayPost['fechaInicioIns'] . "', 
                            fechaFinInscripcion='" . $arrayPost['fechaFinIns'] . "', 
                            fechaInicioReto='" . $arrayPost['fechaInicioReto'] . "', 
                            fechaFinReto='" . $arrayPost['fechaFinReto'] . "', 
                            fechaPublicacion='31-12-23 12:30:50', 
                            publicado=1, 
                            idProfesor=1, 
                            idCategoria=" . $arrayPost['categoria'] . 
                            " WHERE idReto=" . $arrayGet['id'];

                if($this->conexion != null)
                {
                    $this->conexion->query($consulta);
    
                    if($this->conexion->affected_rows > 0)
                    {
                        $this->conexion->close();
                        return 1;
                    }
                    else
                    {
                        $this->conexion->close();
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
?>