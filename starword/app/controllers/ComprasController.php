<?php
class ComprasController extends Controller{
  function lista(){
    $this->auth();
    $pedidos=DB::q("SELECT p.id_pedido,p.data_pedido,p.valor_total,p.status,GROUP_CONCAT(DISTINCT j.titulo SEPARATOR ', ') itens
      FROM Pedidos p LEFT JOIN Pedido_itens i USING(id_pedido) LEFT JOIN Jogos j USING(id_jogo)
      WHERE p.id_usuario=? GROUP BY p.id_pedido ORDER BY p.id_pedido DESC",[$this->user()['id']])->fetchAll();
    $this->view('compras',compact('pedidos'));
  }
}