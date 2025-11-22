CREATE DATABASE IF NOT EXISTS eletrotech;
USE eletrotech;

CREATE TABLE Fornecedor (
    cnpj VARCHAR(18) PRIMARY KEY,
    nome_fantasia VARCHAR(100) NOT NULL,
    categoria VARCHAR(50),
    endereco VARCHAR(255),
    telefone VARCHAR(20),
    email VARCHAR(100)
);

CREATE TABLE Categoria (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nome_categoria VARCHAR(100) NOT NULL
);

CREATE TABLE Produto (
    sku VARCHAR(20) PRIMARY KEY,
    nome_produto VARCHAR(100) NOT NULL,
    descricao TEXT,
    preco_custo DECIMAL(10,2),
    preco_venda DECIMAL(10,2),
    estoque_atual INT DEFAULT 0,
    id_categoria INT,
    cnpj_fornecedor VARCHAR(18),
    FOREIGN KEY (id_categoria) REFERENCES Categoria(id_categoria) ON DELETE SET NULL,
    FOREIGN KEY (cnpj_fornecedor) REFERENCES Fornecedor(cnpj) ON DELETE SET NULL
);

CREATE TABLE Movimentacao_Estoque (
    id_movimentacao INT AUTO_INCREMENT PRIMARY KEY,
    sku_produto VARCHAR(20),
    tipo_movimentacao ENUM('Entrada', 'Saída') NOT NULL,
    quantidade INT NOT NULL,
    data_movimentacao DATE NOT NULL,
    FOREIGN KEY (sku_produto) REFERENCES Produto(sku)
);