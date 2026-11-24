<?php
class HomeController extends Controller{
  function index(){ $q=trim($_GET['q']??''); $cat=$_GET['categoria']??'';
    if($q!==''||$cat!==''){ $res=$q!==''?Jogo::busca($q):Jogo::porCategoria($cat,50); return $this->view('busca',compact('res','q','cat')); }
    $d=['mais'=>Jogo::maisJogados(10),'recom'=>Jogo::recentes(10,0),'avancar'=>Jogo::recentes(5,10),'destaque'=>Jogo::maisJogados(5),
      'tab'=>Jogo::porCategoria('Tabuleiro',10),'cartas'=>Jogo::porCategoria('Cartas',10),'quiz'=>Jogo::porCategoria('Quizzes',10),'novos'=>Jogo::recentes(10,0)];
    $this->view('home',$d); }

   function jogo(){
    $j=Jogo::find((int)($_GET['id']??0)); if(!$j){ $this->go('home'); }
    $nota=Jogo::media($j['id_jogo']); $avals=Avaliacao::doJogo($j['id_jogo']); $quiz=Jogo::ehQuiz($j['id_jogo']);
    $logado=(bool)$this->user(); $pode=false; $minha=null;
    if($logado){ $uid=$this->user()['id']; $pode=Avaliacao::possui($uid,$j['id_jogo']); $minha=Avaliacao::minha($uid,$j['id_jogo']); }
    $this->view('jogo',compact('j','nota','avals','logado','pode','minha','quiz'));
  }
  function resgatar(){
    if(!$this->user()){ $this->flash('Faça login para adicionar o jogo à biblioteca.'); $this->go('login'); }
    if(!$this->post()) $this->go('home');
    $uid=$this->user()['id']; $id=(int)($_POST['id_jogo']??0);
    $j=DB::q("SELECT preco FROM Jogos WHERE id_jogo=?",[$id])->fetch();
    if(!$j) $this->go('home');
    if((float)$j['preco']>0){ $this->flash('Este jogo não é gratuito. Adicione ao carrinho.'); $this->go('jogo','&id='.$id); }
    try{
      if(!Avaliacao::possui($uid,$id)) DB::q("INSERT INTO Biblioteca(id_usuario,id_jogo,data_compra) VALUES(?,?,CURDATE())",[$uid,$id]);
      $this->flash('Jogo adicionado à sua biblioteca!');
    }catch(Exception $x){ $this->flash('Erro: '.$x->getMessage()); $this->go('jogo','&id='.$id); }
    $this->go('biblioteca');
  }

  function avaliar(){
    $this->auth(); if(!$this->post()) $this->go('home');
    $uid=$this->user()['id']; $id=(int)($_POST['id_jogo']??0); $nota=$_POST['nota']??''; $com=trim($_POST['comentario']??'');
    if(!DB::q("SELECT 1 FROM Jogos WHERE id_jogo=?",[$id])->fetch()) $this->go('home');
    if(!Avaliacao::possui($uid,$id)) $this->flash('Só quem tem o jogo na biblioteca pode avaliar.');
    elseif(!ctype_digit((string)$nota)||(int)$nota<0||(int)$nota>5) $this->flash('Escolha uma nota de 0 a 5.');
    elseif($com===''||mb_strlen($com)>100) $this->flash('Escreva um comentário de até 100 caracteres.');
    else{
      try{ Avaliacao::salvar($uid,$id,(int)$nota,$com); $this->flash('Avaliação salva!'); }
      catch(Exception $x){ $this->flash('Erro ao salvar: '.$x->getMessage()); }
    }
    $this->go('jogo','&id='.$id);
  }

  function biblioteca(){ $this->auth(); $jogos=Jogo::biblioteca($this->user()['id']); $this->view('biblioteca',compact('jogos')); }

  function suporte(){ $this->auth(); $u=$this->user()['id'];
    if($this->post()){ $c=in_array($_POST['categoria']??'',['Pagamento','Conta','Produto'])?$_POST['categoria']:'Conta';
      DB::q("INSERT INTO suporte(id_usuario,assunto,descricao,categoria,status) VALUES(?,?,?,?,'Aberto')",[$u,trim($_POST['assunto']),trim($_POST['descricao']),$c]); $this->flash('Chamado aberto.'); $this->go('suporte'); }
    $chamados=DB::q("SELECT * FROM suporte WHERE id_usuario=? ORDER BY id_suporte DESC",[$u])->fetchAll(); $this->view('suporte',compact('chamados')); }
}