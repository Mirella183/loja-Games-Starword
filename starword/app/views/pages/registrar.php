<form class="card yellow narrow" method="post"><?php if($erro): ?><p class="err"><?=e($erro)?></p><?php endif; ?>
<label>Insira seu email<input class="in" type="email" name="email" required value="<?=e($_POST['email']??'')?>"></label>
<label>Insira um nickname<input class="in" name="nick" required value="<?=e($_POST['nick']??'')?>"></label>
<label>Insira a senha<input class="in" type="password" name="senha" required></label>
<label class="center">Data de nascimento</label><div class="dn">
<select class="in" name="dia" required><option value="">Dia</option><?php for($i=1;$i<=31;$i++) echo "<option>$i</option>"; ?></select>
<select class="in" name="mes" required><option value="">Mês</option><?php foreach(['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'] as $k=>$m) echo '<option value="'.($k+1).'">'.$m.'</option>'; ?></select>
<select class="in" name="ano" required><option value="">Ano</option><?php for($i=date('Y');$i>=1920;$i--) echo "<option>$i</option>"; ?></select></div>
<button class="btn green">Enviar</button></form>
<p class="center">Já possui uma conta? <a class="btn cyan" href="index.php?r=login">Faça login</a></p>
