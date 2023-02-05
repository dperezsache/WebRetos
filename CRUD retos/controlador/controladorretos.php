<?php
    require_once('../modelo/modeloretos.php');

    /**
     * Clase ControladorRetos.
     * Controlador del CRUD de retos.
     */
    class ControladorRetos
    {
        private $modelo;

        public function __construct()
        {
            $this->modelo = new ModeloRetos();
        }

        /**
         * Devuelve si hay listado de retos o no.
         * @return Number Nº del código de error o éxito.
         */
        public function hayListado()
        {
            return $this->modelo->listadoRetos();
        }

        /**
         * Devuelve el listado de los retos.
         * @return mixed Listado de retos.
         */
        public function obtenerListado()
        {
            return $this->modelo->listaRetos;
        }

        /**
         * Sacar el nombre del reto.
         * @param Array $array Array de datos.
         * @return String Nombre del reto.
         */
        public function obtenerNombreReto($array)
        {
            if(isset($array['id']))
            {
                return $this->modelo->obtenerNombreReto($array['id']);
            }
            else
            {
                return '';
            }
        }

        /**
         * Obtiene el listado de categorías
         * @return mixed
         */
        public function obtenerCategorias()
        {
            return $this->modelo->listadoCategorias();
        }

        /**
         * Añade un nuevo reto.
         * @param Array $array Array de datos.
         * @return Number Nº del código de error o éxito.
         */
        public function altaReto($array)
        {
            $contador = 0;  // Contador de validaciones correctas

            if(isset($array['nombre']))
            {
                if (!empty($array['nombre'])) $contador++;
                else return -2;  // Error nombre vacío
            }    
            if(isset($array['dirigido']))
            {
                if (!empty($array['dirigido'])) $contador++;
                else return -3; // Error dirigido vacío
            }
            if(isset($array['descReto']))
            {
                if (!empty($array['descReto'])) $contador++;
                else return -4; // Error descripción vacía
            }
            if(isset($array['fechaInicioIns']))
            {
                if (!empty($array['fechaInicioIns'])) $contador++;
                else return -5; // Error fecha inicio inscripción vacía
            }
            if(isset($array['fechaFinIns']))
            {
                if (!empty($array['fechaFinIns'])) $contador++;
                else return -6; // Error fecha fin inscripción vacía
            }
            if(isset($array['fechaInicioReto']))
            {
                if (!empty($array['fechaInicioReto'])) $contador++;
                else return -7; // Error fecha inicio reto vacía
            }
            if(isset($array['fechaFinReto']))
            {
                if (!empty($array['fechaFinReto'])) $contador++;
                else return -8; // Error fecha fin reto vacía
            }
            echo '<p>' . $contador . '</p>';
            if($contador == 7)
            {
                return $this->modelo->altaReto($array);
            }
            else
            {
                return 0;
            }
        }
    }
?>