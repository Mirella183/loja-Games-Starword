<?php $metodos=['cartao'=>'Cartão','pix'=>'Pix','boleto'=>'Boleto']; ?>
<div class="nota">
  <div class="nota-topo">
    <img src="img/logo.png" alt="StarWord">
    <div><h3>StarWord</h3><small>Loja on-line de jogos</small></div>
    <div class="nota-num">COMPROVANTE DE COMPRA<br><b>Nº <?=str_pad($p['id_pedido'],6,'0',STR_PAD_LEFT)?></b></div>
  </div>

  <div class="nota-bloco">
    <div><b>Cliente:</b> <?=e($cli['nickname'])?></div>
    <div><b>E-mail:</b> <?=e($cli['email'])?></div>
    <div><b>Data da compra:</b> <?=e(date('d/m/Y',strtotime($p['data_pedido'])))?></div>
    <div><b>Pagamento:</b> <?=e($metodos[$pg['metodo']??'']??'—')?> — <?=e(ucfirst($pg['status']??$p['status']))?></div>
  </div>

  <table class="nota-tab">
    <tr><th>Item</th><th>Qtd</th><th>Valor unit.</th><th>Total</th></tr>
    <?php foreach($itens as $i): ?>
    <tr><td><?=e($i['titulo'])?></td><td><?=$i['quantidade']?></td><td><?=brl($i['preco'])?></td><td><?=brl($i['total'])?></td></tr>
    <?php endforeach; ?>
    <tr class="nota-total"><td colspan="3">TOTAL PAGO</td><td><?=brl($p['valor_total'])?></td></tr>
  </table>

  <p class="nota-aviso">Documento sem valor fiscal. Os jogos já estão disponíveis em Minha Biblioteca.<br>Obrigado por comprar na StarWord!</p>
</div>