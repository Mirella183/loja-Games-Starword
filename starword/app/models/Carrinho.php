<?php
class Carrinho{
  static function id($u){ $c=DB::q("SELECT id_carrinho FROM Carrinho WHERE id_usuario=? ORDER BY id_carrinho LIMIT 1",[$u])->fetch();
    if($c) return $c['id_carrinho']; DB::q("INSERT INTO Carrinho(id_usuario) VALUES(?)",[$u]); return DB::pdo()->lastInsertId(); }
  static function itens($u){ return DB::q("SELECT i.id_item,i.quantidade,j.id_jogo,j.titulo,j.preco,(i.quantidade*j.preco) total FROM Carrinho_itens i JOIN Jogos j USING(id_jogo) WHERE i.id_carrinho=?",[self::id($u)])->fetchAll(); }
  static function add($u,$jogo){ $c=self::id($u); $i=DB::q("SELECT id_item FROM Carrinho_itens WHERE id_carrinho=? AND id_jogo=?",[$c,$jogo])->fetch();
    if($i) DB::q("UPDATE Carrinho_itens SET quantidade=quantidade+1 WHERE id_item=?",[$i['id_item']]); else DB::q("INSERT INTO Carrinho_itens(id_carrinho,id_jogo,quantidade) VALUES(?,?,1)",[$c,$jogo]); }
  static function alterar($u,$item,$delta){ $c=self::id($u); DB::q("UPDATE Carrinho_itens SET quantidade=quantidade+? WHERE id_item=? AND id_carrinho=?",[$delta,$item,$c]); DB::q("DELETE FROM Carrinho_itens WHERE quantidade<=0 AND id_carrinho=?",[$c]); }
  static function total($itens){ $t=0; foreach($itens as $i)$t+=$i['total']; return $t; }
}
