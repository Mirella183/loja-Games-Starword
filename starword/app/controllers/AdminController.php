<?php
class AdminController extends Controller{
  private function guard(){ $this->auth(); if(!Usuario::ehAdmin($this->user()['id'])){ $this->flash('Acesso restrito a administradores.'); $this->go('home'); } }

  function index(){ $this->guard(); $admins=Admin::todos(); $edit=isset($_GET['edit'])?Admin::find((int)$_GET['edit']):null; $this->view('admin',compact('admins','edit')); }

  function salvar(){ $this->guard(); if(!$this->post())$this->go('admin');
    $n=trim($_POST['nome']??''); $e=trim($_POST['email']??''); $id=(int)($_POST['id_admin']??0);
    $cpf=preg_replace('/\D/','',$_POST['cpf']??''); $tel=preg_replace('/\D/','',$_POST['telefone']??'');
    try{
      if(mb_strlen($n)<6) throw new Exception('O nome precisa ter mais de 5 caracteres.');
      if(!filter_var($e,FILTER_VALIDATE_EMAIL)) throw new Exception('Email inválido.');
      if(strlen($cpf)!==11) throw new Exception('O CPF precisa ter 11 números.');
      if(!in_array(strlen($tel),[10,11])) throw new Exception('Telefone inválido (use DDD + número).');
      if($id){ Admin::editar($id,$n,$e,$cpf,$tel); $this->flash('Administrador atualizado.'); }
      else{ Admin::criar($n,$e,$cpf,$tel); $this->flash('Administrador criado (senha inicial: starword123).'); }
    }catch(Exception $x){
      $this->flash('Erro: '.(strpos($x->getMessage(),'Duplicate')!==false?'nome, email ou CPF já cadastrado.':$x->getMessage()));
    }
    $this->go('admin'); }

  function status(){ $this->guard(); Admin::alternar((int)$_GET['id']); $this->go('admin'); }

  function promover(){ $this->guard(); if(!$this->post())$this->go('admin');
    $erro=Admin::promover(trim($_POST['login']??''));
    $this->flash($erro?:'Usuário promovido a administrador.'); $this->go('admin'); }

  function capa(){ $this->guard();
    if($this->post() && !empty($_FILES['capa']['name'])){
      $id=(int)($_POST['id_jogo']??0);
      if(!DB::q("SELECT 1 FROM Jogos WHERE id_jogo=?",[$id])->fetch()) $this->flash('Jogo não encontrado.');
      else{ $erro=salvarCapa($_FILES['capa'],$id); $this->flash($erro?:'Capa atualizada.'); }
    } else $this->flash('Escolha uma imagem.');
    $this->go('admin_jogos'); }

  function jogos(){ $this->guard(); $erro=null; $f=$_POST;
    if($this->post()){
      $titulo=trim($f['titulo']??''); $desc=trim($f['descricao']??''); $preco=str_replace(',','.',trim($f['preco']??''));
      $data=$f['data']??''; $cls=$f['classificacao']??''; $tam=str_replace(',','.',trim($f['tamanho']??''));
      $rmin=trim($f['rmin']??''); $rrec=trim($f['rrec']??''); $dt=DateTime::createFromFormat('Y-m-d',$data);
      $devNovo=trim($f['devNovo']??''); $pubNovo=trim($f['pubNovo']??'');
      if($titulo===''||mb_strlen($titulo)>100) $erro='Informe o título (até 100 caracteres).';
      elseif($desc===''||mb_strlen($desc)>250) $erro='Informe a descrição (até 250 caracteres).';
      elseif(!is_numeric($preco)||$preco<0) $erro='Preço inválido.';
      elseif(!$dt||$dt->format('Y-m-d')!==$data) $erro='Data de lançamento inválida.';
      elseif(!in_array($cls,['L','10','12','14','16','18'])) $erro='Escolha a classificação etária.';
      elseif(!is_numeric($tam)||$tam<0) $erro='Tamanho do download inválido.';
      elseif(mb_strlen($rmin)>250||mb_strlen($rrec)>250) $erro='Requisitos: até 250 caracteres cada.';
      elseif($devNovo===''&&empty($f['dev'])) $erro='Escolha ou cadastre a desenvolvedora.';
      elseif($pubNovo===''&&empty($f['pub'])) $erro='Escolha ou cadastre a publicadora.';
      elseif(mb_strlen($devNovo)>50) $erro='Nome da desenvolvedora: até 50 caracteres.';
      elseif(mb_strlen($pubNovo)>100) $erro='Nome da publicadora: até 100 caracteres.';
      elseif(empty($f['cats'])) $erro='Marque ao menos uma categoria.';
      else{
        try{
          $id=Jogo::criar(['titulo'=>$titulo,'descricao'=>$desc,'preco'=>$preco,'data'=>$data,'classificacao'=>$cls,'tamanho'=>$tam,
            'rmin'=>($rmin!==''?$rmin:'Não se aplica'),'rrec'=>($rrec!==''?$rrec:'Não se aplica'),
            'dev'=>$f['dev']??0,'devNovo'=>$devNovo,'pub'=>$f['pub']??0,'pubNovo'=>$pubNovo],$f['cats'],$f['plats']??[]);
          $msg='Jogo adicionado com sucesso!';
          if(!empty($_FILES['capa']['name'])){ $e=salvarCapa($_FILES['capa'],$id); if($e) $msg='Jogo adicionado, mas a capa falhou: '.$e; }
          $this->flash($msg); $this->go('admin_jogos');
        }catch(Exception $x){ $erro='Erro no banco: '.$x->getMessage(); }
      }
    }
    $l=Jogo::listas(); $recentes=Jogo::ultimos();
    $this->view('admin_jogos',compact('erro','f','l','recentes'));
  }
}