<?php
    require_once(dirname(__DIR__) . '/model/modeloretos.php');

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
            if (isset($_SESSION['idProfesor']))
            {
                if (isset($array['busqueda']) && !empty($array['busqueda']))
                {
                    if (isset($array['filtrado']) && $array['filtrado'] != -1)
                    {
                        return $this->modelo->listadoBusqueda($array['busqueda'], $array['filtrado']);
                    }
                    else
                    {
                        return $this->modelo->listadoBusqueda($array['busqueda'], null);
                    }       
                }
                else
                {
                    if (isset($array['filtrado']) && $array['filtrado'] != -1)
                    {
                        return $this->modelo->listadoBusqueda(null, $array['filtrado']);
                    }
                    else
                    {
                        return $this->modelo->listadoRetos();
                    }
                }
            }
            else
            {
                return 0;
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
         * Devuelve reto indicado.
         * @param Array $array Array del reto.
         * @return mixed Datos del reto.
         */
        public function obtenerReto($array)
        {
            if (isset($_SESSION['idProfesor']))
            {
                if (isset($array['id']))
                {
                    return $this->modelo->obtenerReto($array['id']);
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
         * Devuelve el nombre profesor indicado.
         * @return String Nombre del profesor.
         */
        public function obtenerNombreProfesor()
        {
            if (isset($_SESSION['idProfesor']))
            {
                return $this->modelo->obtenerNombreProfesor();
            }
            else
            {
                return '';
            }
        }

        /**
         * Elimina un reto.
         * @param Array $array Array de datos.
         * @return Number Nº del código de error o éxito.
         */
        public function borrarReto($array)
        {
            if (isset($array['id']) && isset($_SESSION['idProfesor']))
            {
                return $this->modelo->borrarReto($array['id']);
            }
            else
            {
                return 0;
            }
        }

        /**
         * Publicar un reto.
         * @param Array $array Array de datos.
         * @return Number Nº del código de error o éxito.
         */
        public function publicarReto($array)
        {
            if (isset($array['id']) && isset($_SESSION['idProfesor']))
            {
                return $this->modelo->publicarReto($array['id']);
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
            if (isset($array['id']) && isset($_SESSION['idProfesor']))
            {
                return $this->modelo->obtenerNombreReto($array['id']);
            }
            else
            {
                return '';
            }
        }

        /**
         * Carga el listado de retos.
         * @return Number Resultado.
         */
        public function cargarRetos()
        {
            if (isset($_SESSION['idProfesor']))
            {
                return $this->modelo->listadoRetos();
            }
            else
            {
                return 0;
            }
        }

        /**
         * Obtiene el listado de retos
         * @return mixed
         */
        public function obtenerRetos()
        {
            return $this->modelo->listaRetos;
        }

        /**
         * Añade un nuevo reto.
         * @param Array $array Array de datos.
         * @return Number Nº del código de error o éxito.
         */
        public function altaReto($array)
        {
            $contador = 0;  // Contador de validaciones correctas

            if (isset($array['nombre']))
            {
                if (!empty($array['nombre'])) $contador++;
                else return -2;  // Error nombre vacío
            }    
            if (isset($array['dirigido']))
            {
                if (!empty($array['dirigido'])) $contador++;
                else return -3; // Error dirigido vacío
            }
            if (isset($array['fechaInicioIns']))
            {
                if (!empty($array['fechaInicioIns'])) $contador++;
                else return -4; // Error fecha inicio inscripción vacía
            }
            if (isset($array['fechaFinIns']))
            {
                if (!empty($array['fechaFinIns'])) $contador++;
                else return -5; // Error fecha fin inscripción vacía
            }
            if (isset($array['fechaInicioReto']))
            {
                if (!empty($array['fechaInicioReto'])) $contador++;
                else return -6; // Error fecha inicio reto vacía
            }
            if (isset($array['fechaFinReto']))
            {
                if (!empty($array['fechaFinReto'])) $contador++;
                else return -7; // Error fecha fin reto vacía
            }

            if ($contador == 6 && isset($_SESSION['idProfesor']))
            {
                $contador = 0;

                $fechaInicioInscripcion = new DateTime($array['fechaInicioIns']);
                $fechaFinInscripcion = new DateTime($array['fechaFinIns']);
                $fechaInicioReto = new DateTime($array['fechaInicioReto']);
                $fechaFinReto = new DateTime($array['fechaFinReto']);
                $fechaActual = new DateTime('now');

                if ($fechaInicioInscripcion <= $fechaFinInscripcion && $fechaInicioInscripcion >= $fechaActual && $fechaInicioReto >= $fechaInicioInscripcion) $contador++;
                else return -8;    // Error fecha inicio inscripción incorrecta.

                if ($fechaInicioInscripcion <= $fechaFinInscripcion) $contador++;
                else return -9;    // Error fecha fin inscripción incorrecta.

                if ($fechaInicioReto <= $fechaFinReto && $fechaInicioReto >= $fechaInicioInscripcion) $contador++;
                else return -10;    // Error fecha inicio reto incorrecta.

                if ($fechaInicioReto <= $fechaFinReto) $contador++;
                else return -11;    // Error fecha fin reto incorrecta.

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
            if (isset($arrayGet['id']) || isset($arrayPost['reto']))
            {
                $contador = 0;  // Contador de validaciones correctas

                if (isset($arrayPost['nombre']))
                {
                    if (!empty($arrayPost['nombre'])) $contador++;
                    else return -2;  // Error nombre vacío
                }    
                if (isset($arrayPost['dirigido']))
                {
                    if (!empty($arrayPost['dirigido'])) $contador++;
                    else return -3; // Error dirigido vacío
                }
                if (isset($arrayPost['fechaInicioIns']))
                {
                    if (!empty($arrayPost['fechaInicioIns'])) $contador++;
                    else return -4; // Error fecha inicio inscripción vacía
                }
                if (isset($arrayPost['fechaFinIns']))
                {
                    if (!empty($arrayPost['fechaFinIns'])) $contador++;
                    else return -5; // Error fecha fin inscripción vacía
                }
                if (isset($arrayPost['fechaInicioReto']))
                {
                    if (!empty($arrayPost['fechaInicioReto'])) $contador++;
                    else return -6; // Error fecha inicio reto vacía
                }
                if (isset($arrayPost['fechaFinReto']))
                {
                    if (!empty($arrayPost['fechaFinReto'])) $contador++;
                    else return -7; // Error fecha fin reto vacía
                }

                if ($contador == 6 && isset($_SESSION['idProfesor']))
                {
                    $contador = 0;
    
                    $fechaInicioInscripcion = new DateTime($arrayPost['fechaInicioIns']);
                    $fechaFinInscripcion = new DateTime($arrayPost['fechaFinIns']);
                    $fechaInicioReto = new DateTime($arrayPost['fechaInicioReto']);
                    $fechaFinReto = new DateTime($arrayPost['fechaFinReto']);
                    $fechaActual = new DateTime('now');
    
                    if ($fechaInicioInscripcion <= $fechaFinInscripcion && $fechaInicioInscripcion >= $fechaActual && $fechaInicioReto >= $fechaInicioInscripcion) $contador++;
                    else return -8;    // Error fecha inicio inscripción incorrecta.
    
                    if ($fechaInicioInscripcion <= $fechaFinInscripcion) $contador++;
                    else return -9;    // Error fecha fin inscripción incorrecta.
    
                    if ($fechaInicioReto <= $fechaFinReto && $fechaInicioReto >= $fechaInicioInscripcion) $contador++;
                    else return -10;    // Error fecha inicio reto incorrecta.
    
                    if ($fechaInicioReto <= $fechaFinReto) $contador++;
                    else return -11;    // Error fecha fin reto incorrecta.
    
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
                return -12;  // Error no ID
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