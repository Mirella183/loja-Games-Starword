<?php
class Jogo{
  static function find($id){ return DB::q("SELECT j.*,d.nome dev,p.nome pub FROM Jogos j JOIN Desenvolvedoras d USING(id_desenvolvedora) JOIN Publicadoras p USING(id_publicadora) WHERE id_jogo=?",[$id])->fetch(); }
  static function maisJogados($n){ return DB::q("SELECT j.* FROM Jogos j LEFT JOIN Pedido_itens i USING(id_jogo) GROUP BY j.id_jogo ORDER BY COUNT(i.id_item) DESC, j.id_jogo LIMIT ".(int)$n)->fetchAll(); }
  static function recentes($n,$off=0){ return DB::q("SELECT * FROM Jogos ORDER BY data_lancamento DESC LIMIT ".(int)$n." OFFSET ".(int)$off)->fetchAll(); }
  static function porCategoria($nome,$n){ return DB::q("SELECT j.* FROM Jogos j JOIN Jogos_categorias jc USING(id_jogo) JOIN Categorias c USING(id_categoria) WHERE c.nome=? ORDER BY j.titulo LIMIT ".(int)$n,[$nome])->fetchAll(); }
  static function busca($q){ return DB::q("SELECT * FROM Jogos WHERE titulo LIKE ? ORDER BY titulo",['%'.$q.'%'])->fetchAll(); }
  static function biblioteca($u){ return DB::q("SELECT j.*,b.data_compra FROM Biblioteca b JOIN Jogos j USING(id_jogo) WHERE b.id_usuario=? ORDER BY b.data_compra DESC",[$u])->fetchAll(); }
  static function media($id){ return DB::q("SELECT AVG(nota) m,COUNT(*) t FROM Avaliacoes WHERE id_jogo=?",[$id])->fetch(); }

  static function listas(){ return [
    'devs'=>DB::q("SELECT id_desenvolvedora id,nome FROM Desenvolvedoras ORDER BY nome")->fetchAll(),
    'pubs'=>DB::q("SELECT id_publicadora id,nome FROM Publicadoras ORDER BY nome")->fetchAll(),
    'cats'=>DB::q("SELECT id_categoria id,nome FROM Categorias ORDER BY nome")->fetchAll(),
    'plats'=>DB::q("SELECT id_plataforma id,nome FROM plataformas ORDER BY nome")->fetchAll()]; }
  static function ultimos(){ return DB::q("SELECT id_jogo,titulo,preco,data_lancamento FROM Jogos ORDER BY id_jogo DESC LIMIT 15")->fetchAll(); }

  static function devId($id,$novo){ $novo=trim($novo); if($novo==='') return (int)$id;
    $x=DB::q("SELECT id_desenvolvedora FROM Desenvolvedoras WHERE nome=?",[$novo])->fetch(); if($x) return $x['id_desenvolvedora'];
    DB::q("INSERT INTO Desenvolvedoras(nome,data_fundacao,pais) VALUES(?,CURDATE(),'Não informado')",[$novo]); return DB::pdo()->lastInsertId(); }
  static function pubId($id,$novo){ $novo=trim($novo); if($novo==='') return (int)$id;
    $x=DB::q("SELECT id_publicadora FROM Publicadoras WHERE nome=?",[$novo])->fetch(); if($x) return $x['id_publicadora'];
    DB::q("INSERT INTO Publicadoras(nome,pais) VALUES(?,'Não informado')",[$novo]); return DB::pdo()->lastInsertId(); }

  static function criar($d,$cats,$plats){ $p=DB::pdo(); $p->beginTransaction();
    try{
      $dev=self::devId($d['dev'],$d['devNovo']); $pub=self::pubId($d['pub'],$d['pubNovo']);
      DB::q("INSERT INTO Jogos(id_desenvolvedora,id_publicadora,titulo,descricao,preco,data_lancamento,classificacao_etaria,tamanho_download,requisitos_minimos,requisitos_recomendados) VALUES(?,?,?,?,?,?,?,?,?,?)",
        [$dev,$pub,$d['titulo'],$d['descricao'],$d['preco'],$d['data'],$d['classificacao'],$d['tamanho'],$d['rmin'],$d['rrec']]);
      $id=$p->lastInsertId();
      foreach($cats as $c) DB::q("INSERT INTO Jogos_categorias(id_jogo,id_categoria) VALUES(?,?)",[$id,(int)$c]);
      foreach($plats as $c) DB::q("INSERT INTO jogos_plataformas(id_jogo,id_plataforma) VALUES(?,?)",[$id,(int)$c]);
      $p->commit(); return $id;
    }catch(Exception $e){ $p->rollBack(); throw $e; } }
  static function ehQuiz($id){ return (bool)DB::q("SELECT 1 FROM Jogos_categorias jc JOIN Categorias c USING(id_categoria) WHERE jc.id_jogo=? AND c.nome LIKE 'Quiz%'",[$id])->fetch(); }
  }