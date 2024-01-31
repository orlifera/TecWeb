drop table if exists utente;

create table utente (
  nome varchar(255) not null,
  cognome varchar(255) not null,
  dataNascita date not null,
  genere varchar(255) not null,
  username varchar(255) not null UNIQUE,
  email varchar(255) not null UNIQUE,
  password varchar(255) not null,
  telefono varchar(16) not null,
  citta varchar(255) not null,
  indirizzo varchar(255) not null,
  CAP int(5) not null,
  tipo enum('A', 'U') not null default 'U',
  primary key(email)
) ENGINE = InnoDB default CHARSET = utf8mb4;

drop table if exists Prodotto;

CREATE TABLE Prodotto (
  sku varchar(6) not null,
  nome varchar(256) not null,
  tipo varchar(256) not null,
  descrizione varchar(256) not null,
  prezzo double not null,
  colore varchar(256) not null,
  disponibilita int not null,
  path_immagine varchar(256) not null,
  categoria varchar(6) not null,
  riferimento varchar(6) null,
  primary key(sku),
  unique key(nome)
) Engine = InnoDB default charset = utf8mb4;

drop table if exists OrdineProdotto;
CREATE TABLE OrdineProdotto (
  id_ordine int(10) not null,
  sku_prodotto varchar(6) not null,
  primary key(id_ordine, sku_prodotto),
  foreign key(id_ordine) references Ordine(id),
  foreign key(sku_prodotto) references Prodotto(sku)
) Engine=InnoDB default charset=utf8mb4;

drop table if exists Sconto;

CREATE TABLE Sconto (
  codice varchar(256) primary key,
  data_emissione timestamp not null,
  data_scadenza timestamp not null,
  username varchar(255),
  isUsed boolean default false,
  valore double not null
) Engine = InnoDB default charset = utf8mb4;

drop table if exists Carrello;

CREATE TABLE Carrello (
  sku varchar(6) not null,
  nome varchar(256) not null,
  tipo varchar(256) not null,
  prezzo double not null,
  colore varchar(256) not null,
  quantitaScelta int not null,
  path_immagine varchar(256) not null,
  categoria varchar(6) not null,
  utente varchar(255),
  foreign key (utente) references utente(username),
  primary key(sku),
  foreign key (sku) references Prodotto(sku)
) Engine = InnoDB default charset = utf8mb4;

DROP TABLE IF EXISTS Ordine;

CREATE TABLE Ordine (
  id int(10) primary key auto_increment not null,
  nome varchar(256) not null,
  cognome varchar(256) not null,
  email varchar(256) not null,
  numero varchar(256) not null,
  indirizzo varchar(256) not null,
  citta varchar(256) not null,
  cap int(5) not null,
  quantitaOrdinata int not null,
  prezzo varchar(256) not null,
  oggetti_ordinati varchar(256) not null
) Engine=InnoDB default charset=utf8mb4;


INSERT INTO Prodotto VALUES 
("P1", "Bull's Eye", "Gaming", "Il pc è composto da un Ryzen 5 5600,16GB di RAM a 3200Mhz e 1TB di SSD. Ha una RTX 3050 ed è alimentato da una PSU 650W. Il sistema raffreddato da un dissipatore a liquido Itek RGB a 240mm. Include il sistema operativo Windows 10 PRO.", 1320, "Nero, Bianco", 10, "../../assets/images/pc/P1.jpg", "pc", null),

("P2", "Elite", "Gaming", "Il pc è composto da un Ryzen 5 5600x, 16 GB di RAM a 3200Mhz e 1TB di ssd. Ha una 6700xt e il sistema viene alimentato da una PSU 750W. Il sistema è raffreddato da un dissipatore a liquido della Corsair. Include il sistema operativo Windows 10 PRO.", 1556, "Nero, Bianco", 10, "../../assets/images/pc/P2.jpg", "pc", null),

("P3", "Ice White", "Gaming", "Il pc è composto da un Ryzen 7 7700x, 32gb di RAM a 6400Mhz due NVMe per un totale di 1,5 TB. Ha una 7900xt e il sistema viene alimentato da una PSU 850W. Come dissipatore monta un nzxt da 240mm RGB. Include il sistema operativo Windows 10 PRO.", 2399.99,"Nero, Bianco" , 10, "../../assets/images/pc/P3.jpg", "pc", null),

("P4", "Blue Obsidian", "Gaming", "Il pc è composto da un i7 12700KF, 16GB di RAM 5200MT/s Kingston e 1TB di NVMe. Ha una RTX 4070 e il sistema viene alimentato da una PSU da 850W, raffreddato a liquido con un dissipatore della NZXT. Include il sistema operativo Windows 10 PRO.", 2035.39, "Nero, Bianco" , 10, "../../assets/images/pc/P4.jpg", "pc", null),

("P5", "Vertigo", "Gaming", "Il pc è composto da un Intel i5 12400F, 16gb di RAM 5600Mhz della Corsaire 1TB di NVMe. Ha una Radeon RX6700xt e il sistema alimentato da una PSU da 750W. Dissipato ad aria con un dissipatore da 120mm RGB. Include il sistema operativo Windows 10 PRO.", 1331.99,"Nero, Bianco" , 10, "../../assets/images/pc/P5.jpg", "pc", null),

("P6", "Deep Space", "Gaming", "Il pc assemblato è composto da un Intel 12400F, 16GB di RAM a 3200mhz e 1TB di SSD. Ha una RX6600  e il sistema è alimentato da una PSU 650W. Include il sistema operativo Windows 10 PRO.", 1426,"Nero, Bianco" , 10, "../../assets/images/pc/P6.jpg", "pc", null),

("P7", "Evolution", "Gaming", "Il pc assemblato è composto da un 12900kf, 32GB di RAM DDR5 e 2TB di NVMe. Ha una rx 6900xt e il sistema è alimentato da una PSU da 850W. Include il sistema operativo Windows 10 PRO e scheda wifi integrata. ", 3729.99,"Nero, Bianco" , 10, "../../assets/images/pc/P7.jpg", "pc", null),

("P8", "Flow", "Gaming", "Il pc assemblato composto da un Intel Ryzen 7 7800x, 32gb di RAM DDR5 a 6000Mhz della Kingston RGB e 2TB di NVMe. Ha una RTX 3070ti come scheda video e il sistema alimentato da un PSU da 850W. Include il sistema operativo Windows 10 PRO.", 2405,"Nero, Bianco" , 10, "../../assets/images/pc/P8.jpg", "pc", null),

("P9", "Golden Dragon", "Gaming", "Il pc assemblato è composto da un 11900k, 32gb RAM a 3600 Mhz RGB 1.5TB di NVMe. Ha una RTX 3070TI e il sistema è alimentato da 750W di alimentatore. Include il sistema operativo Windows 10 PRO.", 2556,"Nero, Bianco" , 10, "../../assets/images/pc/P9.jpg", "pc", null),

("T1", "Function (German ISO)", "Gaming", "Pensata per chi preferisce le tastiere full size ma non troppo ingombranti, la tastiera Function Full NZXT riunisce 104 tasti mantenendo le dimensioni più compatte possibili.", 139.00, "Nero, Bianco" , 10, "../../assets/images/kbd/T1.jpg", "kbd", null),

("T2", "Function (French ISO)", "Gaming", "Pensata per chi preferisce le tastiere full size ma non troppo ingombranti, la tastiera Function Full NZXT riunisce 104 tasti mantenendo le dimensioni più compatte possibili.", 139.00,"Nero, Bianco" , 10, "../../assets/images/kbd/T2.jpg", "kbd", null),

("T3", "Function Tenkeyless (German ISO)", "Gaming", "Pensata per chi preferisce le tastiere full size ma non troppo ingombranti, la tastiera Function Full NZXT riunisce 104 tasti mantenendo le dimensioni più compatte possibili.", 139.00,"Nero, Bianco" , 10, "../../assets/images/kbd/T3.jpg", "kbd", null),

("T4", "Function Tenkeyless (French ISO)", "Gaming", "Pensata per chi preferisce le tastiere full size ma non troppo ingombranti, la tastiera Function Full NZXT riunisce 104 tasti mantenendo le dimensioni più compatte possibili.", 139.00,"Nero, Bianco" , 10, "../../assets/images/kbd/T4.jpg", "kbd", null),

("T5", "Function MiniTKL (German ISO)", "Gaming", "Pensata per chi preferisce le tastiere full size ma non troppo ingombranti, la tastiera Function Full NZXT riunisce 104 tasti mantenendo le dimensioni più compatte possibili.", 139.00,"Nero, Bianco" , 10, "../../assets/images/kbd/T5.jpg", "kbd", null),

("T6", "Function MiniTKL (French ISO)", "Gaming", "Pensata per chi preferisce le tastiere full size ma non troppo ingombranti, la tastiera Function Full NZXT riunisce 104 tasti mantenendo le dimensioni più compatte possibili.", 139.00,"Nero, Bianco" , 10, "../../assets/images/kbd/T6.jpg", "kbd", null),

("V1", "Artic E-sport Duo", "Ventola", "Ventola molto molto bella", 70.00,"Nero, Bianco" , 10, "../../assets/images/acc/V1.jpg", "acc", "pc"),

("V2", "Asus ROG RYUO", "Ventola", "Ventola molto molto moooolto bella", 180.00,"Nero, Bianco" , 10, "../../assets/images/acc/V2.jpg", "acc", "pc"),

("V3", "Be Quiet! BK022 Dark Rock Pro 4", "Ventola", "Ventola molto molto bella", 80.00,"Nero, Bianco" , 10, "../../assets/images/acc/V3.jpg", "acc", "pc");

INSERT INTO Sconto VALUES 
("S1C1", "2021-12-01 00:00:00", "2021-12-31 00:00:00", "user", true, 100),
("S2C2", "2021-12-01 00:00:00", "2021-12-31 00:00:00", "admin", false, 50);

INSERT INTO Ordine (nome, cognome, email, numero, indirizzo, citta, cap, quantitaOrdinata, prezzo, oggetti_ordinati) VALUES ("ciao", "ciao","ciaociao@gmail.com", "837283728", "nucenuec", "ciidw", 25412, 6, 736362, "Bull's Eye, Elite");