<?php
    use Shuchkin\SimpleXLSX;
    require_once(dirname(__DIR__) . '/model/modelodb.php');
    require_once(dirname(__DIR__) . '/simplexlsx/SimpleXLSX.php');

    /**
     * Clase para sacar datos de profesores de una hoja de cálculo, e importar los datos a la BBDD.
     */
    class InsercionProfesores
    {
        private $conexion;
        private $nombres;
        private $correos;
        private $passwords;

        /**
         * Obtener la conexión con la BBDD.
         */
        public function obtenerConexion()
        {
            $objConexion = new ModeloDB();
            $this->conexion = $objConexion->conexion;
        }

        /**
         * Extrae los nombres, correos y contraseñas de los profesores de la hoja de cálculo,
         * llama al proceso de inserción en caso de que la extracción sea correcta.
         */
        public function sacarDatos()
        {
            try 
            {
                $this->nombres = array();
                $this->correos = array();
                $this->passwords = array();
        
                if (!empty($_FILES))
                {
                    if (isset($_FILES['subida']) )
                    {
                        // Comprobar que la extensión del archivo sea .xls o .xlsx
                        $extension = pathinfo($_FILES['subida']['name'], PATHINFO_EXTENSION);
                        
                        if ($extension == 'xls' || $extension == 'xlsx')
                        {
                            // Realizar extracción de datos
                            $xlsx = new SimpleXLSX($_FILES['subida']['tmp_name']);     
                        
                            foreach($xlsx->rows() as $row)
                            {
                                if (!empty($row[0])) array_push($this->nombres, $row[0]);
                                if (!empty($row[1])) array_push($this->correos, $row[1]);
                                if (!empty($row[2])) array_push($this->passwords, $row[2]);
                            }

                            return 1;
                            //return $this->insercionProfesores();
                        }
                        else
                        {
                            return -2;  // Error: Formato no válido
                        }
                    }
                    else
                    {
                        return -1;  // Error: No se ha subido nada
                    }
                }
                else
                {
                    return 0;
                }
            }
            catch(mysqli_sql_exception $e)
            {
                return $e->getCode();
            }
        }
       
        /**
         * Realiza el proceso de inserción con los datos que se han obtenido.
         * @return int Nº del resultado del proceso.
         */
        public function insercionProfesores()
        {
            try 
            {
                // Verificar que todos los arrays tengan la misma longitud.
                if((count($this->nombres) == count($this->correos)) && (count($this->correos) == count($this->passwords)))
                {
                    $this->obtenerConexion();

                    if($this->conexion != null)
                    {
                        $sql = "INSERT INTO profesores(nombre, correo, contrasenia) VALUES(?, ?, ?)";
                        $consulta = $this->conexion->prepare($sql);
                
                        $nombre = '';
                        $correo = '';
                        $password = '';
                
                        $consulta->bind_param('sss', $nombre, $correo, $password);
                
                        for($i=0; $i<count($this->nombres); $i++) 
                        {
                            $nombre = $this->nombres[$i];
                            $correo = $this->correos[$i];
                            $password = password_hash($this->passwords[$i], PASSWORD_DEFAULT, ['cost' => 15]);
                
                            $consulta->execute();
                        }

                        $consulta->close();
                        $this->conexion->close();

                        return 1;
                    }
                    else
                    {
                        return -3;  // Error: No conexión.
                    }
                }
                else
                {
                    return -4;  // Error: Arrays no coinciden.
                }
            }
            catch(mysqli_sql_exception $e) 
            {
                return $e->getCode();
            }
        }
    }
?>