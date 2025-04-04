<?php 
namespace src\orm;

use src\orm\database\Conexion;

class Model extends Conexion implements Orm{

    /**
     * PROPIEDADES
     */
    protected static String $Table;

    /** PARA CONSULTAR DATOS */
    public static function get(){
        self::initQuery();
         
        try {
            self::$pps = self::getConexion()->prepare(self::$Query);
            /// ejecutamos la consulta
            self::$pps->execute();

            return self::$pps->fetchAll(\PDO::FETCH_OBJ);
        } catch (\Throwable $th) {
            echo "<h1 style='color:red'>".$th->getMessage()."</h1>";
            exit;   
        }finally{
            self::closeConection();
        }
         
    }

     /** SELECCIONAR COLUMNAS  select("descripcion","stock","id")
      *select columna1,column2 from tabla; 

     */
     public static function select(){
        self::initQuery();
        $columnas = func_get_args();
        $columnas = implode(",",$columnas);
        self::$Query = str_replace("*",$columnas,self::$Query);

        return new self;
     }


     /// para Verificar la existencia de la INICIALIZACION DE LA QUERY
     private static function initQuery(){
       if(empty(self::$Query)){
        self::getTableClassModel();
        self::$Query = "SELECT * FROM ".static::$Table;
       }
     }

    /// para convetir la clase model a la tabla
    private static function getTableClassModel(){
        if(empty(static::$Table)){
            static::$Table = strtolower(explode("\\",get_class(new static))[2])."s";
        }
    }
}
