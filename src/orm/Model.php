<?php 
namespace src\orm;

use src\orm\database\Conexion;

class Model extends Conexion implements Orm{

    /**PROPIEDADES */
    private static array $Values = [];
    protected static String $Alias ;
    protected static String $primaryKey='id';
    protected static String $Table;
    /** OBTENER LOS DATOS */
    public static function get(){
        self::getTableClassName();
        self::initQuery();
 
        try {
           self::$pps = self::getConexion()->prepare(self::$Query);

           if(count(self::$Values) > 0){
             for($i = 0; $i<count(self::$Values);$i++){
                self::$pps->bindValue(($i+1),self::$Values[$i]);
             }
           }
           /// ejecutamos la consulta
           self::$pps->execute();

           return self::$pps->fetchAll(\PDO::FETCH_OBJ);

        } catch (\Throwable $th) {
            echo "<h1 style='color:red'>".$th->getMessage()."</h1>";
            exit;
        }finally{
            self::closeConection();
            self::$Values =[];
            self::$Query="";
        }
    }

    /** SELECCIONAR QUE COLUMNAS DESEAMOS VISUALIZAR EN LAS
     * CONSULTAS
     */
    public static function select(){
        self::getTableClassName();
        self::initQuery();
        $columnas = func_get_args();
        $columnas = implode(",",$columnas);

        self::$Query = str_replace("*",$columnas,self::$Query);
        

        return new self;
    }

    /**
     * METODO WHERE 
     */
    public static function Where(String $Columna,String $operador,$Value)
    {
        self::getTableClassName();
        self::initQuery();

        self::$Query.= " WHERE ".$Columna." ".$operador." ? ";
        self::$Values[] = $Value;

        return new self;
    }

     /** METODO AND */
     public static function And(String $Columna,String $operador,$Value){
        self::getTableClassName();
        self::initQuery();

        self::$Query.= " AND ".$Columna.$operador." ? ";
        self::$Values[] = $Value;

        return new self;
     }
    /** METODO OR */
    public static function Or(String $Columna,String $operador,$Value){
        self::getTableClassName();
        self::initQuery();

        self::$Query.= " OR ".$Columna.$operador." ? ";
        self::$Values[] = $Value;

        return new self;
    }

     /** create 
      * ["clave" => valor]
      [
      "nombre" => valor1,
      "precio" => 23
      ]
      insert into tabla
     */
     public static function create(array $datos){
        self::getTableClassName();
        self::$Query = "INSERT INTO ".static::$Table."(";

        foreach($datos as $atributo => $value){
            self::$Query.=$atributo.",";
        }

        self::$Query = rtrim(self::$Query,",").") VALUES(";

        foreach($datos as $atributo => $value){
            self::$Query.=":$atributo,";
        }

        self::$Query = rtrim(self::$Query,",").")";

        try {
          self::$pps = self::getConexion()->prepare(self::$Query);
          foreach($datos as $atributo => $value){
            self::$pps->bindValue(":$atributo",$value);
          }

          return self::$pps->execute();
        } catch (\Throwable $th) {
            return false;
        
        }finally{
            self::closeConection();
            self::$Query="";
        }

     }
  /** delete */
  public static function delete($id){

      self::getTableClassName();
      self::$Query = "DELETE FROM ".static::$Table." WHERE ".static::$primaryKey."=:".static::$primaryKey;

      try {
        self::$pps = self::getConexion()->prepare(self::$Query);
        self::$pps->bindParam(":".static::$primaryKey,$id);

        return self::$pps->execute();
      } catch (\Throwable $th) {
          echo "<h1 style='color:red'>".$th->getMessage()."</h1>";
          exit;
      }finally{
          self::closeConection();
      }
  }
      /** updated
       * 
       * update tabla set columna=:columna,columna1=:columna1
       * [
       *  "id" => 1,
       *  "nombre" => valor
       * ]
       */
      public static function Update(array $datos){
        self::getTableClassName();

        self::$Query = "UPDATE ".static::$Table." SET ";

        foreach($datos as $atributo => $value){

            if($atributo != array_key_first($datos)){
            self::$Query.=$atributo."=:$atributo,";
            }
        }

        self::$Query = rtrim(self::$Query,",")." WHERE ".array_key_first($datos)."=:".array_key_first($datos);

        try {
            self::$pps = self::getConexion()->prepare(self::$Query);
            foreach($datos as $atributo => $value){
              self::$pps->bindValue(":$atributo",$value);
            }
  
            return self::$pps->execute();
          } catch (\Throwable $th) {
              echo "<h1 style='color:red'>".$th->getMessage()."</h1>";
              exit;
          }finally{
              self::closeConection();
          }
      }

       /** CASOS DE TABLAS RELACIONADOS => INNER JOIN LEFT JOIN RIGHT JOIN */
     public static function Join(String $TFK,String $ColumnaFK,String $operador,String $ColumnaPK){
        self::getTableClassName();
        self::initQuery();

        self::$Query.= " INNER JOIN ".$TFK." ON ".$ColumnaFK.$operador.$ColumnaPK;

        return new self;
     }

     public static function LeftJoin(String $TFK,String $ColumnaFK,String $operador,String $ColumnaPK){
        self::getTableClassName();
        self::initQuery();

        self::$Query.= " LEFT JOIN ".$TFK." ON ".$ColumnaFK.$operador.$ColumnaPK;

        return new self;
     }

     public static function RightJoin(String $TFK,String $ColumnaFK,String $operador,String $ColumnaPK){
        self::getTableClassName();
        self::initQuery();

        self::$Query.= " RIGHT JOIN ".$TFK." ON ".$ColumnaFK.$operador.$ColumnaPK;

        return new self;
     }
    /**
     *  Verificar si la Query esta vacia y asignar el nombre de la tabla
     * a la clase modelo
     */
    private static function getTableClassName(){

        if(empty(static::$Table)){
            static::$Table = strtolower(explode("\\",get_class(new static))[2])."s";
        } 
    }

    /**
     * Inicializar la query
     */
    private static function initQuery(){
        if(empty(self::$Query)){
            self::$Query = "SELECT * FROM ".static::$Table." as ".static::$Alias;
        }
    }
}