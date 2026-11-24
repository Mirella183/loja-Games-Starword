<?php
session_start();
require __DIR__.'/config.php';
spl_autoload_register(function($c){foreach(['core','controllers','models'] as $d){$f=__DIR__."/$d/$c.php"; if(is_file($f)){require $f;return;}}});
function e($s){return htmlspecialchars((string)$s,ENT_QUOTES,'UTF-8');}
function brl($v){return 'R$'.number_format((float)$v,2,',','.');}

function avatar($id){
  foreach(['jpg','png','webp'] as $x){
    $f=__DIR__.'/../public/uploads/avatars/'.$id.'.'.$x;
    if(is_file($f)) return 'uploads/avatars/'.$id.'.'.$x.'?v='.filemtime($f);
  }
  return null;
}

function capa($id){
  foreach(['jpg','png','webp'] as $x){
    $f=__DIR__.'/../public/uploads/jogos/'.$id.'.'.$x;
    if(is_file($f)) return 'uploads/jogos/'.$id.'.'.$x.'?v='.filemtime($f);
  }
  return null;
}

function salvarCapa($f,$id){
  if($f['error']!==UPLOAD_ERR_OK) return 'Falha no envio da imagem (máximo de 2 MB).';
  if($f['size']>2*1024*1024) return 'A imagem deve ter no máximo 2 MB.';
  $info=@getimagesize($f['tmp_name']);
  $ext=['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp'][$info['mime']??'']??null;
  if(!$ext) return 'Use uma imagem JPG, PNG ou WEBP.';
  $dir=__DIR__.'/../public/uploads/jogos';
  if(!is_dir($dir)) mkdir($dir,0777,true);
  foreach(['jpg','png','webp'] as $x) @unlink("$dir/$id.$x");
  return move_uploaded_file($f['tmp_name'],"$dir/$id.$ext") ? null : 'Não foi possível salvar a imagem.';
}

function tiles($jogos,$n,$cls){
  for($i=0;$i<$n;$i++){
    if(isset($jogos[$i])){ $j=$jogos[$i]; $img=capa($j['id_jogo']);
      echo '<a class="tile '.$cls.'" href="index.php?r=jogo&id='.(int)$j['id_jogo'].'" title="'.e($j['titulo']).'">';
      echo '<div class="cover">'.($img?'<img src="'.$img.'" alt="">':'<small>colocar imagem</small>').'</div>';
      echo '<div class="info"><b>'.e($j['titulo']).'</b><em>'.((float)$j['preco']<=0?'Grátis':brl($j['preco'])).'</em></div></a>';
    } else echo '<div class="tile empty '.$cls.'"></div>';

  }
}
function foto($id){
  $i=capa($id);
  return '<span class="foto" style="display:inline-grid;place-items:center;width:64px;height:64px;overflow:hidden;background:#fff;border-radius:4px;vertical-align:middle;margin-right:10px;font-size:9px;text-align:center">'
    .($i?'<img src="'.$i.'" alt="" style="width:100%;height:100%;object-fit:cover;display:block">':'Foto do jogo')
    .'</span>';
}