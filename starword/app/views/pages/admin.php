<section class="pad adm"><div>
<form class="card yellow" method="post" action="index.php?r=admin_salvar">
<h6 class="center"><?= $edit?'Editar Administrador':'Novo Administrador' ?></h6>
<input type="hidden" name="id_admin" value="<?=$edit['id_admin']??''?>">
<label>Nome<input class="in" name="nome" value="<?=e($edit['nickname']??'')?>" required></label>
<label>CPF<input class="in" name="cpf" maxlength="14" placeholder="000.000.000-00" value="<?=$edit?e(Admin::fmtCpf($edit['cpf'])==='—'?'':Admin::fmtCpf($edit['cpf'])):''?>" required></label>
<label>Telefone<input class="in" name="telefone" maxlength="15" placeholder="(21) 99999-9999" value="<?=$edit?e(Admin::fmtTel($edit['telefone'])==='—'?'':Admin::fmtTel($edit['telefone'])):''?>" required></label>
<label>Email<input class="in" type="email" name="email" value="<?=e($edit['email']??'')?>" required></label>
<p class="center"><button class="btn green"><?= $edit?'Salvar':'Adicionar' ?></button> <a class="btn red" href="index.php?r=admin">Limpar</a></p>
</form>

<form class="card yellow" method="post" action="index.php?r=admin_promover"><h6 class="center">Tornar usuário existente ADM</h6>
<label>Nickname ou email do usuário<input class="in" name="login" required></label><p class="center"><button class="btn green">Promover a ADM</button></p></form>
</div>

<div class="card yellow"><h6>Administradores</h6>
<table class="tbl small"><tr><th>ID</th><th>Nome</th><th>CPF</th><th>Telefone</th><th>Status</th><th>Ações</th></tr>
<?php foreach($admins as $a): ?>
<tr><td><?=$a['id_admin']?></td><td><?=e($a['nickname'])?></td><td><?=e(Admin::fmtCpf($a['cpf']))?></td><td><?=e(Admin::fmtTel($a['telefone']))?></td>
<td><?=$a['ativo']?'Ativo':'Inativo'?></td>
<td><a class="btn green" href="index.php?r=admin&edit=<?=$a['id_admin']?>">Editar</a> <a class="btn red" href="index.php?r=admin_status&id=<?=$a['id_admin']?>"><?=$a['ativo']?'Inativar':'Ativar'?></a></td></tr>
<?php endforeach; ?></table></div>

<p><a class="btn cyan" href="index.php">Voltar</a> <a class="btn purplebtn" href="index.php?r=admin_jogos">Adicionar Jogos</a></p></section>