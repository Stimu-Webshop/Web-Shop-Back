drop database if exists stimu;

create database stimu;

use stimu;


create table product (
    id int primary key auto_increment,
    name varchar(255) not null,
    description text not null,
    img varchar(255) not null,
    price decimal(10,2) not null,
    category_id int foreign key not null,
    inventory_id int foreign key not null

)

create table product_category (
    id int primary key auto_increment,
    name varchar(255) not null,
    desc text
)

create table product_inventory (
    id int primary key auto_increment,
    quantity int not null
)

create table shopping_cart (
    id int primary key auto_increment,
    session_id int foreign key not null,
    product_id int foreign key not null,
    quantity int not null
)

create table shopping_session (
    id int primary key auto_increment,
    user_id int foreign key not null,
    total decimal(10,2) not null,
)

create table user (
    id int primary key auto_increment,
    username varchar(255) not null,
    password varchar(255) not null,
    first_name varchar(255) not null,
    last_name varchar(255) not null,
    email varchar(255) not null,
    telephone varchar(255) not null,
    address varchar(255) not null,
    city varchar(255) not null,
    postal_code varchar(255) not null,
    country varchar(255) not null
)

create table admin_type (
    id int primary key auto_increment,
    admin_type varchar(255) not null,
    permissions varchar(255) not null
)

)

create table admin_user (
    id int primary key auto_increment,
    username varchar(255) not null,
    password varchar(255) not null,
    first_name varchar(255) not null,
    last_name varchar(255) not null,
    type_id int foreign key not null
)




