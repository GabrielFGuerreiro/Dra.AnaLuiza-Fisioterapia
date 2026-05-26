CREATE DATABASE PI_FisioAna
USE PI_FisioAna

CREATE TABLE Usuarios (
idUsuario INT PRIMARY KEY AUTO_INCREMENT,
nmUsuario VARCHAR(75) NOT NULL,
cpf CHAR(11) NOT NULL UNIQUE,
dataNasc DATETIME NOT NULL,
email VARCHAR(50),
celular CHAR(12),
isAdmin BIT NOT NULL,
senha VARCHAR(255) NOT NULL
)

CREATE TABLE PreConsultas (
idPreConsulta INT PRIMARY KEY AUTO_INCREMENT,
idUsuario INT,
nmDiaSemana VARCHAR(30) NOT NULL,
horarioInicial TIME NOT NULL,
horarioFinal TIME NOT NULL,

CONSTRAINT fk_PreConsultas_Usuarios FOREIGN KEY(idUsuario) REFERENCES Usuarios (idUsuario)

)

CREATE TABLE Depoimentos (
idDepoimento INT PRIMARY KEY AUTO_INCREMENT,
idUsuario INT,
dsDepoimento VARCHAR (255) NOT NULL,

CONSTRAINT fk_Depoimentos_Usuarios FOREIGN KEY (idUsuario) REFERENCES Usuarios (idUsuario)

)