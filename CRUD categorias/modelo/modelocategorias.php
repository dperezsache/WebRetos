<?php
    require_once('../modelo/modelodb.php');

    /**
     * Clase ModeloCategorias.
     * Clase que ejecuta los procesos del CRUD de categorías.
     */
    class ModeloCategorias
    {
        private $conexion;
        public $listaCategorias;

        /** 
         * Obtiene la conexión a la BBDD.
         */
        public function obtenerConexion()
        {
            $objConectar = new modelodb();
            $this->conexion = $objConectar->conexion;
        }

        /**
         * Añadir categoría.
         * @param String $nombre Nombre de la categoría.
         * @return Number Nº del resultado.
         */
        public function altaCategoria($nombre)
        {
            try
            {
                $this->obtenerConexion();
                $consulta = "INSERT INTO categorias(nombreCategoria) VALUES('" . $nombre . "');";
                
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
         * Borra una categoría.
         * @param Number $id ID de la categoría.
         * @return Number Nº del resultado.
         */
        public function borrarCategoria($id)
        {
            try
            {
                $this->obtenerConexion();
                $consulta = "DELETE FROM categorias WHERE idCategoria='$id'";
    
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
         * Modifica una categoría.
         * @param Number $id ID de la categoría.
         * @param String $nombre Nombre de la categoría.
         * @return Number Nº del resultado.
         */
        public function modificarCategoria($id, $nombre)
        {
            try
            {
                $this->obtenerConexion();
                $consulta = "UPDATE categorias SET idCategoria='$id', nombreCategoria='$nombre' WHERE idCategoria='$id'";
                
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
         * Obtiene el nombre de la categoría.
         * @param Number $id ID de la categoría.
         * @return String Nombre de la categoría.
         */
        public function obtenerNombreCategoria($id)
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
         * Obtiene el listado de las categorías.
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
                        $this->listaCategorias = $datos;
                        return 1;
                    }
                    else
                    {
                        $this->conexion->close();
                        $this->listaCategorias = null;
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
                $this->listaCategorias = null;
                return $e->getCode();
            }
        }
    }
?>