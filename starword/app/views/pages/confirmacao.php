<section class="pad center conf">
<div class="check">✔</div>
<h4 class="ok">PEDIDO REALIZADO COM SUCESSO!</h4>
<p class="ok2">Obrigado por comprar na StarWord.<br>Seu pedido foi registrado com sucesso.</p>
<div class="num"><small>Número do Pedido</small><br><b>#<?=str_pad($p['id_pedido'],6,'0',STR_PAD_LEFT)?></b></div>

<table class="tbl cart">
<tr><th colspan="3" class="ytitle">Resumo do Pedido</th></tr>
<tr><th>Produto</th><th>Quantidade</th><th>TOTAL</th></tr>
<?php foreach($itens as $i): ?>
<tr><td><?=foto($i['id_jogo'])?> <b><?=e($i['titulo'])?></b></td><td><?=$i['quantidade']?></td><td><?=brl($i['total'])?></td></tr>
<?php endforeach; ?>
<tr><td colspan="2" class="right ok">TOTAL PAGO</td><td><?=brl($p['valor_total'])?></td></tr>
</table>

<h5>Nota da compra</h5>
<?php include __DIR__.'/_nota.php'; ?>

<p><a class="btn purplebtn" href="index.php?r=nota&id=<?=$p['id_pedido']?>" target="_blank">🖨 ABRIR PARA IMPRIMIR</a>
<a class="btn cyan" href="index.php">🛒 IR PARA O INÍCIO</a></p>
</section>