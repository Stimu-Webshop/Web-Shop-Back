drop database if exists stimu;

create database stimu;

use stimu;


create table product_category (
    id int auto_increment,
    name varchar(255) not null,
    description text,
    PRIMARY KEY (id)
);

create table product_inventory (
    id INT AUTO_INCREMENT,
    quantity INT NOT NULL,
    PRIMARY KEY (id)
);


create table product (
    id int primary key auto_increment,
    name varchar(255) not null,
    description text not null,
    img varchar(255) not null,
    price decimal(10,2) not null,
    category_id int not null,
    inventory_id int not null,
    FOREIGN KEY (category_id) REFERENCES product_category(id),
    FOREIGN KEY (inventory_id) REFERENCES product_inventory(id)

);

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
);

create table shopping_session (
    id int primary key auto_increment,
    user_id int not null,
    total decimal(10,2) not null,
    FOREIGN KEY (user_id) REFERENCES user(id)
);

create table shopping_cart (
    id int primary key auto_increment,
    session_id int not null,
    product_id int  not null,
    quantity int not null,
    FOREIGN KEY (session_id) REFERENCES shopping_session(id),
    FOREIGN KEY (product_id) REFERENCES product(id)
);





create table admin_type (
    id int primary key auto_increment,
    admin_type varchar(255) not null,
    permissions varchar(255) not null
);



create table admin_user (
    id int primary key auto_increment,
    username varchar(255) not null,
    password varchar(255) not null,
    first_name varchar(255) not null,
    last_name varchar(255) not null,
    type_id int not null,
    FOREIGN KEY (type_id) REFERENCES admin_type(id)
);




