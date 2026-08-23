CREATE DATABASE PI_FisioAna
USE PI_FisioAna

CREATE TABLE Usuarios (
idUsuario INT PRIMARY KEY AUTO_INCREMENT,
nmUsuario VARCHAR(75) NOT NULL,
cpf CHAR(11) NOT NULL UNIQUE,
dataNasc DATETIME,
email VARCHAR(50) NOT NULL UNIQUE,
celular CHAR(12) NOT NULL,
isAdmin BIT NOT NULL,
senha VARCHAR(255) NOT NULL,
codigoRecuperacaoSenha CHAR(6),
dtExpiracaoCodigoSenha DATETIME
)

CREATE TABLE PreConsultas (
idPreConsulta INT PRIMARY KEY AUTO_INCREMENT,
idUsuario INT,
nmDiaSemana VARCHAR(30) NOT NULL,
horarioInicial TIME NOT NULL,
horarioFinal TIME NOT NULL,
dtConsulta DATE,
localDor VARCHAR(150) NOT NULL,
tempoSintoma VARCHAR(100),
descricaoSintoma VARCHAR(500),
escalaDor TINYINT,
comorbidades VARCHAR(500),

CONSTRAINT fk_PreConsultas_Usuarios FOREIGN KEY(idUsuario) REFERENCES Usuarios (idUsuario)

)

CREATE TABLE Depoimentos (
idDepoimento INT PRIMARY KEY AUTO_INCREMENT,
dsDepoimento VARCHAR (255) NOT NULL,
nmPaciente VARCHAR(120) NULL,
ativo BIT NOT NULL DEFAULT 1
)

CREATE TABLE DepoimentosImagens(
idDepoimentoImagem INT PRIMARY KEY AUTO_INCREMENT,
idDepoimento INT,
caminhoArquivo VARCHAR(300),

CONSTRAINT fk_Depoimentos_Imagens_Depoimentos FOREIGN KEY(idDepoimento) REFERENCES Depoimentos(idDepoimento)
)