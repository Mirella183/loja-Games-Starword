<?php
abstract class Controller{
  protected function view($v,$d=[],$layout='main'){ extract($d); $content=APP.'/views/pages/'.$v.'.php'; include APP.'/views/layouts/'.$layout.'.php'; }
  protected function go($r,$q=''){ header('Location: index.php?r='.$r.$q); exit; }
  protected function user(){ return $_SESSION['u']??null; }
  protected function auth(){ if(!$this->user()) $this->go('login'); }
  protected function flash($m){ $_SESSION['flash']=$m; }
  protected function post(){ return $_SERVER['REQUEST_METHOD']==='POST'; }
}
