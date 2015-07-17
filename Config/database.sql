--  Database Copyright 2014 by WebIS Spring 2014 License Apache 2.0

-- Person
DROP TABLE IF EXISTS Person;
CREATE TABLE Person (
  person VARCHAR(30),
  name VARCHAR(128),
  rate FLOAT,
  PRIMARY KEY (person)
);

-- Employee
DROP TABLE IF EXISTS Employee;
CREATE TABLE Employee (
  employee VARCHAR(30),
  name VARCHAR(128),
  rate FLOAT,
  PRIMARY KEY (employee)
);
INSERT INTO Employee (employee,name,rate) VALUES 
	('JoeAhlbrandt','Joe Ahlbrandt',10),
	('JDS','JD S',10);
-- SELECT * FROM Person;

-- Training Matrix
DROP TABLE IF EXISTS TrainingMatrix;
CREATE TABLE TrainingMatrix (
  person VARCHAR(30),
  workstation integer,
  training double,
  ergo double,
  PRIMARY KEY (person,workstation)
);

INSERT INTO TrainingMatrix (person,workstation,training,ergo) VALUES 
	('Dr.Middelkoop',1000,0.19,0.19),
	('JD',1000,0.90,0.10);

	
-- SELECT * FROM TrainingMatrix;
-- SELECT person,cell,w