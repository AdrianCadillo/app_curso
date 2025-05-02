<?php
namespace src\orm;

interface Orm{

    /** OBTENER LOS DATOS */
    public static function get();

    /** SELECCIONAR QUE COLUMNAS DESEAMOS VISUALIZAR EN LAS
     * CONSULTAS
     */
    public static function select();

    /**
     * METODO WHERE 
     */
    public static function Where(String $Columna,String $operador,$Value);

     /** METODO AND */
    public static function And(String $Columna,String $operador,$Value);
     /** METODO OR */
     public static function Or(String $Columna,String $operador,$Value);
     /** create */
     public static function create(array $datos);

     /** updated */
     public static function Update(array $datos);
     /** delete */
     public static function delete($id);
     /** procedimientos almacenados */

     /** CASOS DE TABLAS RELACIONADOS => INNER JOIN LEFT JOIN RIGHT JOIN */
     public static function Join(String $TFK,String $ColumnaFK,String $operador,String $ColumnaPK);

     public static function LeftJoin(String $TFK,String $ColumnaFK,String $operador,String $ColumnaPK);

     public static function RightJoin(String $TFK,String $ColumnaFK,String $operador,String $ColumnaPK);

     public static function procedure(String $NameProcedure,String $Evento,array $datos=[]);
     
}

 