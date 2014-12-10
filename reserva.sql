create table role (
    id BIGINT NOT NULL auto_increment, 
    role varchar(50), 
    CONSTRAINT pk_role PRIMARY KEY (id)
);

create table user (
    id BIGINT NOT NULL auto_increment,
    login VARCHAR(50) NOT NULL,
    nome VARCHAR(128) NOT NULL,
    email VARCHAR(128) NOT NULL,
    id_role BIGINT,
    CONSTRAINT pk_user PRIMARY KEY (id),
    CONSTRAINT fk_user_role FOREIGN KEY (id_role) REFERENCES role (id)
);

create table estudio (
    id BIGINT NOT NULL auto_increment, 
    nome_estudio varchar(50) NOT NULL,
    CONSTRAINT pk_estudio PRIMARY KEY (id)
);

create table responsavel_estudio (
    id BIGINT NOT NULL auto_increment, 
    id_user BIGINT NOT NULL,
    id_estudio BIGINT NOT NULL, 
    CONSTRAINT pk_responsavel_estudio PRIMARY KEY (id),
    CONSTRAINT fk_responsavel_estudio_user FOREIGN KEY (id_user) REFERENCES user (id), 
    CONSTRAINT fk_responsavel_estudio_estudio FOREIGN KEY (id_estudio) REFERENCES estudio (id)
);

create table reserva (
    id BIGINT NOT NULL auto_increment, 
    id_user BIGINT NOT NULL,
    id_estudio BIGINT NOT NULL,
    inicio DATETIME NOT NULL, 
    fim DATETIME NOT NULL, 
    by_user BIGINT NOT NULL,
    status INT, 
    CONSTRAINT pk_reserva PRIMARY KEY (id),
    CONSTRAINT fk_reserva_user FOREIGN KEY(id_user) REFERENCES user (id),
    CONSTRAINT fk_reserva_estudio FOREIGN KEY(id_estudio) REFERENCES estudio (id),
    CONSTRAINT fk_reserva_user2 FOREIGN KEY(by_user) REFERENCES user (id)
);

create table indisponibilidade (
    id BIGINT NOT NULL auto_increment, 
    id_estudio BIGINT NOT NULL, 
    inicio DATETIME,
    fim DATETIME, 
    repetir TINYINT,
    CONSTRAINT pk_indisponibilidade PRIMARY KEY (id),
    CONSTRAINT fk_indisponibilidade_estudio FOREIGN KEY(id_estudio) REFERENCES estudio (id)
);


