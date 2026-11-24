<?php
class QuizController extends Controller{
  private function guard(){ $this->auth(); if(!Usuario::ehAdmin($this->user()['id'])){ $this->flash('Acesso restrito a administradores.'); $this->go('home'); } }

  function jogar(){
    $this->auth(); $uid=$this->user()['id']; $id=(int)($_GET['id']??0);
    $j=Jogo::find($id);
    if(!$j||!Quiz::ehQuiz($id)) $this->go('home');
    if(!Avaliacao::possui($uid,$id)){ $this->flash('Adicione o quiz à biblioteca para jogar.'); $this->go('jogo','&id='.$id); }
    $perguntas=Quiz::perguntas($id);
    if(!$perguntas){ $this->flash('Este quiz ainda não tem perguntas.'); $this->go('jogo','&id='.$id); }
    $resultado=null;
    if($this->post()){
      $resp=$_POST['resp']??[]; $acertos=0; $detalhe=[];
      foreach($perguntas as $p){
        $esc=(int)($resp[$p['id_pergunta']]??0); $ok=false;
        foreach($p['opcoes'] as $o){ if($o['id_opcao']==$esc && $o['correta']) $ok=true; }
        if($ok) $acertos++;
        $detalhe[]=['p'=>$p,'escolhida'=>$esc,'ok'=>$ok];
      }
      Quiz::salvarResultado($uid,$id,$acertos,count($perguntas));
      $resultado=['acertos'=>$acertos,'total'=>count($perguntas),'detalhe'=>$detalhe];
    }
    $melhor=Quiz::melhor($uid,$id);
    $this->view('quiz',compact('j','perguntas','resultado','melhor'));
  }

  function admin(){
    $this->guard(); $id=(int)($_GET['id']??0);
    $quizzes=Quiz::quizzes(); $j=$id?Jogo::find($id):null; $perguntas=$j?Quiz::perguntas($id):[];
    $edit=($j&&isset($_GET['edit']))?Quiz::pergunta((int)$_GET['edit'],$id):null;
    $this->view('quiz_admin',compact('quizzes','j','perguntas','edit'));
  }

  function salvar(){
    $this->guard(); if(!$this->post()) $this->go('quiz_admin');
    $id=(int)($_POST['id_jogo']??0); $idp=(int)($_POST['id_pergunta']??0); $perg=trim($_POST['pergunta']??''); $ops=[];
    for($i=0;$i<4;$i++) $ops[$i]=trim($_POST['op'][$i]??'');
    $correta=(int)($_POST['correta']??-1); $qtd=count(array_filter($ops,fn($x)=>$x!==''));
    $volta='&id='.$id.($idp?'&edit='.$idp:'');
    if(!Quiz::ehQuiz($id)) $this->flash('Jogo inválido.');
    elseif($perg===''||mb_strlen($perg)>250) $this->flash('Escreva a pergunta (até 250 caracteres).');
    elseif($qtd<2) $this->flash('Preencha ao menos 2 alternativas.');
    elseif($correta<0||$correta>3||$ops[$correta]==='') $this->flash('Marque qual alternativa é a correta.');
    elseif(max(array_map('mb_strlen',$ops))>150) $this->flash('Cada alternativa pode ter até 150 caracteres.');
    elseif($idp && !Quiz::pergunta($idp,$id)) $this->flash('Pergunta não encontrada.');
    else{
      try{
        if($idp){ Quiz::atualizar($idp,$id,$perg,$ops,$correta); $this->flash('Pergunta atualizada!'); }
        else{ Quiz::criar($id,$perg,$ops,$correta); $this->flash('Pergunta adicionada!'); }
        $volta='&id='.$id;
      }catch(Exception $x){ $this->flash('Erro: '.$x->getMessage()); }
    }
    $this->go('quiz_admin',$volta);
  }

  function remover(){
    $this->guard(); $id=(int)($_POST['id_jogo']??0);
    if($this->post()){ Quiz::remover((int)($_POST['id_pergunta']??0),$id); $this->flash('Pergunta removida.'); }
    $this->go('quiz_admin','&id='.$id);
  }
}