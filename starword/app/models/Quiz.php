<?php
class Quiz{
  static function ehQuiz($id){ return (bool)DB::q("SELECT 1 FROM Jogos_categorias jc JOIN Categorias c USING(id_categoria) WHERE jc.id_jogo=? AND c.nome LIKE 'Quiz%'",[$id])->fetch(); }

  static function quizzes(){ return DB::q("SELECT DISTINCT j.id_jogo,j.titulo,(SELECT COUNT(*) FROM quiz_perguntas q WHERE q.id_jogo=j.id_jogo) n
    FROM Jogos j JOIN Jogos_categorias jc USING(id_jogo) JOIN Categorias c USING(id_categoria) WHERE c.nome LIKE 'Quiz%' ORDER BY j.titulo")->fetchAll(); }

  static function perguntas($jogo){
    $ps=DB::q("SELECT * FROM quiz_perguntas WHERE id_jogo=? ORDER BY id_pergunta",[$jogo])->fetchAll();
    foreach($ps as &$p){ $p['opcoes']=DB::q("SELECT * FROM quiz_opcoes WHERE id_pergunta=? ORDER BY id_opcao",[$p['id_pergunta']])->fetchAll(); }
    return $ps;
  }

  static function pergunta($id,$jogo){
    $p=DB::q("SELECT * FROM quiz_perguntas WHERE id_pergunta=? AND id_jogo=?",[$id,$jogo])->fetch();
    if($p) $p['opcoes']=DB::q("SELECT * FROM quiz_opcoes WHERE id_pergunta=? ORDER BY id_opcao",[$id])->fetchAll();
    return $p;
  }

  static function criar($jogo,$pergunta,$textos,$correta){ $p=DB::pdo(); $p->beginTransaction();
    try{
      DB::q("INSERT INTO quiz_perguntas(id_jogo,pergunta) VALUES(?,?)",[$jogo,$pergunta]); $id=$p->lastInsertId();
      self::gravarOpcoes($id,$textos,$correta);
      $p->commit();
    }catch(Exception $e){ $p->rollBack(); throw $e; } }

  static function atualizar($id,$jogo,$pergunta,$textos,$correta){ $p=DB::pdo(); $p->beginTransaction();
    try{
      DB::q("UPDATE quiz_perguntas SET pergunta=? WHERE id_pergunta=? AND id_jogo=?",[$pergunta,$id,$jogo]);
      DB::q("DELETE FROM quiz_opcoes WHERE id_pergunta=?",[$id]);
      self::gravarOpcoes($id,$textos,$correta);
      $p->commit();
    }catch(Exception $e){ $p->rollBack(); throw $e; } }

  private static function gravarOpcoes($id,$textos,$correta){
    foreach($textos as $i=>$t){ if($t==='') continue; DB::q("INSERT INTO quiz_opcoes(id_pergunta,texto,correta) VALUES(?,?,?)",[$id,$t,$i===$correta?1:0]); } }

  static function remover($id,$jogo){ DB::q("DELETE FROM quiz_perguntas WHERE id_pergunta=? AND id_jogo=?",[$id,$jogo]); }

  static function salvarResultado($u,$jogo,$a,$t){ DB::q("INSERT INTO quiz_resultados(id_usuario,id_jogo,acertos,total) VALUES(?,?,?,?)",[$u,$jogo,$a,$t]); }
  static function melhor($u,$jogo){ return DB::q("SELECT acertos,total FROM quiz_resultados WHERE id_usuario=? AND id_jogo=? ORDER BY acertos/total DESC,id_resultado DESC LIMIT 1",[$u,$jogo])->fetch(); }
}