<?php
    require_once('../modelo/modelocategorias.php');

    class ControladorCategorias
    {
        private $modelo;

        public function __construct()
        {
            $this->modelo = new ModeloCategorias();
        }

        /**
         * Devuelve el listado de categorías.
         */
        public function getListado()
        {
            return $this->modelo->listadoCategorias();
        }

        /**
         * Añade una categoría.
         * @param String $nombre Nombre de la categoría.
         * @return Boolean True si se añade, False si no.
         */
        public function altaCategoria($nombre)
        {
            if(isset($nombre) && !empty($nombre))
            {
                return $this->modelo->altaCategoria($nombre);
            }
            else
            {
                return false;
            }
        }

        /**
         * Elimina una categoría.
         * @param Number $id ID de la categoría.
         * @return Boolean True si se ha borrado, False si no.
         */
        public function borrarCategoria($id)
        {
            if(isset($id))
            {
                return $this->modelo->borrarCategoria($id);
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
         * @return Boolean True si se ha modificado, False si no.
         */
        public function modificarCategoria($id, $nombre)
        {
            if(isset($id))
            {
                return $this->modelo->modificarCategoria($id, $nombre);
            }
            else
            {
                return false;
            }
        }

        /**
         * Sacar el nombre de la categoría.
         * @param Number $id ID de la categoría.
         * @return String Nombre de la categoría.
         */
        public function obtenerNombreCategoria($id)
        {
            if(isset($id))
            {
                return $this->modelo->obtenerNombreCategoria($id);
            }
            else
            {
                return null;
            }
        }

        /**
         * Devuelve la fecha actual.
         */
        public function obtenerFechaActual()
        {
            $fechaActual = date('d-m-Y');
            return $fechaActual;
        }
    }
?>