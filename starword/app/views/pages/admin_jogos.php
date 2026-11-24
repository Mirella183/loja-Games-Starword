<section class="pad">

<form class="card yellow gform" method="post" enctype="multipart/form-data">
<h4 class="center">Adicionar Jogo</h4>
<?php if($erro): ?><p class="err"><?=e($erro)?></p><?php endif; ?>

<label>Título<input class="in" name="titulo" maxlength="100" value="<?=e($f['titulo']??'')?>" required></label>

<label>Descrição (até 250 caracteres)<textarea class="in" name="descricao" rows="3" maxlength="250" required><?=e($f['descricao']??'')?></textarea></label>

<div class="three2">
<label>Preço (R$)<input class="in" name="preco" value="<?=e($f['preco']??'')?>" required></label>
<label>Data de lançamento<input class="in" type="date" name="data" value="<?=e($f['data']??'')?>" required></label>
<label>Classificação etária<select class="in" name="classificacao"><option value="">Selecione</option><?php foreach(['L','10','12','14','16','18'] as $c) echo '<option'.(($f['classificacao']??'')===$c?' selected':'').'>'.$c.'</option>'; ?></select></label>
<label>Download (GB)<input class="in" name="tamanho" value="<?=e($f['tamanho']??'')?>" required></label>
</div>

<label>Requisitos mínimos (deixe em branco para quizzes)<input class="in" name="rmin" maxlength="250" value="<?=e($f['rmin']??'')?>"></label>
<label>Requisitos recomendados (deixe em branco para quizzes)<input class="in" name="rrec" maxlength="250" value="<?=e($f['rrec']??'')?>"></label>

<div class="two">
<div>
<label>Desenvolvedora<select class="in" name="dev"><option value="">Selecione</option><?php foreach($l['devs'] as $d) echo '<option value="'.$d['id'].'"'.(($f['dev']??'')==$d['id']?' selected':'').'>'.e($d['nome']).'</option>'; ?></select></label>
<label>ou cadastrar nova<input class="in" name="devNovo" maxlength="50" value="<?=e($f['devNovo']??'')?>"></label>
</div>
<div>
<label>Publicadora<select class="in" name="pub"><option value="">Selecione</option><?php foreach($l['pubs'] as $d) echo '<option value="'.$d['id'].'"'.(($f['pub']??'')==$d['id']?' selected':'').'>'.e($d['nome']).'</option>'; ?></select></label>
<label>ou cadastrar nova<input class="in" name="pubNovo" maxlength="100" value="<?=e($f['pubNovo']??'')?>"></label>
</div>
</div>

<label>Categorias</label>
<div class="checks"><?php foreach($l['cats'] as $c): ?><label><input type="checkbox" name="cats[]" value="<?=$c['id']?>"<?=in_array($c['id'],$f['cats']??[])?' checked':''?>> <?=e($c['nome'])?></label><?php endforeach; ?></div>

<label>Plataformas</label>
<div class="checks"><?php foreach($l['plats'] as $c): ?><label><input type="checkbox" name="plats[]" value="<?=$c['id']?>"<?=in_array($c['id'],$f['plats']??[])?' checked':''?>> <?=e($c['nome'])?></label><?php endforeach; ?></div>

<label>Capa do jogo (JPG, PNG ou WEBP, até 2 MB)<input type="file" name="capa" accept="image/png,image/jpeg,image/webp"></label>

<p class="center"><button class="btn green">Adicionar jogo</button> <a class="btn cyan" href="index.php?r=admin">Voltar</a></p>
</form>

<div class="two" style="max-width:900px;margin:0 auto">
<form class="card yellow" method="post" action="index.php?r=admin_categoria">
<h6 class="center">Nova categoria</h6>
<label>Nome<input class="in" name="nome" maxlength="100" required></label>
<p class="center"><button class="btn green">Adicionar categoria</button></p>
</form>
<form class="card yellow" method="post" action="index.php?r=admin_plataforma">
<h6 class="center">Nova plataforma</h6>
<label>Nome<input class="in" name="nome" maxlength="150" required></label>
<p class="center"><button class="btn green">Adicionar plataforma</button></p>
</form>
</div>

<table class="tbl small">
<tr><th>ID</th><th>Capa</th><th>Título</th><th>Preço</th><th>Lançamento</th><th>Alterar capa</th></tr>
<?php foreach($recentes as $j): ?>
<tr>
<td><?=$j['id_jogo']?></td>
<td><?php if($im=capa($j['id_jogo'])): ?><img src="<?=$im?>" alt="" style="width:60px;height:40px;object-fit:cover"><?php else: ?>—<?php endif; ?></td>
<td><?=e($j['titulo'])?></td>
<td><?=brl($j['preco'])?></td>
<td><?=e(date('d/m/Y',strtotime($j['data_lancamento'])))?></td>
<td>
<form method="post" action="index.php?r=admin_capa" enctype="multipart/form-data">
<input type="hidden" name="id_jogo" value="<?=$j['id_jogo']?>">
<input type="file" name="capa" accept="image/png,image/jpeg,image/webp">
<button class="btn green">Enviar</button>
</form>
</td>
</tr>
<?php endforeach; ?>
</table>

</section>