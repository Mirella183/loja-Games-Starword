<section class="pad"><h3>Pagamento 💳</h3><?php if($erro): ?><p class="err"><?=e($erro)?></p><?php endif; ?>
<form method="post" action="index.php?r=pagamento" class="checkout"><button class="hid" name="x" value="1"></button><input type="hidden" name="metodo" value="<?=e($metodo)?>">

<div class="left">
  <div class="panel blueP"><h6>👤 Dados do Comprador</h6>
    <label>Nome Completo<input class="in y" name="nome" value="<?=e($f['nome']??'')?>"></label>
    <label>E-mail<input class="in y" name="email" value="<?=e($f['email']??'')?>"></label>
    <label>Telefone<input class="in y" name="telefone" value="<?=e($f['telefone']??'')?>"></label>
  </div>

  <div class="panel blueP"><h6>💳 Forma de Pagamento</h6>
    <div class="methods">
      <?php foreach(['credito'=>'Cartão de Crédito','debito'=>'Cartão de Débito','pix'=>'PIX'] as $k=>$n): ?>
        <button class="mt" name="trocar" value="<?=$k?>"><i><?=$metodo===$k?'●':'○'?></i><?=$n?></button>
      <?php endforeach; ?>
    </div>

    <?php if($metodo==='pix'): ?>
      <div class="yinfo"><h6>Informações do Pix</h6>
        <label>Chave Pix<input class="in" name="chave" value="<?=e($f['chave']??'')?>"></label>
        <label>Nome do Cliente<input class="in" name="cliente" value="<?=e($f['cliente']??'')?>"></label>
        <div class="two">
          <label>Valor<input class="in" value="<?=brl($total)?>" readonly></label>
          <label>Tipo de chave<select class="in" name="tipo"><option value="">Selecione</option>
            <?php foreach(['CPF','CNPJ','Email','Telefone','Aleatória'] as $t) echo '<option'.(($f['tipo']??'')===$t?' selected':'').'>'.$t.'</option>'; ?>
          </select></label>
        </div>
      </div>

      <?php $temPix = defined('PIX_CHAVE') && function_exists('pixPayload'); ?>
      <?php if($temPix): $payload=pixPayload(PIX_CHAVE,PIX_NOME,PIX_CIDADE,$total); ?>
        <div class="qr">
          <div class="qrimg"><img src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=<?=urlencode($payload)?>" alt="QR Code Pix"></div>
          <div><b>ESCANEIE O QR CODE</b><br>Abra o app do seu banco, escaneie e pague.<br><br>O pagamento é aprovado em poucos segundos!
            <input class="in" readonly value="<?=e($payload)?>" style="font-size:10px;margin-top:8px"></div>
        </div>
      <?php else: ?>
        <div class="qr">
          <div class="qrimg">colocar imagem (QR Code)</div>
          <div><b>ESCANEIE O QR CODE</b><br>Abra o app do seu banco, escaneie e pague.<br><br>O pagamento é aprovado em poucos segundos!</div>
        </div>
      <?php endif; ?>

    <?php else: ?>
      <div class="yinfo"><h6>Informações do Cartão</h6>
        <label>Número do cartão<input class="in" name="cartao" maxlength="19" placeholder="0000 0000 0000 0000" value="<?=e($f['cartao']??'')?>"></label>
        <div class="three">
          <label>Nome do Cartão<input class="in" name="nomecartao" value="<?=e($f['nomecartao']??'')?>"></label>
          <label>Validade<input class="in" name="validade" placeholder="DD/MM/AAAA" value="<?=e($f['validade']??'')?>"></label>
          <label>CVV<input class="in" name="cvv" maxlength="4" placeholder="---"></label>
        </div>
      </div>
    <?php endif; ?>
  </div>
</div>

<div class="right">
  <div class="resumo"><h6>🛒 Resumo do Pedido</h6>
    <table class="tbl small"><tr><th>Produto</th><th>QTD</th><th>TOTAL</th></tr>
    <?php foreach($itens as $i): ?>
      <tr><td><?=foto($i['id_jogo'])?> <?=e($i['titulo'])?></td><td><?=$i['quantidade']?></td><td><?=brl($i['total'])?></td></tr>
    <?php endforeach; ?>
    <tr class="g"><td colspan="2">SUBTOTAL</td><td><?=brl($total)?></td></tr>
    <tr class="g"><td colspan="2">TOTAL</td><td><?=brl($total)?></td></tr></table>
  </div>
  <a class="btn purplebtn blk" href="index.php?r=carrinho">⟵ VOLTAR AO CARRINHO</a>
  <button class="btn purplebtn blk" name="finalizar" value="1">🔒 FINALIZAR PAGAMENTO</button>
</div>

</form></section>