CREATE TABLE test.contatos (
   id BIGINT auto_increment NOT NULL,
   nome varchar(100) NULL,
   telefone varchar(100) NULL,
   email varchar(100) NULL,
   data_criacao DATE NOT NULL,
   logo varchar(100) NULL,
   CONSTRAINT contatos_PK PRIMARY KEY (id)
)
ENGINE=InnoDB
DEFAULT CHARSET=latin1
COLLATE=latin1_swedish_ci;
