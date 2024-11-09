CREATE DATABASE IF NOT EXISTS appDB;
CREATE USER IF NOT EXISTS 'user'@'%' IDENTIFIED BY 'password';
GRANT SELECT,UPDATE,INSERT,DELETE ON appDB.* TO 'user'@'%';
FLUSH PRIVILEGES;

USE appDB;

CREATE TABLE IF NOT EXISTS materials (
  id INT(11) AUTO_INCREMENT,
  name VARCHAR(40) NOT NULL,
  PRIMARY KEY (id)
);


INSERT INTO materials (name) VALUES
('Золото'), ('Серебро');

CREATE TABLE IF NOT EXISTS products (
  id INT AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  price int NOT NULL,
  mat_id int not null,
  PRIMARY KEY (id),
  FOREIGN KEY (mat_id) REFERENCES materials (id)
);

INSERT INTO products (name, price, mat_id) VALUES
('Кольцо 1', 10000, 1), ('Колье 1', 15000, 2), 
('Серьги', 3000, 1), ('Кольцо 2', 5000, 2);


CREATE TABLE IF NOT EXISTS user_group (
    id INT AUTO_INCREMENT,
    name VARCHAR(20) NOT NULL,
    PRIMARY KEY (id)
);


INSERT INTO user_group (name) VALUES ('admin'), ('user');


CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT,
    name VARCHAR(20) NOT NULL,
    passwd VARCHAR(20) NOT NULL,
    group_id INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (group_id) REFERENCES user_group (id)
);


INSERT INTO users (name, passwd, group_id) VALUES 
('admin', '1234', 1), ('root', 'root', 1),
('user', '1234', 2), ('user1', 'user', 2), ('user2', 'user', 2);


CREATE TABLE IF NOT EXISTS pdf_files (
  id INT AUTO_INCREMENT,
  name TEXT NOT NULL,
  type TEXT NOT NULL,
  size INT NOT NULL,
  data longblob NOT NULL,
  PRIMARY KEY (id)
);


CREATE TABLE IF NOT EXISTS cities (
  id INT AUTO_INCREMENT,
  name TEXT NOT NULL,
  postcode VARCHAR(6) not null,
  number int not null,
  mayor text not null,
  country text not null,
  PRIMARY KEY(id)
);


CREATE TABLE IF NOT EXISTS graphs (
  id int AUTO_INCREMENT,
  name text not null,
  path text not null,
  PRIMARY key(id)
);