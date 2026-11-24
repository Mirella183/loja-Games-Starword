<?php
ini_set('display_errors','1'); error_reporting(E_ALL);
require __DIR__.'/../app/bootstrap.php';

$map=[
  'home'=>['Home','index'],'jogo'=>['Home','jogo'],'avaliar'=>['Home','avaliar'],'resgatar'=>['Home','resgatar'],
  'biblioteca'=>['Home','biblioteca'],'suporte'=>['Home','suporte'],
  'login'=>['Auth','login'],'registrar'=>['Auth','registrar'],'sair'=>['Auth','sair'],'perfil'=>['Auth','perfil'],
  'carrinho'=>['Cart','ver'],'carrinho_add'=>['Cart','adicionar'],'carrinho_alt'=>['Cart','alterar'],
  'pagamento'=>['Checkout','pagamento'],'confirmacao'=>['Checkout','confirmacao'],'nota'=>['Checkout','nota'],
  'compras'=>['Compras','lista'],
  'quiz'=>['Quiz','jogar'],'quiz_admin'=>['Quiz','admin'],'quiz_salvar'=>['Quiz','salvar'],'quiz_remover'=>['Quiz','remover'],
  'admin'=>['Admin','index'],'admin_salvar'=>['Admin','salvar'],'admin_status'=>['Admin','status'],
  'admin_promover'=>['Admin','promover'],'admin_jogos'=>['Admin','jogos'],'admin_capa'=>['Admin','capa'],
  'admin_categoria'=>['Catalogo','categoria'],'admin_plataforma'=>['Catalogo','plataforma']
];

$r=$_GET['r']??'home';
if(!isset($map[$r])){ http_response_code(404); exit('Página não encontrada'); }
[$c,$m]=$map[$r];
$cls=$c.'Controller';
(new $cls)->$m();