<form class="card yellow profile" method="post" enctype="multipart/form-data"><?php if($erro): ?><p class="err"><?=e($erro)?></p><?php endif; ?>
<div class="photo"><?php if($av=avatar($u['id_usuario'])): ?><img src="<?=$av?>" alt="Foto de perfil"><?php else: ?>colocar imagem<?php endif; ?></div>
<p class="center"><label>Mudar foto de perfil<input type="file" name="foto" accept="image/png,image/jpeg,image/webp"></label></p>
<div class="two"><label>Nickname<input class="in" name="nick" value="<?=e($u['nickname'])?>"></label><label>Email<input class="in" value="<?=e($u['email'])?>" readonly></label></div>
<label>Senha (deixe em branco para manter)<input class="in" type="password" name="senha"></label><p class="center"><button class="btn green">Salvar</button></p></form>