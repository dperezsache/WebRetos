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
                
                if($this->conexion != null)
                {
                    $consulta = $this->conexion->prepare("INSERT INTO categorias(nombreCategoria) VALUES(?)");
                    $consulta->bind_param('s', $nombre);
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
         * Borra una categoría.
         * @param Number $id ID de la categoría.
         * @return Number Nº del resultado.
         */
        public function borrarCategoria($id)
        {
            try
            {
                $this->obtenerConexion();
                
                if($this->conexion != null)
                {
                    $consulta = $this->conexion->prepare("DELETE FROM categorias WHERE idCategoria=?");
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
                
                if($this->conexion != null)
                {
                    $consulta = $this->conexion->prepare("UPDATE categorias SET idCategoria=?, nombreCategoria=? WHERE idCategoria=?");
                    $consulta->bind_param('isi', $id, $nombre, $id);
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
         * Obtiene el nombre de la categoría.
         * @param Number $id ID de la categoría.
         * @return String Nombre de la categoría.
         */
        public function obtenerNombreCategoria($id)
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
                
                if($this->conexion != null)
                {
                    $consulta = $this->conexion->prepare("SELECT * FROM categorias ORDER BY idCategoria ASC");
                    $consulta->execute();
                    $resultado = $consulta->get_result();

                    $consulta->close();
                    $this->conexion->close();

                    if($resultado->num_rows > 0)
                    {
                        $this->listaCategorias = $resultado;
                        return 1;
                    }
                    else
                    {
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