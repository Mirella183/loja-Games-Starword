<?php
class Usuario{
  static function login($id){ return DB::q("SELECT * FROM Usuarios WHERE (nickname=? OR email=?) AND status='ativo'",[$id,$id])->fetch(); }
  static function find($id){ return DB::q("SELECT * FROM Usuarios WHERE id_usuario=?",[$id])->fetch(); }
  static function existe($nick,$email,$ignorar=0){ return DB::q("SELECT 1 FROM Usuarios WHERE (nickname=? OR email=?) AND id_usuario<>?",[$nick,$email,$ignorar])->fetch(); }
  static function criar($nick,$email,$senha,$nasc){ DB::q("INSERT INTO Usuarios(nickname,email,senha,data_nascimento) VALUES(?,?,?,?)",[$nick,$email,password_hash($senha,PASSWORD_DEFAULT),$nasc]); return DB::pdo()->lastInsertId(); }
  static function atualizar($id,$nick,$senha=null){ DB::q("UPDATE Usuarios SET nickname=? WHERE id_usuario=?",[$nick,$id]); if($senha) DB::q("UPDATE Usuarios SET senha=? WHERE id_usuario=?",[password_hash($senha,PASSWORD_DEFAULT),$id]); }
  static function ehAdmin($id){ return (bool)DB::q("SELECT 1 FROM Administradores WHERE id_usuario=? AND ativo=1",[$id])->fetch(); }
}
