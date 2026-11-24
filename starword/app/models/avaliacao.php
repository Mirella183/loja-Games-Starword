<?php
class Avaliacao{
  static function doJogo($jogo){ return DB::q("SELECT a.*,u.nickname FROM Avaliacoes a JOIN Usuarios u USING(id_usuario) WHERE a.id_jogo=? ORDER BY a.data_avaliacao DESC,a.id_avaliacao DESC",[$jogo])->fetchAll(); }
  static function minha($uid,$jogo){ return DB::q("SELECT * FROM Avaliacoes WHERE id_usuario=? AND id_jogo=?",[$uid,$jogo])->fetch(); }
  static function possui($uid,$jogo){ return (bool)DB::q("SELECT 1 FROM Biblioteca WHERE id_usuario=? AND id_jogo=?",[$uid,$jogo])->fetch(); }
  static function salvar($uid,$jogo,$nota,$coment){
    DB::q("INSERT INTO Avaliacoes(id_usuario,id_jogo,nota,comentario,data_avaliacao) VALUES(?,?,?,?,CURDATE())
           ON DUPLICATE KEY UPDATE nota=VALUES(nota),comentario=VALUES(comentario),data_avaliacao=CURDATE()",[$uid,$jogo,$nota,$coment]); }
}