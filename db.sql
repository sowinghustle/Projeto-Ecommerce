CREATE TABLE client (
    id int not null auto_increment,
    username varchar(80) not null,
    email varchar(200) not null,
    password text not null,
    PRIMARY KEY (id)
);

INSERT INTO client (
    username, 
    email,
    password
) VALUES (
    "user",
    "user@admin.com",
    "12345678"
);
