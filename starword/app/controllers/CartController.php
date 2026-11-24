<?php
class CartController extends Controller{

  function ver(){
    $this->auth();
    try{
      $itens=Carrinho::itens($this->user()['id']);
      $total=Carrinho::total($itens);
    }catch(Exception $x){ $this->flash('Erro no carrinho: '.$x->getMessage()); $this->go('home'); }
    $this->view('carrinho',compact('itens','total'),'steps1');
  }

  function adicionar(){
    if(!$this->user()){ $this->flash('Faça login para adicionar jogos ao carrinho.'); $this->go('login'); }
    if(!$this->post()) $this->go('home');
    $id=(int)($_POST['id_jogo']??0);
    try{
      $j=DB::q("SELECT preco FROM Jogos WHERE id_jogo=?",[$id])->fetch();
      if(!$j){ $this->flash('Jogo não encontrado.'); $this->go('home'); }
      if((float)$j['preco']<=0){ $this->flash('Este jogo é gratuito. Use "Adicionar à biblioteca".'); $this->go('jogo','&id='.$id); }
      Carrinho::add($this->user()['id'],$id);
      $this->flash('Jogo adicionado ao carrinho!');
    }catch(Exception $x){
      $this->flash('Erro ao adicionar: '.$x->getMessage());
      $this->go('jogo','&id='.$id);
    }
    $this->go('carrinho');
  }

  function alterar(){
    $this->auth();
    if($this->post()){
      try{ Carrinho::alterar($this->user()['id'],(int)$_POST['id_item'],(int)$_POST['delta']<0?-1:1); }
      catch(Exception $x){ $this->flash('Erro: '.$x->getMessage()); }
    }
    $this->go('carrinho');
  }
}