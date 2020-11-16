<?php
namespace App\Core;

use Exception;
use InvalidArgumentException;
use PDOException;
use PDOStatement;
use LogicException;
use PDO;


class DB
{
    private static PDO $connect;                

    
    private static string $host;
    private static string $user;
    private static string $pass;
    private static string $database;
    private static string $DBMS;
             
    /**
     * Initialisation
     */
    public static function setup()
    {  
        try {
            self::config();
            self::connect();
        } catch (InvalidArgumentException $e) {
            return false;
        } catch (Exception $e) {
            return false;
        }
        return true;
    }
 
    /**
     * SELECT query
     * 
     */
    public static function select(string $script, array $params = [], string $type = null): ?object
    {                       
        if (($result = self::import($script, $params, $type)) == []) 
            return null;
        return $result[0];               
    }
    
    /**
     * SELECT query
     * 
     * Mindig tömbbel tér vissza, hogy loopolható maradjon.
     */
    public static function selectAll(string $script, array $params = [], string $type = null): array
    {               
        return self::import($script, $params, $type);
       
    }

    /**
     * import function abstraction
     * 
     */
    protected static function import(string $script, array $params = [], string $type = null): array
    {
        $smt =  self::$connect->prepare($script);          
        self::binds($smt, $params);           
                
        try {
            if(!$smt->execute())            
                throw new PDOException($smt->errorInfo()[2]);
            if ($type)
                $result = $smt->fetchAll(PDO::FETCH_CLASS, $type);
            else 
                $result = $smt->fetchAll(PDO::FETCH_CLASS);
            $smt = null;     

            return $result;            
        } catch( PDOException $e ) {                 
            $statement = null;
            return [];
        } 
    }

    /**
     * EXECUTE query
     * @throws LogicException   Logikai hiba esetén
     */
    public static function execute( string $script, array $params = [] )
    {                    
        try {
            // Prepare PDOStatement object
            $smt =  self::$connect->prepare($script);
            
            self::binds($smt, $params); 

            // Ha nem sikerül végrehajtani a kódot, az csakis az érvénytelen paraméterezés
            // miatt fordulhat elő.
            if (!$smt->execute())
                throw new LogicException(
                    "Message: ".$smt->errorInfo()[2].
                    " Errorcode: ".$smt->errorInfo()[1]);                                                 

        } catch (PDOException $exception) {
            $smt = null;                          
            throw $exception;
        } catch (LogicException $exception) {
            $smt = null;                        
            throw $exception;
        }

    }
    
    /**
     * Binding parameters by reference
     */
    private static function binds(PDOStatement $pdoStatement, array $params)
    {
        $keys = array_keys($params);
  
        for ($i=0; $i < count( $keys ); $i++) { 
            if ( $keys[$i] === ':limit' || $keys[$i] === ':offset' )
                $pdoStatement->bindParam( $keys[$i], $params[$keys[$i]], PDO::PARAM_INT );
            else
                $pdoStatement->bindParam( $keys[$i], $params[$keys[$i]] );
        } 
    }
    
    /**
     * Get PDO Connection
     */
    private static function connect()
    {            
        try {                 
            self::$connect = new PDO( 
                self::$DBMS.":host=".self::$host.";dbname=".self::$database.";charset=utf8", 
                self::$user, 
                self::$pass,
                // ATTR_PERSISTENT -> állandó adatbázis kapcsolat fenntartása új 
                // szálak generálása helyett. Gyorsabb.
                [PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION]
            );                        
        } catch(PDOException $e) {
            throw $e;
        }
    }

    /**
     * Load configuration to connect database
     * @throws InvalidArgumentException
     */
    private static function config()
    {
        $params = json_decode(file_get_contents("config/dbconfig.json"), true);

        if (!$params)
            throw new InvalidArgumentException('Can\'t access /config.json file!!');

        extract($params);

        self::$host     = $hostName;
        self::$user     = $userName;
        self::$pass     = $password;
        self::$database = $database;
        self::$DBMS     = $DBMS;
    }
}