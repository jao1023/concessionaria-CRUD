create database concessionaria;
use concessionaria;

create table veiculos(
id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
modelo VARCHAR(255) NOT NULL,
ano INT NOT NULL,
marca VARCHAR(150) NOT NULL,
placa VARCHAR(8) NOT NULL UNIQUE,
descricao varchar(255) NOT NULL,
created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

 
INSERT INTO veiculos (modelo, ano, marca, descricao, placa)
VALUES
('Omega', '1992', 'Chevrolet', 'Sedan clássico com motor potente e ótimo conforto.', 'MOI-1N23'),
('Corvette C6', '2008', 'Chevrolet', 'Esportivo americano com motor V8 e design agressivo.', 'ELO-N123'),
('BMW M3 E46', '2004', 'BMW', 'Ícone dos esportivos alemães, equilíbrio entre performance e luxo.', 'WIL-M333'),
('Dodge Charger R/T', '2015', 'Dodge', 'Sedan musculoso com motor HEMI V8.', 'BOB-M999'),
('Audi RS7', '2021', 'Audi', 'Cupê esportivo de quatro portas com tração quattro.', 'CRI-3244'),
('Mustang GT500', '2018', 'Ford', 'Versão extrema do Mustang com motor supercharged.', 'BOR-9977');


select * from veiculos;

 create table vendedores(
 id INT PRIMARY KEY AUTO_INCREMENT,
 primeiro_nome VARCHAR(150) NOT NULL,
 ultimo_nome VARCHAR(150) NOT NULL,
 cpf VARCHAR(12) UNIQUE NOT NULL,
 email VARCHAR(150) UNIQUE NOT NULL,
 password VARCHAR(255) NOT NULL
 );
 
 SELECT * FROM vendedores
