<?php
class DB{
  private static $p;
  static function pdo(){ if(!self::$p){ self::$p=new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8mb4',DB_USER,DB_PASS,[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC]); } return self::$p; }
  static function q($sql,$a=[]){ $s=self::pdo()->prepare($sql); $s->execute($a); return $s; }
}
