<?php
class Pedido{
  static function criar($u,$itens,$total,$metodo){ $p=DB::pdo(); $p->beginTransaction();
    try{
      DB::q("INSERT INTO Pedidos(id_usuario,data_pedido,valor_total,status) VALUES(?,CURDATE(),?,'pago')",[$u,$total]); $id=$p->lastInsertId();
      foreach($itens as $i){ for($k=0;$k<$i['quantidade'];$k++) DB::q("INSERT INTO Pedido_itens(id_pedido,id_jogo,preco_unitario) VALUES(?,?,?)",[$id,$i['id_jogo'],$i['preco']]);
        if(!DB::q("SELECT 1 FROM Biblioteca WHERE id_usuario=? AND id_jogo=?",[$u,$i['id_jogo']])->fetch()) DB::q("INSERT INTO Biblioteca(id_usuario,id_jogo,data_compra) VALUES(?,?,CURDATE())",[$u,$i['id_jogo']]); }
      DB::q("INSERT INTO Pagamentos(id_pedido,data_pagamento,metodo,status) VALUES(?,CURDATE(),?,'aprovado')",[$id,$metodo]);
      DB::q("DELETE FROM Carrinho_itens WHERE id_carrinho=?",[Carrinho::id($u)]);
      $p->commit(); return $id;
    }catch(Exception $e){ $p->rollBack(); throw $e; } }
  static function find($id,$u){ return DB::q("SELECT * FROM Pedidos WHERE id_pedido=? AND id_usuario=?",[$id,$u])->fetch(); }
   static function itens($id){ return DB::q("SELECT j.id_jogo,j.titulo,i.preco_unitario preco,COUNT(*) quantidade,SUM(i.preco_unitario) total FROM Pedido_itens i JOIN Jogos j USING(id_jogo) WHERE i.id_pedido=? GROUP BY j.id_jogo,j.titulo,i.preco_unitario",[$id])->fetchAll(); }
  static function pagamento($id){ return DB::q("SELECT * FROM Pagamentos WHERE id_pedido=? ORDER BY id_pagamento DESC LIMIT 1",[$id])->fetch(); }
}