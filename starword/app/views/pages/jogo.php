<?php
$gratis=((float)$j['preco']<=0);
$im=capa($j['id_jogo']);
$m=$nota['t']?(float)$nota['m']:null;
if($m===null){ $rot='Sem avaliações'; $cor='#b9a6cf'; }
elseif($m>=4.5){ $rot='Muito positivas'; $cor='#FFD966'; }
elseif($m>=3.5){ $rot='Positivas'; $cor='#FFD966'; }
elseif($m>=2.5){ $rot='Mistas'; $cor='#d9b98a'; }
else{ $rot='Negativas'; $cor='#f08a6a'; }
?>
<style>
.sj{background:#3a1060;color:#e8dcf5;border-radius:6px;padding:22px 26px 30px;max-width:1040px;margin:20px auto;box-shadow:0 4px 18px rgba(0,0,0,.35);font-size:14px}
.sj a{color:#FFD966}
.sj-cam{font-size:12px;color:#b9a6cf;margin-bottom:6px}
.sj-cam a{color:#b9a6cf}.sj-cam a:hover{color:#fff}
.sj h1{margin:0 0 16px;font-size:30px;font-weight:400;color:#fff;letter-spacing:.3px}
.sj-grid{display:grid;grid-template-columns:1fr 300px;gap:18px;align-items:start}
.sj-midia{background:rgba(0,0,0,.28);display:flex;justify-content:center;align-items:center;overflow:hidden;border-radius:3px;box-shadow:0 0 12px rgba(0,0,0,.5)}
.sj-midia img{display:block;width:auto;max-width:100%;height:auto;max-height:460px;object-fit:contain}
.sj-midia span{color:#b9a6cf;padding:40px}
.sj-lado{display:flex;flex-direction:column;gap:10px}
.sj-capsula{background:rgba(0,0,0,.28);display:flex;justify-content:center;align-items:center;overflow:hidden;border-radius:3px}
.sj-capsula img{display:block;width:auto;max-width:100%;height:auto;max-height:200px;object-fit:contain}
.sj-capsula span{color:#b9a6cf;padding:30px}
.sj-desc{line-height:1.5;color:#e0d2ee;font-size:13px}
.sj-tab{width:100%;border-collapse:collapse;font-size:12px}
.sj-tab td{padding:4px 0;vertical-align:top;border-bottom:1px solid rgba(255,255,255,.08)}
.sj-tab td:first-child{color:#a58cc2;text-transform:uppercase;width:105px;font-size:11px}
.sj-tab b{color:#FFD966;font-weight:400}
.sj-nota-txt{font-weight:600}
.sj-compra{background:linear-gradient(90deg,rgba(255,217,102,.25),rgba(255,217,102,.05));border-radius:3px;padding:16px 18px;margin-top:22px;display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap}
.sj-compra h2{margin:0;font-size:20px;font-weight:400;color:#fff;flex:1 1 220px}
.sj-compra small{display:block;color:#b9a6cf;font-size:12px;margin-top:2px}
.sj-preco{display:flex;align-items:center;background:#000;border-radius:3px;overflow:hidden}
.sj-preco .v{padding:8px 14px;font-size:15px;color:#FFD966;background:rgba(0,0,0,.35)}
.sj-preco form{margin:0}
.sj-btn{display:inline-block;border:0;cursor:pointer;font:inherit;font-size:14px;font-weight:700;color:#3a1060;padding:9px 20px;background:linear-gradient(to right,#FFD966 5%,#E8B800 95%);transition:.15s;text-decoration:none}
.sj-btn:hover{background:linear-gradient(to right,#FFE48A 5%,#F5C800 95%);color:#3a1060}
.sj-btn.azul{background:linear-gradient(to right,#BB44DD 5%,#6A1FAD 95%);color:#fff;font-weight:400}
.sj-btn.azul:hover{filter:brightness(1.15);color:#fff}
.sj-tem{display:flex;align-items:center;gap:14px;flex-wrap:wrap;color:#FFD966}
.sj-sec{margin-top:26px}
.sj-sec h3{margin:0 0 10px;font-size:13px;font-weight:400;text-transform:uppercase;letter-spacing:1px;color:#fff;padding-bottom:4px;border-bottom:1px solid rgba(255,255,255,.15)}
.sj-sec p{line-height:1.65;margin:0;color:#d6c8e6}
.sj-reqs{display:grid;grid-template-columns:1fr 1fr;gap:20px}
.sj-reqs h4{margin:0 0 6px;font-size:12px;color:#fff;text-transform:uppercase;letter-spacing:.5px}
.sj-reqs p{font-size:13px;background:rgba(0,0,0,.25);padding:10px 12px;border-radius:3px}
.sj-form{background:rgba(0,0,0,.3);border-radius:3px;padding:14px 16px;margin-bottom:14px}
.sj-form label{display:block;font-size:12px;color:#b9a6cf;margin:8px 0 3px}
.sj-form select,.sj-form input{width:100%;background:#5a2a8a;border:1px solid #000;color:#fff;padding:8px;border-radius:3px;font:inherit}
.sj-form .sj-btn{margin-top:12px}
.sj-aval{background:rgba(0,0,0,.25);border-radius:3px;padding:12px 14px;margin-bottom:8px}
.sj-aval-topo{display:flex;align-items:center;gap:10px;margin-bottom:4px}
.sj-aval-topo b{color:#fff}.sj-aval-topo small{margin-left:auto;color:#a58cc2}
.sj-aval p{color:#d6c8e6}
.sj .stars{color:#FFD966;font-size:15px;letter-spacing:1px}
.sj-vazio{color:#a58cc2}
@media(max-width:850px){.sj-grid{grid-template-columns:1fr}.sj-reqs{grid-template-columns:1fr}.sj h1{font-size:24px}}
</style>

<div class="sj">
  <div class="sj-cam"><a href="index.php">Loja</a> &gt; <?=e($j['titulo'])?></div>
  <h1><?=e($j['titulo'])?></h1>

  <div class="sj-grid">
    <div class="sj-midia">
      <?php if($im): ?><img src="<?=$im?>" alt="<?=e($j['titulo'])?>"><?php else: ?><span>colocar imagem</span><?php endif; ?>
    </div>

    <div class="sj-lado">
      <div class="sj-capsula">
        <?php if($im): ?><img src="<?=$im?>" alt=""><?php else: ?><span>colocar imagem</span><?php endif; ?>
      </div>
      <div class="sj-desc"><?=e($j['descricao'])?></div>
      <table class="sj-tab">
        <tr><td>Avaliações</td><td><span class="sj-nota-txt" style="color:<?=$cor?>"><?=$rot?></span>
          <?php if($m!==null): ?><span class="stars"><?=str_repeat('★',(int)round($m)).str_repeat('☆',5-(int)round($m))?></span> <?=number_format($m,1,',','')?> (<?=$nota['t']?>)<?php endif; ?></td></tr>
        <tr><td>Lançamento</td><td><?=e(date('d/m/Y',strtotime($j['data_lancamento'])))?></td></tr>
        <tr><td>Desenvolvedora</td><td><b><?=e($j['dev'])?></b></td></tr>
        <tr><td>Publicadora</td><td><b><?=e($j['pub'])?></b></td></tr>
        <tr><td>Classificação</td><td><?=e($j['classificacao_etaria'])?></td></tr>
        <?php if(!$quiz): ?><tr><td>Download</td><td><?=e($j['tamanho_download'])?> GB</td></tr><?php endif; ?>
      </table>
    </div>
  </div>

  <div class="sj-compra">
    <?php if($gratis && $pode): ?>
      <h2><?=e($j['titulo'])?><small>Este jogo já está na sua biblioteca</small></h2>
      <div class="sj-tem">✔ Na biblioteca <a class="sj-btn azul" href="index.php?r=biblioteca">Ir para a biblioteca</a></div>
    <?php elseif($gratis): ?>
      <h2>Jogar <?=e($j['titulo'])?><small>Gratuito</small></h2>
      <div class="sj-preco"><span class="v">Grátis</span>
        <form method="post" action="index.php?r=resgatar"><input type="hidden" name="id_jogo" value="<?=$j['id_jogo']?>">
        <button class="sj-btn">Adicionar à biblioteca</button></form></div>
    <?php else: ?>
      <h2>Comprar <?=e($j['titulo'])?></h2>
      <div class="sj-preco"><span class="v"><?=brl($j['preco'])?></span>
        <form method="post" action="index.php?r=carrinho_add"><input type="hidden" name="id_jogo" value="<?=$j['id_jogo']?>">
        <button class="sj-btn">Adicionar ao carrinho</button></form></div>
    <?php endif; ?>
  </div>

  <?php if($quiz && $pode): ?>
  <div class="sj-compra"><h2>Pronto para jogar?<small>Responda às perguntas e veja sua pontuação</small></h2>
  <a class="sj-btn" href="index.php?r=quiz&id=<?=$j['id_jogo']?>">▶ Jogar quiz</a></div>
  <?php endif; ?>

  <div class="sj-sec"><h3>Sobre este jogo</h3><p><?=e($j['descricao'])?></p></div>

  <?php if(!$quiz): ?>
  <div class="sj-sec"><h3>Requisitos do sistema</h3>
    <div class="sj-reqs">
      <div><h4>Mínimos</h4><p><?=e($j['requisitos_minimos'])?></p></div>
      <div><h4>Recomendados</h4><p><?=e($j['requisitos_recomendados'])?></p></div>
    </div>
  </div>
  <?php endif; ?>

  <div class="sj-sec"><h3>Avaliações de usuários</h3>
    <?php if(!$logado): ?>
      <p>Entre na sua conta para avaliar este jogo. <a class="sj-btn azul" href="index.php?r=login">Entrar</a></p>
    <?php elseif(!$pode): ?>
      <p class="sj-vazio">Só quem tem este jogo na biblioteca pode avaliar.</p>
    <?php else: ?>
      <form method="post" action="index.php?r=avaliar" class="sj-form">
        <input type="hidden" name="id_jogo" value="<?=$j['id_jogo']?>">
        <label>Sua nota</label>
        <select name="nota"><?php for($n=5;$n>=0;$n--): ?><option value="<?=$n?>"<?=(($minha['nota']??5)==$n)?' selected':''?>><?=str_repeat('★',$n).str_repeat('☆',5-$n)?> (<?=$n?>)</option><?php endfor; ?></select>
        <label>Comentário (até 100 caracteres)</label>
        <input name="comentario" maxlength="100" required value="<?=e($minha['comentario']??'')?>">
        <button class="sj-btn"><?=$minha?'Atualizar avaliação':'Enviar avaliação'?></button>
      </form>
    <?php endif; ?>

    <?php foreach($avals as $a): ?>
      <div class="sj-aval">
        <div class="sj-aval-topo"><b><?=e($a['nickname'])?></b>
          <span class="stars"><?=str_repeat('★',(int)$a['nota']).str_repeat('☆',5-(int)$a['nota'])?></span>
          <small><?=e(date('d/m/Y',strtotime($a['data_avaliacao'])))?></small></div>
        <p><?=e($a['comentario'])?></p>
      </div>
    <?php endforeach; ?>
    <?php if(!$avals): ?><p class="sj-vazio">Ainda não há avaliações.</p><?php endif; ?>
  </div>
</div>