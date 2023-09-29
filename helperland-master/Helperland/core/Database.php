<?php

namespace core;

use \PDO;
use \Exception;

use core\Response;

class Database{

    private $conn    = null;    
    private $res     = null;
    private $query   = '';
    private $columns = '*';
    private $where   = '';
    private $join    = '';
    protected $table = '';

    public function __construct(){
        $this->res = new Response();
        $this->connect();
    }

    // ----------CONNECT------------
    public function connect(){
        $dbType     = DB_TYPE;
        $dbHost     = DB_HOST;
        $dbUser     = DB_USER;
        $dbPassword = DB_PASSWORD;
        $dbName     = DB_NAME;
        $dsn        = "{$dbType}:host={$dbHost};dbname={$dbName}";
        try{
            $this->conn = new PDO($dsn, $dbUser, $dbPassword);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } 
        catch(Exception $e){
            $this->res->status(500)->json(['message'=>'Database connection issue!']);
            exit();
        }
    }

    // ----------TABLE------------
    public function table($name){
        $this->table = $name;
        return $this;
    }

    // ----------CREATE------------
    public function create($arr){
        $keys = '(';
        $values = '(';
        foreach($arr as $key => $value){
            // FOR AVOID XSS...
            $value = htmlspecialchars($value);
            $keys .= $key.', ';
            if(is_integer($value) || !is_string($value)){
                $values .= "{$value}, ";
            }
            else if(is_string($value)){
                $values .= "'{$value}', ";
            }
            else{
                $values .= "null, ";
            }
        }
        $keys = rtrim($keys, ', ');
        $values = rtrim($values, ', ');
        $keys .= ')';
        $values .= ')';
        try{
            $this->query = "INSERT INTO {$this->table} {$keys} VALUES {$values}";
            if($this->conn->exec($this->query)){
                // RETURN INSERTED ID...
                return $this->conn->lastInsertId();                
            }
            else{
                return false;
            }
        }
        catch(Exception $e){
            $this->res->status(500)->json(['message'=>'Internal server error', 'errors'=>$e->getMessage()]);
            exit();
        }
    }

    // ----------WHERE------------
    public function where($key, $operator=false, $value=false){
        if($operator!=false && $value!=false){
            // IF WE PASS ALL THREE PARAMETERS... [KEY, OPERATOR, VALUE]
            if(is_integer($value) || !is_string($value)){
                $this->where = "WHERE {$key} {$operator} {$value}";
            }
            else if(is_string($value)){
                $this->where = "WHERE {$key} {$operator} '{$value}' ";
            }
        }
        else{
            // FOR CUSTOM WHERE CONDITION...
            $this->where = 'WHERE '.$key;
        }
        return $this;
    }

    // ----------EXISTS------------
    public function exists(){
        $this->query = "SELECT * FROM {$this->table} {$this->where}";
        try{
            $result = $this->conn->query($this->query);
            $data = $result->fetchAll(PDO::FETCH_ASSOC);
            if(count($data) >= 1){
                return true;
            }
            else{
                return false;
            }
        }
        catch(Exception $e){
            $this->res->status(500)->json(['message'=>'Internal server error', 'errors'=>$e->getMessage()]);
            exit();
        }
    }

    // ----------COLUMN------------
    public function columns($columns){
        if(isset($columns) && !empty($columns)){
            // FIRST REMOVE THE ALL COLUMNS...
            $this->columns = '';
            foreach($columns as $column){
                $this->columns .= $column.', ';
            }
            $this->columns = rtrim($this->columns, ', ');
        }
        return $this;
    }

    // ----------QUERY------------
    public function query($sql){
        try{
            if(str_contains($sql, 'SELECT')){
                $result = $this->conn->query($sql);
                $data = $result->fetchAll(PDO::FETCH_ASSOC);
                return json_decode(json_encode($data));
                // RETURN ARRAY OF AN OBJECT...    
            }
            else{
                return $this->conn->exec($sql);
            }
        }
        catch(Exception $e){
            $this->res->status(500)->json(['message'=>'Internal server error', 'errors'=>$e->getMessage()]);
            exit();
        }
    }
    
    // ----------JOIN------------
    public function join($pk, $fk, $table, $joinType=false){
        $joinType = $joinType==false ? 'INNER' : $joinType;
        $this->join = "{$joinType} JOIN {$table} ON {$this->table}.{$pk}={$table}.{$fk}";
        return $this;
    }

    // ----------READ------------
    public function read(){
        try{
            $this->query = "SELECT {$this->columns} FROM {$this->table} {$this->join} {$this->where}";
            $result = $this->conn->query($this->query);            
            $data = $result->fetchAll(PDO::FETCH_ASSOC);
            return json_decode(json_encode($data));
            // RETURN ARRAY OF AN OBJECT...
        }
        catch(Exception $e){
            $this->res->status(500)->json(['message'=>'Internal server error', 'errors'=>$e->getMessage()]);
            exit();
        }
    }

    // ----------UPDATE------------
    public function update($arr){
        $updateString = '';
        foreach($arr as $key => $value){
            if(is_integer($value) || !is_string($value)){
                $updateString .= "{$key} = {$value}, ";
            }
            else if(is_string($value)){
                $updateString .= "{$key} = '{$value}', ";
            }
        }
        $updateString = rtrim($updateString, ', ');
        try{
            $this->query = "UPDATE {$this->table} SET {$updateString} {$this->where}";
            return $this->conn->exec($this->query);
        }
        catch(Exception $e){
            $this->res->status(500)->json(['message'=>'Internal server error', 'errors'=>$e->getMessage()]);
            exit();
        }
    }

    // ----------DELETE------------
    public function delete(){
        try{
            $this->query = "DELETE FROM {$this->table} {$this->where}";
            return $this->conn->exec($this->query);    
        }
        catch(Exception $e){
            $this->res->status(500)->json(['message'=>'Internal server error', 'errors'=>$e->getMessage()]);
            exit();
        }
    }

    // ----------SEARCH------------
    public function search(){
        // SOON
    }

    public function __destruct(){
        $this->conn = null;
        // echo "Database Disconnected";
    }

}