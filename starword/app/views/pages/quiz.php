<style>
.qz{max-width:820px;margin:20px auto;background:#3a1060;color:#fff;border-radius:10px;padding:24px 28px;box-shadow:0 4px 18px rgba(0,0,0,.3)}
.qz h1{margin:0 0 4px;font-size:28px}.qz .sub{color:#d6c8e6;margin:0 0 18px}
.qz-p{background:rgba(0,0,0,.25);border-radius:8px;padding:14px 16px;margin-bottom:14px}
.qz-p h3{margin:0 0 10px;font-size:17px}
.qz-op{display:block;background:#5a2a8a;border-radius:6px;padding:10px 12px;margin-bottom:6px;cursor:pointer}
.qz-op:hover{background:#7035ad}.qz-op input{margin-right:8px}
.qz-op.certa{background:#1f8f3a}.qz-op.errada{background:#b3261e}
.qz-btn{display:inline-block;border:0;cursor:pointer;font:inherit;font-weight:700;color:#3a1060;background:#FFD966;padding:11px 26px;border-radius:5px;margin:4px;text-decoration:none}
.qz-btn:hover{background:#FFE48A}.qz-btn.roxo{background:#BB44DD;color:#fff}
.qz-placar{text-align:center;background:#FFD966;color:#3a1060;border-radius:10px;padding:18px;margin-bottom:18px}
.qz-placar b{font-size:42px;display:block}
.qz-fim{text-align:center;margin-top:16px}
</style>

<div class="qz">
<h1><?=e($j['titulo'])?></h1>

<?php if($resultado): ?>
  <?php $pct=$resultado['total']?round($resultado['acertos']*100/$resultado['total']):0; ?>
  <div class="qz-placar">Você acertou<b><?=$resultado['acertos']?> de <?=$resultado['total']?></b><?=$pct?>% de aproveitamento
    <?= $pct==100?' 🏆 Perfeito!':($pct>=60?' 👏 Muito bem!':' 💪 Tente de novo!') ?></div>

  <?php foreach($resultado['detalhe'] as $n=>$d): ?>
    <div class="qz-p"><h3><?=$n+1?>. <?=e($d['p']['pergunta'])?> <?=$d['ok']?'✔':'✘'?></h3>
    <?php foreach($d['p']['opcoes'] as $o):
      $cls=$o['correta']?'certa':($o['id_opcao']==$d['escolhida']?'errada':''); ?>
      <div class="qz-op <?=$cls?>"><?=$o['correta']?'✔ ':($o['id_opcao']==$d['escolhida']?'✘ ':'')?><?=e($o['texto'])?></div>
    <?php endforeach; ?></div>
  <?php endforeach; ?>

  <div class="qz-fim">
    <a class="qz-btn" href="index.php?r=quiz&id=<?=$j['id_jogo']?>">↻ Jogar de novo</a>
    <a class="qz-btn roxo" href="index.php?r=jogo&id=<?=$j['id_jogo']?>">Voltar ao jogo</a>
    <a class="qz-btn roxo" href="index.php?r=biblioteca">Minha Biblioteca</a>
  </div>

<?php else: ?>
  <p class="sub"><?=count($perguntas)?> perguntas<?php if($melhor): ?> · Seu melhor resultado: <?=$melhor['acertos']?>/<?=$melhor['total']?><?php endif; ?></p>
  <form method="post">
  <?php foreach($perguntas as $n=>$p): ?>
    <div class="qz-p"><h3><?=$n+1?>. <?=e($p['pergunta'])?></h3>
    <?php foreach($p['opcoes'] as $k=>$o): ?>
      <label class="qz-op"><input type="radio" name="resp[<?=$p['id_pergunta']?>]" value="<?=$o['id_opcao']?>"<?=$k===0?' required':''?>><?=e($o['texto'])?></label>
    <?php endforeach; ?></div>
  <?php endforeach; ?>
  <div class="qz-fim"><button class="qz-btn">Finalizar quiz</button>
  <a class="qz-btn roxo" href="index.php?r=jogo&id=<?=$j['id_jogo']?>">Cancelar</a></div>
  </form>
<?php endif; ?>
</div>