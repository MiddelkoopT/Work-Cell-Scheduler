--  Database Copyright 2014 by WebIS Spring 2014 License Apache 2.0

-- Person
DROP TABLE IF EXISTS Person;
CREATE TABLE Person (
  person VARCHAR(30),
  name VARCHAR(128),
  rate FLOAT,
  PRIMARY KEY (person)
);

-- SELECT * FROM Person;

-- Training Matrix
DROP TABLE IF EXISTS TrainingMatrix;
CREATE TABLE TrainingMatrix (
  person VARCHAR(30),
  cell integer,
  workstation integer,
  wcp double,
  wsp double,
  PRIMARY KEY (person,cell,workstation)
);

INSERT INTO TrainingMatrix (person,cell,workstation,wcp,wsp) VALUES 
	('Dr.Middelkoop',1000,1010,0.19,0.19),
	('Dr.Middelkoop',1000,1020,0.55,0.32),
	('JD',1000,1010,0.99,0.99),
	('JD',1000,1030,0.90,0.10);

	
-- SELECT * FROM TrainingMatrix;
-- SELECT person,cell,w