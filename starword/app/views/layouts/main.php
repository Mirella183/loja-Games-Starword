<!DOCTYPE html><html lang="pt-BR"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>StarWord</title>
<link rel="icon" type="image/png" href="img/logo.png"><link rel="stylesheet" href="css/style.css"></head><body>
<header class="top"><a class="logo" href="/starword/public/index.php"><img src="/starword/public/img/logo.png" alt="StarWord"></a>
<nav><a href="index.php">Explorar</a><a href="index.php?r=biblioteca">Minha Biblioteca</a><?php if(isset($_SESSION['u'])): ?><a href="index.php?r=compras">Minhas Compras</a><?php endif; ?><?php if(!empty($_SESSION['u']['admin'])): ?><a href="index.php?r=admin">ADM</a><a href="index.php?r=admin_jogos">Adicionar Jogos</a><a href="index.php?r=quiz_admin">Quizzes</a><?php endif; ?><a href="index.php?r=suporte">Suporte</a></nav>
<form class="search" method="get" action="index.php"><input name="q" placeholder="Pesquisar" value="<?=e($_GET['q']??'')?>"></form>
<a class="avatar" href="index.php?r=<?=isset($_SESSION['u'])?'perfil':'login'?>" title="<?=e($_SESSION['u']['nick']??'Entrar')?>"><?php if(isset($_SESSION['u']) && ($av=avatar($_SESSION['u']['id']))): ?><img src="<?=$av?>" alt=""><?php endif; ?></a>
<a class="cartlink" href="index.php?r=carrinho">🛒</a><?php if(isset($_SESSION['u'])): ?><a class="sair" href="index.php?r=sair">Sair</a><?php endif; ?></header>
<?php if(!empty($_SESSION['flash'])): ?><div class="flash"><?=e($_SESSION['flash'])?></div><?php unset($_SESSION['flash']); endif; ?>
<main><?php include $content; ?></main>
<div class="about">Sobre a loja: a StarWord é a loja on-line de jogos de tabuleiro, cartas e quizzes digitais. Contato: suporte@starword.com.br</div>
<footer class="foot"><a href="#">Termos</a><span>© StarWord <?=date('Y')?></span><a href="#">Privacidade</a></footer></body></html>