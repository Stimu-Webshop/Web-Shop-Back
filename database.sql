-- drop database if exists stimu;

-- create database stimu;

-- use stimu;


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
    rating FLOAT(1) CHECK (rating >= 0 AND rating <= 5),
    review_text VARCHAR(255),
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
-- DEPRICATED, DATA NECCESSARY DATA TRANSFERED TO shopping_cart
-- create table shopping_session (
--     id int primary key auto_increment,
--     user_id int not null,
--     total decimal(10,2) not null,
--     FOREIGN KEY (user_id) REFERENCES user(id)
-- );

CREATE TABLE product_review (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT NOT NULL,
    rating TINYINT UNSIGNED CHECK (rating >=0 AND rating <=5),
    review_text VARCHAR(255),
    FOREIGN KEY (product_id) REFERENCES product (ID) ON DELETE CASCADE
);

create table shopping_cart (
    id int primary key auto_increment,
    user_id int not null,
    product_id int  not null,
    quantity int not null,
    total decimal(10,2) NOT NULL,
    FOREIGN KEY (product_id) REFERENCES product(id) on delete CASCADE,
    FOREIGN KEY (user_id) REFERENCES user(id) on delete CASCADE
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

create table contact_form (
    id int primary key AUTO_INCREMENT,
    first_name varchar(255) not null,
    last_name varchar(255) not null,    
    email VARCHAR(255) not null,
    address VARCHAR(255) not null,
    phone VARCHAR(255) not null, 
    message varchar(255), not null
)


TUOTELUOKKIEN LUONTILAUSEET

/* INSERT INTO product_category (id, name, description) VALUES
(1, Energiajuomat, Nämä ovat energiajuomia),
(2, Kahvit, Nämä ovat kahveja),
(3, Sekalainen, Nämä ovat sekalaisia);
*/



 -- ENERGIAJUOMIEN LUONTILAUSEET 

INSERT INTO product (id, name, description, img, price, category_id, inventory_id)
VALUES
(1,'Velocity Vibe','Kiihdytä vauhtiasi Velocity Vibe -juoman avulla, jonka avulla voit välttää hidasteet tiellä menestykseen.','https://www.students.oamk.fi/~n2rusa00/Stimu/Stimu%20product%20pictures/energydrink1.png',4.99,1,1)
(2,'Hyper Drive','Kokeile Hyper Driven voimaa, joka antaa sinulle nopean ja tehokkaan energiapotkun, jotta voit saavuttaa tavoitteesi helposti ja nopeasti.','https://www.students.oamk.fi/~n2rusa00/Stimu/Stimu%20product%20pictures/energydrink2.png',4.49,1,2),
(3,'Power Surge','Koe energian voima, joka antaa sinulle voimaa selviytyä pitkistä päivistä ja haastavista tehtävistä.','https://www.students.oamk.fi/~n2rusa00/Stimu/Stimu%20product%20pictures/Energydrink.png',4.99,1,3),
(4,'Thunderbolt Fuel','Kun tarvitset nopean ja tehokkaan annoksen energiaa, ThunderBolt Fuel on valintasi. Se antaa sinulle salamannopean vauhdin ja energian, joka kestää tuntikausia.','https://www.students.oamk.fi/~n2rusa00/Stimu/Stimu%20product%20pictures/energydrink4.png',3.99,1,4),
(5,'Electric Rush','Tämä sähköisesti latautunut juoma saa sinut heräämään henkiin, virittäen sinut päivän haasteisiin.','https://www.students.oamk.fi/~n2rusa00/Stimu/Stimu%20product%20pictures/energydrink5.png',2.99,1,5),
(6,'Atomic Energy','Tämä energiajuoma antaa sinulle ydinpommin kaltaisen voiman, joka pitää sinut täydessä käynnissä pitkän päivän ajan.','https://www.students.oamk.fi/~n2rusa00/Stimu/Stimu%20product%20pictures/energydrink6.png',7.99,6,1);


-- KAHVIEN LUONTILAUSEET

INSERT INTO product (id, name, description, img, price, category_id, inventory_id)
VALUES
(7,'Porvari___kahavi','Kirjaimellista kultaa','https://www.students.oamk.fi/~n2rusa00/Stimu/Stimu%20product%20pictures/coffeebeans.png',99.99,2,7),
(8,'Näyttää löftberiltä','Varmaan yhtä pahaakin','https://www.students.oamk.fi/~n2rusa00/Stimu/Stimu%20product%20pictures/coffeebeans2.png',1.49,2,8),
(9,'Alissaan','Kolmannen paahtoasteen suussasulavan pehmeä Arabialainen kahvi.','https://www.students.oamk.fi/~n2rusa00/Stimu/Stimu%20product%20pictures/alissan-kahvi.png',6.99,2,9),
(10,'Maststim','Stimuloi muutakin kuin aivoja','https://www.students.oamk.fi/~n2rusa00/Stimu/Stimu%20product%20pictures/maststim-kahvi.png',9.99,2,10),
(11,'Bariul','Kerätty verkkosivuntekijän omin pikku kätösin.','https://www.students.oamk.fi/~n2rusa00/Stimu/Stimu%20product%20pictures/Bariul%20coffee.png',29.99,2,11),
(12,'FaaLLL','Tällä kahvilla tipahtaa isompikin kaveri.','',24.99,2,12),
(13,'Pikku ryssä','Paketin tuoteseloste on venäjäksi, ja sivun tekijä ei puhu sitä. Todennäköisesti ei myrkyllistä.','https://www.students.oamk.fi/~n2rusa00/Stimu/Stimu%20product%20pictures/coffeebeans3.png',4.99,2,13);


-- SEKALAISTEN LUONTILAUSEET

  	