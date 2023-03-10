<?php
    require_once(dirname(__DIR__) . '/model/modelocategorias.php');

    /**
     * Clase ControladorCategorias.
     * Controlador del CRUD de categorías.
     */
    class ControladorCategorias
    {
        private $modelo;

        public function __construct()
        {
            $this->modelo = new ModeloCategorias();
        }

        /**
         * Cargar el listado de categorías.
         * @return Number Nº de resultado.
         */
        public function cargarListado()
        {
            return $this->modelo->listadoCategorias();
        }

        /**
         * Devuelve el listado de las categorías.
         * @return mixed Listado de categorías.
         */
        public function obtenerListado()
        {
            return $this->modelo->listaCategorias;
        }

        /**
         * Añade una categoría.
         * @param Array $array Array de datos.
         * @return Number Nº del código de error o éxito.
         */
        public function altaCategoria($array)
        {
            if (isset($array['nombre']))
            {
                if (!empty($array['nombre']))
                {
                    return $this->modelo->altaCategoria($array['nombre']);
                }
                else
                {
                    return -2;
                }
            }    
            else
            {
                return 0;
            }
        }

        /**
         * Elimina una categoría.
         * @param Array $array Array de datos.
         * @return Number Nº del código de error o éxito.
         */
        public function borrarCategoria($array)
        {
            if (isset($array['id']))
            {
                return $this->modelo->borrarCategoria($array['id']);
            }
            else
            {
                return 0;
            }
        }

        /**
         * Modifica una categoría.
         * @param Array $arrayGet Array de datos.
         * @param Array $arrayPost Array de datos.
         * @return Number Nº del código de error o éxito.
         */
        public function modificarCategoria($arrayGet, $arrayPost)
        {
            if (isset($arrayGet['id']) && isset($arrayPost['nombre']))
            {
                if (!empty($arrayPost['nombre'])) return $this->modelo->modificarCategoria($arrayGet['id'], $arrayPost['nombre']);
                else return -2;
            }
            else if (isset($arrayPost['categoria']) && isset($arrayPost['nombre']))
            {
                if (!empty($arrayPost['nombre'])) return $this->modelo->modificarCategoria($arrayPost['categoria'], $arrayPost['nombre']);
                else return -2;
            }
            else
            {
                return 0;
            }
        }

        /**
         * Sacar el nombre de la categoría.
         * @param Array $array Array de datos.
         * @return String Nombre de la categoría.
         */
        public function obtenerNombreCategoria($array)
        {
            if (isset($array['id']))
            {
                return $this->modelo->obtenerNombreCategoria($array['id']);
            }
            else
            {
                return '';
            }
        }

        /**
         * Sacar el nombre de la categoría.
         * @param Number $id ID de la categoría.
         * @return mixed La categoría.
         */
        public function obtenerCategoria($id)
        {
            if (isset($id))
            {
                return $this->modelo->obtenerNombreCategoria($id);
            }
            else
            {
                return '';
            }
        }

        /**
         * Devuelve mensaje adicional al error.
         * @return string Texto del error.
         */
        public function errorTexto()
        {
            return $this->modelo->errorTexto;
        }
    }
?>