<?php
class CheckoutController extends Controller{
  function pagamento(){ $this->auth(); $uid=$this->user()['id']; $itens=Carrinho::itens($uid); if(!$itens){$this->go('carrinho');} $total=Carrinho::total($itens);
    $metodo=$_GET['metodo']??($_POST['metodo']??'credito'); $erro=null; $f=$_POST; $f['email']=$f['email']??Usuario::find($uid)['email'];
    if($this->post()){
      if(isset($_POST['trocar'])) $metodo=$_POST['trocar'];
      else{ if(trim($f['nome']??'')===''||!filter_var($f['email'],FILTER_VALIDATE_EMAIL)||trim($f['telefone']??'')==='') $erro='Preencha os dados do comprador.';
        elseif($metodo==='pix'){ if(trim($f['chave']??'')===''||trim($f['cliente']??'')===''||($f['tipo']??'')==='') $erro='Preencha as informações do Pix.'; }
        else{ if(strlen(preg_replace('/\D/','',$f['cartao']??''))!==16) $erro='Número do cartão inválido.'; elseif(trim($f['nomecartao']??'')==='') $erro='Informe o nome do cartão.'; elseif(!preg_match('/^\d{2}\/\d{2}\/\d{4}$/',$f['validade']??'')) $erro='Validade inválida (DD/MM/AAAA).'; elseif(!preg_match('/^\d{3,4}$/',$f['cvv']??'')) $erro='CVV inválido.'; }
        if(!$erro){ $id=Pedido::criar($uid,$itens,$total,$metodo==='pix'?'pix':'cartao'); $this->go('confirmacao','&id='.$id); } } }
    $this->view('pagamento',compact('itens','total','metodo','erro','f'),'steps2'); }

  private function dadosNota(){ $this->auth(); $p=Pedido::find((int)($_GET['id']??0),$this->user()['id']); if(!$p) $this->go('home');
    return ['p'=>$p,'itens'=>Pedido::itens($p['id_pedido']),'cli'=>Usuario::find($this->user()['id']),'pg'=>Pedido::pagamento($p['id_pedido'])]; }

  function confirmacao(){ $this->view('confirmacao',$this->dadosNota(),'steps3'); }
  function nota(){ $this->view('nota',$this->dadosNota(),'blank'); }
}