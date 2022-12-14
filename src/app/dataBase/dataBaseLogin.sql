create database login;

use login;

create table usuarios(
id_usuario int auto_increment primary key not null,
nombre_usuario varchar (100) not null,
email varchar(50) not null,
usuario varchar (50) not null,
contrasena varchar (200) not null
);

create table historial(
id int auto_increment primary key not null,
usuario varchar(50) not null,
fecha timestamp not null default  current_timestamp 
);
