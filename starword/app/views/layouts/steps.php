<!DOCTYPE html><html lang="pt-BR"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>StarWord</title>
<link rel="icon" type="image/png" href="img/logo.png"><link rel="stylesheet" href="css/style.css"></head><body>
<header class="top"><a class="logo" href="/starword/public/index.php"><img src="/starword/public/img/logo.png" alt="StarWord"></a>
<div class="steps"><?php foreach(['Carrinho','Pagamento','Confirmação'] as $i=>$n): ?><div class="step"><i class="s<?=$i+1?><?=$i+1<=$step?' on':''?>"></i><span><?=$n?></span></div><?php if($i<2): ?><b class="bar"></b><?php endif; endforeach; ?></div></header>
<?php if(!empty($_SESSION['flash'])): ?><div class="flash"><?=e($_SESSION['flash'])?></div><?php unset($_SESSION['flash']); endif; ?>
<main><?php include $content; ?></main></body></html>