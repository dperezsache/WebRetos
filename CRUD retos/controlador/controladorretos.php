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
         * Devuelve si hay listado de retos, o si se va hacer una búsqueda.
         * @param Array $array Array de datos.
         * @return Number Nº del código de error o éxito.
         */
        public function hayListado($array)
        {
            if(isset($array['busqueda']) && !empty($array['busqueda']))
            {
                return $this->modelo->listadoBusqueda($array['busqueda']);
            }
            else
            {
                return $this->modelo->listadoRetos();
            }
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
         * Devuelve la categoría indicada.
         * @param Number $id ID de la categoría.
         * @return String Categoría.
         */
        public function obtenerCategoria($id)
        {
            return $this->modelo->obtenerCategoria($id);
        }

        /**
         * Devuelve reto indicado.
         * @param Number $id ID del reto.
         * @return mixed Datos del reto.
         */
        public function obtenerReto($array)
        {
            if(isset($array['id']))
            {
                return $this->modelo->obtenerReto($array['id']);
            }
            else
            {
                return null;
            }
        }

        /**
         * Elimina un reto.
         * @param Array $array Array de datos.
         * @return Number Nº del código de error o éxito.
         */
        public function borrarReto($array)
        {
            if(isset($array['reto']))
            {
                return $this->modelo->borrarReto($array['reto']);
            }
            else
            {
                return 0;
            }
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

            if($contador == 7)
            {
                $contador = 0;

                $fechaInicioInscripcion = new DateTime($array['fechaInicioIns']);
                $fechaFinInscripcion = new DateTime($array['fechaFinIns']);
                $fechaInicioReto = new DateTime($array['fechaInicioReto']);
                $fechaFinReto = new DateTime($array['fechaFinReto']);
                $fechaActual = new DateTime('now');

                if ($fechaInicioInscripcion <= $fechaFinInscripcion && $fechaInicioInscripcion >= $fechaActual && $fechaInicioReto >= $fechaInicioInscripcion) $contador++;
                else return -10;    // Error fecha inicio inscripción incorrecta.

                if ($fechaInicioInscripcion <= $fechaFinInscripcion) $contador++;
                else return -11;    // Error fecha fin inscripción incorrecta.

                if ($fechaInicioReto <= $fechaFinReto && $fechaInicioReto >= $fechaInicioInscripcion) $contador++;
                else return -12;    // Error fecha inicio reto incorrecta.

                if ($fechaInicioReto <= $fechaFinReto) $contador++;
                else return -13;    // Error fecha fin reto incorrecta.

                if ($contador == 4)
                    return $this->modelo->altaReto($array);
            }
            else
            {
                return 0;
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
            if($arrayGet['id'])
            {
                $contador = 0;  // Contador de validaciones correctas

                if(isset($arrayPost['nombre']))
                {
                    if (!empty($arrayPost['nombre'])) $contador++;
                    else return -2;  // Error nombre vacío
                }    
                if(isset($arrayPost['dirigido']))
                {
                    if (!empty($arrayPost['dirigido'])) $contador++;
                    else return -3; // Error dirigido vacío
                }
                if(isset($arrayPost['descReto']))
                {
                    if (!empty($arrayPost['descReto'])) $contador++;
                    else return -4; // Error descripción vacía
                }
                if(isset($arrayPost['fechaInicioIns']))
                {
                    if (!empty($arrayPost['fechaInicioIns'])) $contador++;
                    else return -5; // Error fecha inicio inscripción vacía
                }
                if(isset($arrayPost['fechaFinIns']))
                {
                    if (!empty($arrayPost['fechaFinIns'])) $contador++;
                    else return -6; // Error fecha fin inscripción vacía
                }
                if(isset($arrayPost['fechaInicioReto']))
                {
                    if (!empty($arrayPost['fechaInicioReto'])) $contador++;
                    else return -7; // Error fecha inicio reto vacía
                }
                if(isset($arrayPost['fechaFinReto']))
                {
                    if (!empty($arrayPost['fechaFinReto'])) $contador++;
                    else return -8; // Error fecha fin reto vacía
                }

                if($contador == 7)
                {
                    $contador = 0;
    
                    $fechaInicioInscripcion = new DateTime($arrayPost['fechaInicioIns']);
                    $fechaFinInscripcion = new DateTime($arrayPost['fechaFinIns']);
                    $fechaInicioReto = new DateTime($arrayPost['fechaInicioReto']);
                    $fechaFinReto = new DateTime($arrayPost['fechaFinReto']);
                    $fechaActual = new DateTime('now');
    
                    if ($fechaInicioInscripcion <= $fechaFinInscripcion && $fechaInicioInscripcion >= $fechaActual && $fechaInicioReto >= $fechaInicioInscripcion) $contador++;
                    else return -11;    // Error fecha inicio inscripción incorrecta.
    
                    if ($fechaInicioInscripcion <= $fechaFinInscripcion) $contador++;
                    else return -12;    // Error fecha fin inscripción incorrecta.
    
                    if ($fechaInicioReto <= $fechaFinReto && $fechaInicioReto >= $fechaInicioInscripcion) $contador++;
                    else return -13;    // Error fecha inicio reto incorrecta.
    
                    if ($fechaInicioReto <= $fechaFinReto) $contador++;
                    else return -14;    // Error fecha fin reto incorrecta.
    
                    if ($contador == 4)
                        return $this->modelo->modificarReto($arrayGet, $arrayPost);
                }
                else
                {
                    return 0;
                }
            }
            else
            {
                return -9;  // Error no ID
            }
        }
    }
?>