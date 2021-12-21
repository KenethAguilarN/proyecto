/*
Universidad de Costa Rica
IF4101 - Lenguajes para Aplicaciones Comerciales
Lic. Olivier Blanco Sandí
Práctica 8: Exportacion de Datos

ÚLTIMA MODIFICACIÓN: 06-05-2020
*/

drop database if exists db_practica_8;
create database db_practica_8;
use db_practica_8;

create table personas(
	id_persona int auto_increment primary key,
    nombre varchar(200),
    fecha_inicio date,
    fecha_fin date,
    provincia varchar(20),
    descripcion text
);


create table usuarios(
	id_usuario int auto_increment primary key,
    nombre varchar(200),
    user varchar(50) unique, -- no debe existir 2 usuarios con el mismo nombre
    pass varchar(100)
);



/* PROCEDIMIENTOS */

delimiter //

create procedure sp_insert_persona (
	in nombre varchar(200),
    in fecha_inicio date,
    in fecha_fin date,
    in provincia varchar(20),
    in descripcion text
)
begin
    insert into personas (nombre, fecha_inicio, fecha_fin, provincia, descripcion) 
    values (nombre, fecha_inicio, fecha_fin, provincia, descripcion);
end//

delimiter ;


delimiter //

create procedure sp_update_persona (
	in id_persona int,
	in nombre varchar(200),
    in fecha_inicio date,
    in fecha_fin date,
    in provincia varchar(20),
    in descripcion text
)
begin
    update personas p set
    p.nombre = nombre,
    p.fecha_inicio = fecha_inicio,
    p.fecha_fin = fecha_fin,
    p.provincia = provincia,
    p.descripcion = descripcion
    where p.id_persona = id_persona;
end//

delimiter ;



delimiter //

create procedure sp_delete_persona (
	in id int
)
begin
    delete from personas
    where id_persona = id;
end//

delimiter ;


delimiter //

create procedure sp_get_persona (
	in id int
)
begin
    select * from personas
    where id_persona = id;
end//

delimiter ;


delimiter //

create procedure sp_get_personas (
	in buscar varchar(200)
)
begin
    select * 
    from personas
    where nombre like concat('%', buscar, '%')
    order by nombre;
end//

delimiter ;




delimiter //

create procedure sp_get_usuario_login (
	in user varchar(50),
    in pass varchar(100)
)
begin
    select * 
    from usuarios u
    where u.user = user and u.pass = pass;
end//

delimiter ;




/* DATOS POR DEFECTO */

insert into usuarios values (1, 'Hortencio Flores', 'admin', '202cb962ac59075b964b07152d234b70');
insert into usuarios values (2, 'Lázaro Vives', 'lazaro', '202cb962ac59075b964b07152d234b70');
insert into usuarios values (3, 'Facundo Cabral', 'facundo', '202cb962ac59075b964b07152d234b70');



/* DATOS POR DEFECTO */

call sp_insert_persona('Juan', '2020-01-15', '2020-04-15', 'Alajuela', 'Lorem ipsum dolor');
call sp_insert_persona('Maria', '2020-02-15', '2020-03-15', 'Heredia', 'Lorem ipsum dolor');
call sp_insert_persona('Jacinto', '2020-02-15', '2020-03-15', 'Heredia', 'Lorem ipsum dolor');
call sp_insert_persona('Jacinto', '2020-02-15', '2020-03-15', 'Heredia', 'Lorem ipsum dolor');
call sp_insert_persona('Felicia', '2020-02-15', '2020-03-15', 'Guanacaste', 'Lorem ipsum dolor');
call sp_insert_persona('Peter Parker', '2020-02-15', '2020-03-15', 'Heredia', 'Lorem ipsum dolor');



-- Testing
call sp_update_persona(1, 'Juan', '2019-12-15', '2020-04-15', 'Alajuela', 'Lorem ipsum dolor');
call sp_delete_persona(3);
call sp_get_personas('');
call sp_get_persona(1);