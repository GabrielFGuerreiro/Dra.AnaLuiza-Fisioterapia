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
dtConsulta DATE,
horarioInicial TIME NOT NULL,
horarioFinal TIME NOT NULL,
observacao VARCHAR(500),
respostaClinica VARCHAR(500),
status VARCHAR(30) NOT NULL DEFAULT 'pendente',

CONSTRAINT fk_PreConsultas_Usuarios FOREIGN KEY(idUsuario) REFERENCES Usuarios (idUsuario)
)

CREATE TABLE Depoimentos (
idDepoimento INT PRIMARY KEY AUTO_INCREMENT,
nmPaciente VARCHAR(120) NULL,
dsDepoimento VARCHAR (255) NOT NULL,
caminhoArquivo VARCHAR(300),
dtExclusao DATETIME,
ativo BIT NOT NULL DEFAULT 1
)

CREATE TABLE tiposDocumento (
    idTipoDocumento INT PRIMARY KEY AUTO_INCREMENT,
    nmTipo VARCHAR(50) UNIQUE NOT null,
    dtRemocao DATETIME
);

CREATE TABLE documentos (
    idDocumento INT PRIMARY KEY AUTO_INCREMENT,
    nmDocumento VARCHAR(200) NOT null,
    idTipoDocumento INT NOT null,
    caminhoDocumento VARCHAR(500) NOT null,
    dataEnvio DATETIME NOT NULL,
    idUsuarioPaciente INT NOT null,
    dataRemocao DATETIME,

    CONSTRAINT fk_documentos_tipo
        FOREIGN KEY (idTipoDocumento)
        REFERENCES tiposDocumento(idTipoDocumento),

    CONSTRAINT fk_documentos_usuario
        FOREIGN KEY (idUsuarioPaciente)
        REFERENCES usuarios(idUsuario)
);