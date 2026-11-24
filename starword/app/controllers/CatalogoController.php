<?php
class CatalogoController extends Controller{
  private function guard(){ $this->auth(); if(!Usuario::ehAdmin($this->user()['id'])){ $this->flash('Acesso restrito a administradores.'); $this->go('home'); } }

  function categoria(){ $this->add('Categorias',100,'Categoria'); }
  function plataforma(){ $this->add('plataformas',150,'Plataforma'); }

  private function add($tabela,$max,$rotulo){
    $this->guard(); if(!$this->post()) $this->go('admin_jogos');
    $nome=trim($_POST['nome']??'');
    if($nome===''||mb_strlen($nome)>$max) $this->flash($rotulo.' inválida (até '.$max.' caracteres).');
    elseif(DB::q("SELECT 1 FROM $tabela WHERE nome=?",[$nome])->fetch()) $this->flash($rotulo.' já existe.');
    else{ DB::q("INSERT INTO $tabela(nome) VALUES(?)",[$nome]); $this->flash($rotulo.' adicionada!'); }
    $this->go('admin_jogos');
  }
}