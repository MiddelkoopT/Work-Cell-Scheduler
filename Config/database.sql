--  Database Copyright 2014 by WebIS Spring 2014 License Apache 2.0

-- Person
DROP TABLE IF EXISTS Person;
CREATE TABLE Person (
	employeeid VARCHAR(30),
	employeename VARCHAR(30),
	PRIMARY KEY (employeeid)
);

INSERT INTO Person (employeeid,employeename) VALUES 
	('JB','Jen Bergman'),
	('JS','JD Stumpf'),
	('MD','Mike Daniel');

SELECT * FROM Person;


-- Subcell
DROP TABLE IF EXISTS Subcell;
CREATE TABLE Subcell (
	subcell integer,
	PRIMARY KEY (subcell)
);

INSERT INTO Subcell (subcell) VALUES 
	(1),
	(2),
	(3);

SELECT * FROM Subcell;


-- Training Matrix
DROP TABLE IF EXISTS TrainingMatrix;
CREATE TABLE TrainingMatrix (
  employeeid VARCHAR(30), 
  employeename VARCHAR(30),
  subcell integer,
  training integer,
  PRIMARY KEY (employeeid,subcell)
);

INSERT INTO TrainingMatrix (employeeid,employeename,subcell,training) VALUES 
	('JB','Jen Bergman',1,1),
	('JB','Jen Bergman',2,1),
	('JS','JD Stumpf',2,1),
	('MD','Mike Daniel',1,1),
	('MD','Mike Daniel',3,1);


SELECT * FROM TrainingMatrix;
SELECT training FROM TrainingMatrix WHERE employeeid='JB' AND subcell='1';

-- Ergo Score Matrix
DROP TABLE IF EXISTS ErgoMatrix;
CREATE TABLE ErgoMatrix (
  employeeid VARCHAR(30), 
  employeename VARCHAR(30),
  subcell integer,
  ergoscore double,
  PRIMARY KEY (employeeid,employeename,subcell)
);

INSERT INTO ErgoMatrix (employeeid,employeename,subcell,ergoscore) VALUES 
	('JB','Jen Bergman',1,.3),
	('JB','Jen Bergman',2,.4),
	('JS','JD Stumpf',2,.4),
	('MD','Mike Daniel',1,.6),
	('MD','Mike Daniel',3,.8);


SELECT * FROM ErgoMatrix;
