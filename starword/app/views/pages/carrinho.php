<section class="pad"><h3>Meu Carrinho</h3>
<table class="tbl cart"><tr><th>Produto</th><th>Preço</th><th>Quantidade</th><th>TOTAL</th></tr>
<?php foreach($itens as $i): ?><tr><td><?=foto($i['id_jogo'])?> <b><?=e($i['titulo'])?></b></td><td><?=brl($i['preco'])?></td>
<td><form class="qty" method="post" action="index.php?r=carrinho_alt"><input type="hidden" name="id_item" value="<?=$i['id_item']?>"><button name="delta" value="-1">⊖</button><span style="background:#6A1FAD;color:#fff;font-weight:700;min-width:40px;text-align:center;padding:5px 14px;border-radius:4px"><?=$i['quantidade']?></span><button name="delta" value="1">⊕</button></form></td><td><?=brl($i['total'])?></td></tr><?php endforeach; ?>
<?php if(!$itens): ?><tr><td colspan="4">Seu carrinho está vazio.</td></tr><?php endif; ?></table>
<table class="sum"><tr><th>SUBTOTAL</th><td><?=brl($total)?></td></tr><tr><th>TOTAL</th><td><b><?=brl($total)?></b></td></tr></table>
<div class="actions"><a class="btn purplebtn" href="index.php">ESCOLHER MAIS PRODUTOS</a><?php if($itens): ?><a class="btn purplebtn" href="index.php?r=pagamento">🛒 FECHAR PEDIDO</a><?php endif; ?></div></section>