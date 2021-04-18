CREATE TABLE tb_categoria_produto
(
    id_categoria_planejamento INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome_categoria VARCHAR(150)
);


CREATE TABLE tb_produto
(
    id_produto INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_categoria_produto INT,
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP,
    nome_produto VARCHAR(150),
    valor_produto FLOAT(10,2)
);

CREATE TABLE tb_produto
(
    id_produto INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_categoria_produto INT NOT NULL,
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP,
    nome_produto VARCHAR(150),
    valor_produto FLOAT(10,2),
    FOREIGN KEY (id_categoria_produto) REFERENCES tb_categoria_produto(id_categoria_planejamento)
);

        