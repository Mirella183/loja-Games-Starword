<?php
class AuthController extends Controller{

  function login(){ $erro=null;
    if($this->post()){ $u=Usuario::login(trim($_POST['id']??''));
      if($u && password_verify($_POST['senha']??'',$u['senha'])){
        $_SESSION['u']=['id'=>$u['id_usuario'],'nick'=>$u['nickname'],'admin'=>Usuario::ehAdmin($u['id_usuario'])];
        $this->go('home');
      }
      $erro='Usuário ou senha inválidos.';
    }
    $this->view('login',compact('erro'));
  }

  function registrar(){ $erro=null;
    if($this->post()){
      $n=trim($_POST['nick']??''); $em=trim($_POST['email']??''); $s=$_POST['senha']??'';
      $d=(int)($_POST['dia']??0); $m=(int)($_POST['mes']??0); $a=(int)($_POST['ano']??0);
      if(mb_strlen($n)<6) $erro='O nickname precisa ter mais de 5 caracteres.';
      elseif(!filter_var($em,FILTER_VALIDATE_EMAIL)) $erro='Email inválido.';
      elseif(strlen($s)<6) $erro='A senha precisa ter ao menos 6 caracteres.';
      elseif(!checkdate($m,$d,$a)) $erro='Data de nascimento inválida.';
      else{
        try{
          if(Usuario::existe($n,$em)) $erro='Nickname ou email já cadastrado.';
          else{
            Usuario::criar($n,$em,$s,sprintf('%04d-%02d-%02d',$a,$m,$d));
            $this->flash('Conta criada! Faça login.');
            $this->go('login');
          }
        }catch(Exception $x){ $erro='Erro no banco: '.$x->getMessage(); }
      }
    }
    $this->view('registrar',compact('erro'));
  }

  function perfil(){ $this->auth(); $u=Usuario::find($this->user()['id']); $erro=null;
    if($this->post()){
      $n=trim($_POST['nick']??''); $s=$_POST['senha']??'';
      if(mb_strlen($n)<6) $erro='O nickname precisa ter mais de 5 caracteres.';
      elseif(DB::q("SELECT 1 FROM Usuarios WHERE nickname=? AND id_usuario<>?",[$n,$u['id_usuario']])->fetch()) $erro='Nickname em uso.';
      else{
        if(!empty($_FILES['foto']['name'])) $erro=$this->salvarFoto($u['id_usuario']);
        if(!$erro){
          Usuario::atualizar($u['id_usuario'],$n,$s!==''?$s:null);
          $_SESSION['u']['nick']=$n;
          $this->flash('Perfil atualizado.');
          $this->go('perfil');
        }
      }
    }
    $this->view('perfil',compact('u','erro'));
  }

  private function salvarFoto($id){
    $f=$_FILES['foto'];
    if($f['error']!==UPLOAD_ERR_OK) return 'Falha no envio da foto (máximo de 2 MB).';
    if($f['size']>2*1024*1024) return 'A foto deve ter no máximo 2 MB.';
    $info=@getimagesize($f['tmp_name']);
    $ext=['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp'][$info['mime']??'']??null;
    if(!$ext) return 'Use uma imagem JPG, PNG ou WEBP.';
    $dir=__DIR__.'/../../public/uploads/avatars';
    if(!is_dir($dir)) mkdir($dir,0777,true);
    foreach(['jpg','png','webp'] as $x) @unlink("$dir/$id.$x");
    return move_uploaded_file($f['tmp_name'],"$dir/$id.$ext") ? null : 'Não foi possível salvar a foto.';
  }

  function sair(){ session_destroy(); header('Location: index.php'); exit; }
}