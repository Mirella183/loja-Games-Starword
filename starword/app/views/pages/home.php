<section class="pad"><h4 class="center">Categoria</h4><div class="cats"><a class="cat blue" href="index.php?categoria=Tabuleiro">Tabuleiros</a><a class="cat purple" href="index.php?categoria=Cartas">Cartas</a><a class="cat yel" href="index.php?categoria=Quizzes">Quizzes</a></div>
<h5>Mais Jogados</h5><div class="strip">‹ <?php tiles($mais,10,'circle'); ?> ›</div>
<h5>Recomendados para você</h5><div class="grid5"><?php tiles($recom,10,'dblue'); ?></div>
<h5>Jogos em destaque</h5><div class="grid5"><?php tiles($destaque,5,'purple'); ?></div>
<h5>Vitrine de jogos</h5>
<h6>Tabuleiro</h6><div class="grid10"><?php tiles($tab,10,'blue'); ?></div>
<h6>Cartas</h6><div class="grid10"><?php tiles($cartas,10,'purple'); ?></div>
<h6>Quizzes</h6><div class="grid10"><?php tiles($quiz,10,'yel'); ?></div>
<h5>Novos Lançamentos</h5><div class="grid5"><?php tiles($novos,10,'lav'); ?></div></section>