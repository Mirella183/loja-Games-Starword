<?php
class Admin{
  static function todos(){ return DB::q("SELECT a.id_admin,a.ativo,a.cpf,a.telefone,u.nickname,u.email FROM Administradores a JOIN Usuarios u USING(id_usuario) ORDER BY a.id_admin")->fetchAll(); }
  static function find($id){ return DB::q("SELECT a.id_admin,a.id_usuario,a.cpf,a.telefone,u.nickname,u.email FROM Administradores a JOIN Usuarios u USING(id_usuario) WHERE a.id_admin=?",[$id])->fetch(); }

  static function criar($nick,$email,$cpf,$tel){ $p=DB::pdo(); $p->beginTransaction();
    try{
      $uid=Usuario::criar($nick,$email,'starword123','2000-01-01');
      DB::q("INSERT INTO Administradores(id_usuario,cpf,telefone) VALUES(?,?,?)",[$uid,$cpf,$tel]);
      $p->commit();
    }catch(Exception $e){ $p->rollBack(); throw $e; } }

  static function editar($id,$nick,$email,$cpf,$tel){ $a=self::find($id);
    DB::q("UPDATE Usuarios SET nickname=?,email=? WHERE id_usuario=?",[$nick,$email,$a['id_usuario']]);
    DB::q("UPDATE Administradores SET cpf=?,telefone=? WHERE id_admin=?",[$cpf,$tel,$id]); }

  static function alternar($id){ DB::q("UPDATE Administradores SET ativo=NOT ativo WHERE id_admin=?",[$id]); }

  static function promover($login){
    $u=DB::q("SELECT id_usuario FROM Usuarios WHERE nickname=? OR email=?",[$login,$login])->fetch();
    if(!$u) return 'Usuário não encontrado.';
    $a=DB::q("SELECT id_admin,ativo FROM Administradores WHERE id_usuario=?",[$u['id_usuario']])->fetch();
    if($a){ if($a['ativo']) return 'Esse usuário já é administrador.'; DB::q("UPDATE Administradores SET ativo=1 WHERE id_admin=?",[$a['id_admin']]); return null; }
    DB::q("INSERT INTO Administradores(id_usuario) VALUES(?)",[$u['id_usuario']]); return null;
  }

  static function cpfValido($c){
    if(!preg_match('/^\d{11}$/',$c)||preg_match('/^(\d)\1{10}$/',$c)) return false;
    for($t=9;$t<11;$t++){ $s=0; for($i=0;$i<$t;$i++) $s+=$c[$i]*(($t+1)-$i); $d=((10*$s)%11)%10; if($c[$t]!=$d) return false; }
    return true;
  }
  static function fmtCpf($c){ return strlen((string)$c)===11 ? substr($c,0,3).'.'.substr($c,3,3).'.'.substr($c,6,3).'-'.substr($c,9) : '—'; }
  static function fmtTel($t){ $t=(string)$t; if(strlen($t)===11) return '('.substr($t,0,2).') '.substr($t,2,5).'-'.substr($t,7);
    if(strlen($t)===10) return '('.substr($t,0,2).') '.substr($t,2,4).'-'.substr($t,6); return '—'; }
}