<section class="pad"><h3>Minhas Compras</h3>
<table class="tbl small">
<tr><th>Pedido</th><th>Data</th><th>Jogos</th><th>Total</th><th>Status</th><th>Nota</th></tr>
<?php foreach($pedidos as $p): ?>
<tr><td>#<?=str_pad($p['id_pedido'],6,'0',STR_PAD_LEFT)?></td>
<td><?=e(date('d/m/Y',strtotime($p['data_pedido'])))?></td>
<td><?=e($p['itens'])?></td>
<td><?=brl($p['valor_total'])?></td>
<td><?=e(ucfirst($p['status']))?></td>
<td><a class="btn purplebtn" href="index.php?r=nota&id=<?=$p['id_pedido']?>" target="_blank">🖨 Ver nota</a></td></tr>
<?php endforeach; ?>
<?php if(!$pedidos): ?><tr><td colspan="6">Você ainda não fez nenhuma compra.</td></tr><?php endif; ?>
</table>
<p><a class="btn cyan" href="index.php">Voltar</a> <a class="btn green" href="index.php?r=biblioteca">Minha Biblioteca</a></p></section>