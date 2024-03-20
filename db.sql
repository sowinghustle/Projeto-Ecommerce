CREATE TABLE client (
    id int not null auto_increment,
    username varchar(80) not null,
    email varchar(200) not null,
    password text not null,
    PRIMARY KEY (id)
);
