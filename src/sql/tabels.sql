create table utente (
    username varchar(255) not null,
    nome varchar(255) not null,
    cognome varchar(255) not null,
    email varchar(255) not null,
    password varchar(255) not null,
    tipo enum('A', 'U') not null default 'U',
    primary key(username)
) Engine = InnoDB default charset = utf8mb4; 