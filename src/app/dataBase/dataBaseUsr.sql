create database repositorio;

use repositorio;

create table trabajos_institucionales(
id_trabajos int auto_increment primary key not null,
titulo varchar (150) not null,
resumen varchar (250) not null,
gestion varchar (50) not null,
link_pdf varchar (300) not null,
id_mod int not null,
id_carrera int not null
);

create table carreras (
id_carrera int auto_increment primary key not null,
nombre_carrera varchar (100)
);

create table modalidad(
id_mod int auto_increment primary key not null,
tipo_documento varchar (100)
);

create table tutor(
id_tutor int auto_increment primary key not null,
nombre_tutor varchar (100),
apellido_tutor varchar(100) not null
);

create table autor(
id_autor int auto_increment primary key not null,
nombre_autor varchar (100) not null,
apellido_autor varchar(100) not null 
);

create table trabajos_tutor(
id_trabajos_tutor int auto_increment primary key not null,
id_trabajos int not null,
id_tutor int not null
);

create table trabajos_autor(
id_trabajos_tutor int auto_increment primary key not null,
id_trabajos int not null,
id_autor int not null
);

alter table trabajos_tutor
add constraint fk_trabajos foreign key (id_trabajos) references trabajos_institucionales(id_trabajos);

alter table trabajos_tutor
add constraint fk_tutor foreign key (id_tutor) references tutor(id_tutor);

alter table trabajos_autor
add constraint fk_trabajos_a foreign key (id_trabajos) references trabajos_institucionales(id_trabajos);

alter table trabajos_autor
add constraint fk_autor foreign key (id_autor) references autor(id_autor);

alter table trabajos_institucionales
add constraint fk_tra_mod foreign key (id_mod) references modalidad (id_mod);

alter table trabajos_institucionales
add constraint fk_tra_car foreign key (id_carrera) references carreras (id_carrera);
