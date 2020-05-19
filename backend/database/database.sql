CREATE TABLE users(
id              int(255) auto_increment not null,
name            varchar(50) NOT NULL,
username        varchar(100),
email           varchar(255) NOT NULL,
password        varchar(255) NOT NULL,
created_at      datetime DEFAULT NULL,
updated_at      datetime DEFAULT NULL,
remember_token  varchar(255),
CONSTRAINT pk_users PRIMARY KEY (id)
)ENGINE=InnoDB;

CREATE TABLE etiquetas(
    id          int(255) auto_increment not null,
    nombre      varchar(255) not null,
    color       varchar(255),
    created_at      datetime DEFAULT NULL, 
    updated_at      datetime DEFAULT NULL,
    CONSTRAINT pk_etiquetas PRIMARY KEY (id),
)ENGINE=InnoDB;

CREATE TABLE tasks(
id              int(255) auto_increment not null,
user_id         int(255) not null,
etiqueta_id     int(255) not null,
description     text,
estado          varchar(255),
created_at      datetime DEFAULT NULL, 
updated_at      datetime DEFAULT NULL,
CONSTRAINT pk_tasks PRIMARY KEY (id),
CONSTRAINT fk_tasks_user FOREIGN KEY(user_id) REFERENCES users(id),
CONSTRAINT fk_tasks_etiqueta FOREIGN KEY(etiqueta_id) REFERENCES etiquetas(id)
)ENGINE=InnoDB;