<form class="card yellow narrow" method="post"><?php if($erro): ?><p class="err"><?=e($erro)?></p><?php endif; ?>
<label>Insira seu nickname ou endereço de email<input class="in" name="id" required></label>
<label>Insira a senha<input class="in" type="password" name="senha" required></label>
<button class="btn green">Enviar</button><a class="btn cyan" href="index.php?r=suporte">Esqueceu a senha</a></form>
<p class="center">Não tem uma conta? <a class="btn cyan" href="index.php?r=registrar">Registre-se</a></p>
