CREATE TABLE inventory (
  id int NOT NULL AUTO_INCREMENT,
  make varchar(50),
  model varchar(50),
  year year(4),
  color varchar(50),
  mileage int,
  type varchar(50),
  price decimal(10, 2),
  transmission varchar(20),
  drive varchar(3),
  PRIMARY KEY(id)
);
