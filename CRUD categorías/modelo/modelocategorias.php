<?php
    require_once('../modelo/modelodb.php');

    class ModeloCategorias
    {
        private $conexion;

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
         * @return Boolean True si se añade, False si no.
         */
        public function altaCategoria($nombre)
        {
            $this->obtenerConexion();
            $consulta = "INSERT INTO categorias(nombreCategoria) VALUES('" . $nombre . "');";
            
            if($this->conexion != null)
            {
                $this->conexion->query($consulta);

                if($this->conexion->affected_rows > 0)
                {
                    $this->conexion->close();
                    return true;
                }
                else
                {
                    $this->conexion->close();
                    return false;
                }
            }
            else
            {
                return false;
            }
        }

        /**
         * Borra una categoría.
         * @param Number $id ID de la categoría.
         * @return Boolean True si se borra, False si no.
         */
        public function borrarCategoria($id)
        {
            $this->obtenerConexion();
            $consulta = "DELETE FROM categorias WHERE idCategoria='$id'";

            if($this->conexion != null)
            {
                $this->conexion->query($consulta);

                if($this->conexion->affected_rows > 0)
                {
                    $this->conexion->close();
                    return true;
                }
                else
                {
                    $this->conexion->close();
                    return false;
                }
            }
            else
            {
                return false;
            }
        }

        /**
         * Modifica una categoría.
         * @param Number $id ID de la categoría.
         * @param String $nombre Nombre de la categoría.
         * @return Boolean True si se actualiza, False si no.
         */
        public function modificarCategoria($id, $nombre)
        {
            $this->obtenerConexion();
            $consulta = "UPDATE categorias SET idCategoria='$id', nombreCategoria='$nombre' WHERE idCategoria='$id'";
            
            if($this->conexion != null && $nombre != null)
            {
                $this->conexion->query($consulta);

                if($this->conexion->affected_rows > 0)
                {
                    $this->conexion->close();
                    return true;
                }
                else
                {
                    $this->conexion->close();
                    return false;
                }
            }
            else
            {
                return false;
            }
        }

        /**
         * Obtiene el nombre de la categoría.
         * @param Number $id ID de la categoría.
         * @return String Nombre de la categoría.
         */
        public function obtenerNombreCategoria($id)
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
                    return null;
                }
            }
            else
            {
                return null;
            }
        }

        /**
         * Devuelve al controlador el listado de categorías.
         */
        public function listadoCategorias()
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
    }
?>