<section class="pad">
<?php if(!$j): ?>
  <div class="card yellow" style="max-width:700px"><h4 class="center">Quizzes</h4>
  <table class="tbl small"><tr><th>Quiz</th><th>Perguntas</th><th>Ação</th></tr>
  <?php foreach($quizzes as $q): ?>
  <tr><td><?=e($q['titulo'])?></td><td><?=$q['n']?></td><td><a class="btn green" href="index.php?r=quiz_admin&id=<?=$q['id_jogo']?>">Gerenciar perguntas</a></td></tr>
  <?php endforeach; ?>
  <?php if(!$quizzes): ?><tr><td colspan="3">Nenhum quiz cadastrado. Crie um em Adicionar Jogos, na categoria Quizzes.</td></tr><?php endif; ?>
  </table><p class="center"><a class="btn cyan" href="index.php?r=admin">Voltar</a></p></div>

<?php else: ?>
  <?php
    $ops=[]; $certa=0;
    if($edit){ foreach($edit['opcoes'] as $k=>$o){ $ops[$k]=$o['texto']; if($o['correta']) $certa=$k; } }
  ?>
  <form class="card yellow" method="post" action="index.php?r=quiz_salvar" style="max-width:700px">
  <h4 class="center"><?= $edit?'Editar pergunta':'Nova pergunta' ?> — <?=e($j['titulo'])?></h4>
  <input type="hidden" name="id_jogo" value="<?=$j['id_jogo']?>">
  <input type="hidden" name="id_pergunta" value="<?=$edit['id_pergunta']??''?>">
  <label>Pergunta<input class="in" name="pergunta" maxlength="250" required value="<?=e($edit['pergunta']??'')?>"></label>
  <?php for($i=0;$i<4;$i++): ?>
    <label>Alternativa <?=$i+1?><?=$i>1?' (opcional)':''?>
      <span style="display:flex;gap:8px;align-items:center"><input class="in" name="op[<?=$i?>]" maxlength="150" value="<?=e($ops[$i]??'')?>"<?=$i<2?' required':''?>>
      <span style="white-space:nowrap;font-weight:400"><input type="radio" name="correta" value="<?=$i?>"<?=$certa===$i?' checked':''?><?=$i===0?' required':''?>> correta</span></span></label>
  <?php endfor; ?>
  <p class="center"><button class="btn green"><?= $edit?'Salvar alterações':'Adicionar pergunta' ?></button>
  <?php if($edit): ?><a class="btn red" href="index.php?r=quiz_admin&id=<?=$j['id_jogo']?>">Cancelar edição</a><?php endif; ?>
  <a class="btn cyan" href="index.php?r=quiz_admin">Voltar</a></p></form>

  <div class="card yellow" style="max-width:700px"><h6>Perguntas cadastradas (<?=count($perguntas)?>)</h6>
  <?php foreach($perguntas as $n=>$p): $emEdicao=($edit && $edit['id_pergunta']==$p['id_pergunta']); ?>
    <div style="background:<?=$emEdicao?'#FFD0F0':'#FFE899'?>;border-radius:8px;padding:10px 14px;margin-bottom:8px">
      <b><?=$n+1?>. <?=e($p['pergunta'])?></b><?=$emEdicao?' <small>(editando)</small>':''?>
      <ul style="margin:6px 0"><?php foreach($p['opcoes'] as $o): ?><li><?=$o['correta']?'✔ <b>'.e($o['texto']).'</b>':e($o['texto'])?></li><?php endforeach; ?></ul>
      <a class="btn purplebtn" href="index.php?r=quiz_admin&id=<?=$j['id_jogo']?>&edit=<?=$p['id_pergunta']?>">✏ Editar</a>
      <form method="post" action="index.php?r=quiz_remover" style="display:inline"><input type="hidden" name="id_jogo" value="<?=$j['id_jogo']?>"><input type="hidden" name="id_pergunta" value="<?=$p['id_pergunta']?>"><button class="btn red">Remover</button></form>
    </div>
  <?php endforeach; ?>
  <?php if(!$perguntas): ?><p>Ainda não há perguntas.</p><?php endif; ?></div>
<?php endif; ?>
</section>