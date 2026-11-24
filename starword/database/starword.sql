

CREATE TABLE IF NOT EXISTS Usuarios (
  id_usuario int PRIMARY KEY AUTO_INCREMENT,
  nickname varchar(100) UNIQUE NOT NULL,
  email varchar(100) UNIQUE NOT NULL,
  senha varchar(250) NOT NULL,
  data_nascimento DATE NOT NULL,
  status ENUM('ativo','inativo','banido') NOT NULL DEFAULT 'ativo',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CHECK (CHAR_LENGTH(nickname) > 5)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS Administradores (
  id_admin INT PRIMARY KEY AUTO_INCREMENT,
  id_usuario INT NOT NULL UNIQUE,
  cargo ENUM('moderador','suporte','gerente','desenvolvedor','super_admin') NOT NULL DEFAULT 'moderador',
  permissao_banir BOOLEAN DEFAULT TRUE,
  permissao_editar_jogos BOOLEAN DEFAULT FALSE,
  permissao_suporte BOOLEAN DEFAULT TRUE,
  permissao_gerenciar_usuarios BOOLEAN DEFAULT FALSE,
  permissao_gerenciar_pagamentos BOOLEAN DEFAULT FALSE,
  deletar_avaliacoes BOOLEAN DEFAULT FALSE,
  gerenciar_admins BOOLEAN DEFAULT FALSE,
  cpf CHAR(11) NULL UNIQUE,
  telefone VARCHAR(15) NULL,
  ativo BOOLEAN DEFAULT TRUE,
  ultimo_login DATETIME NULL,
  criado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario) ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS Desenvolvedoras (
  id_desenvolvedora INT PRIMARY KEY AUTO_INCREMENT,
  nome varchar(50) NOT NULL,
  data_fundacao date NOT NULL,
  pais VARCHAR(45) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS Publicadoras (
  id_publicadora INT PRIMARY KEY AUTO_INCREMENT,
  nome varchar(100) NOT NULL,
  pais VARCHAR(45) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS Jogos (
  id_jogo INT PRIMARY KEY AUTO_INCREMENT,
  id_desenvolvedora INT NOT NULL,
  id_publicadora INT NOT NULL,
  titulo varchar(100) NOT NULL,
  descricao varchar(250) NOT NULL,
  preco DECIMAL(10,2) NOT NULL,
  data_lancamento DATE NOT NULL,
  classificacao_etaria VARCHAR(3) NOT NULL,
  tamanho_download DECIMAL(10,2) NOT NULL,
  requisitos_minimos VARCHAR(250) NOT NULL,
  requisitos_recomendados VARCHAR(250) NOT NULL,
  FOREIGN KEY (id_desenvolvedora) REFERENCES Desenvolvedoras(id_desenvolvedora),
  FOREIGN KEY (id_publicadora) REFERENCES Publicadoras(id_publicadora)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS Categorias (
  id_categoria INT PRIMARY KEY AUTO_INCREMENT,
  nome VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS Jogos_categorias (
  id_JogoCategoria INT PRIMARY KEY AUTO_INCREMENT,
  id_jogo INT NOT NULL,
  id_categoria INT NOT NULL,
  FOREIGN KEY (id_jogo) REFERENCES Jogos(id_jogo),
  FOREIGN KEY (id_categoria) REFERENCES Categorias(id_categoria)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS plataformas (
  id_plataforma INT PRIMARY KEY AUTO_INCREMENT,
  nome VARCHAR(150) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS jogos_plataformas (
  id_jogo_plataformas INT PRIMARY KEY AUTO_INCREMENT,
  id_jogo INT NOT NULL,
  id_plataforma INT NOT NULL,
  FOREIGN KEY (id_jogo) REFERENCES Jogos(id_jogo),
  FOREIGN KEY (id_plataforma) REFERENCES plataformas(id_plataforma)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS Carrinho (
  id_carrinho INT PRIMARY KEY AUTO_INCREMENT,
  id_usuario INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS Carrinho_itens (
  id_item INT PRIMARY KEY AUTO_INCREMENT,
  id_carrinho INT NOT NULL,
  id_jogo INT NOT NULL,
  quantidade INT NOT NULL,
  FOREIGN KEY (id_carrinho) REFERENCES Carrinho(id_carrinho),
  FOREIGN KEY (id_jogo) REFERENCES Jogos(id_jogo)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS Pedidos (
  id_pedido INT PRIMARY KEY AUTO_INCREMENT,
  id_usuario INT NOT NULL,
  data_pedido DATE NOT NULL,
  valor_total decimal(10,2) NOT NULL,
  status ENUM('pendente','pago','cancelado') DEFAULT 'pendente',
  FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS Pedido_itens (
  id_item INT PRIMARY KEY AUTO_INCREMENT,
  id_pedido INT NOT NULL,
  id_jogo INT NOT NULL,
  preco_unitario DECIMAL(10,2) NOT NULL,
  FOREIGN KEY (id_pedido) REFERENCES Pedidos(id_pedido),
  FOREIGN KEY (id_jogo) REFERENCES Jogos(id_jogo)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS Pagamentos (
  id_pagamento INT PRIMARY KEY AUTO_INCREMENT,
  id_pedido INT NOT NULL,
  data_pagamento DATE NOT NULL,
  metodo ENUM('cartao','pix','boleto') NOT NULL,
  status ENUM('pendente','aprovado','recusado') DEFAULT 'pendente',
  FOREIGN KEY (id_pedido) REFERENCES Pedidos(id_pedido)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS Biblioteca (
  id_biblioteca int PRIMARY KEY AUTO_INCREMENT,
  id_usuario INT NOT NULL,
  id_jogo INT NOT NULL,
  data_compra date NOT NULL,
  FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario),
  FOREIGN KEY (id_jogo) REFERENCES Jogos(id_jogo)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS Avaliacoes (
  id_avaliacao INT PRIMARY KEY AUTO_INCREMENT,
  id_usuario INT NOT NULL,
  id_jogo INT NOT NULL,
  nota INT NOT NULL,
  comentario VARCHAR(100) NOT NULL,
  data_avaliacao DATE NOT NULL,
  UNIQUE (id_usuario, id_jogo),
  CHECK (nota >= 0 AND nota <= 5),
  FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario),
  FOREIGN KEY (id_jogo) REFERENCES Jogos(id_jogo)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS suporte (
  id_suporte INT PRIMARY KEY AUTO_INCREMENT,
  id_usuario INT NOT NULL,
  assunto VARCHAR(150) NOT NULL,
  descricao TEXT NOT NULL,
  categoria ENUM('Pagamento','Conta','Produto') NOT NULL,
  status ENUM('Aberto','Pendente','Resolvido','Fechado') NOT NULL,
  data_abertura DATETIME DEFAULT CURRENT_TIMESTAMP,
  data_fechamento DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS suporte_mensagens (
  id_mensagem INT PRIMARY KEY AUTO_INCREMENT,
  id_suporte INT NOT NULL,
  id_usuario INT NOT NULL,
  mensagem TEXT NOT NULL,
  data_envio DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_suporte) REFERENCES suporte(id_suporte),
  FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario)
) ENGINE=InnoDB;

-- Quiz
CREATE TABLE IF NOT EXISTS quiz_perguntas (
  id_pergunta INT PRIMARY KEY AUTO_INCREMENT,
  id_jogo INT NOT NULL,
  pergunta VARCHAR(250) NOT NULL,
  FOREIGN KEY (id_jogo) REFERENCES Jogos(id_jogo) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS quiz_opcoes (
  id_opcao INT PRIMARY KEY AUTO_INCREMENT,
  id_pergunta INT NOT NULL,
  texto VARCHAR(150) NOT NULL,
  correta BOOLEAN NOT NULL DEFAULT FALSE,
  FOREIGN KEY (id_pergunta) REFERENCES quiz_perguntas(id_pergunta) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS quiz_resultados (
  id_resultado INT PRIMARY KEY AUTO_INCREMENT,
  id_usuario INT NOT NULL,
  id_jogo INT NOT NULL,
  acertos INT NOT NULL,
  total INT NOT NULL,
  data_jogo DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario),
  FOREIGN KEY (id_jogo) REFERENCES Jogos(id_jogo)
) ENGINE=InnoDB;

-- Dados iniciais
INSERT INTO Categorias (nome)
SELECT * FROM (SELECT 'Tabuleiro' UNION SELECT 'Cartas' UNION SELECT 'Quizzes') t
WHERE NOT EXISTS (SELECT 1 FROM Categorias);

INSERT INTO plataformas (nome)
SELECT * FROM (SELECT 'PC' UNION SELECT 'Android' UNION SELECT 'iOS' UNION SELECT 'Web') t
WHERE NOT EXISTS (SELECT 1 FROM plataformas);