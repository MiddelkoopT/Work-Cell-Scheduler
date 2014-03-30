--  Database Copyright 2014 by WebIS Spring 2014 License Apache 2.0
-- Training Matrix
DROP TABLE IF EXISTS TrainingMatrix;
CREATE TABLE TrainingMatrix (
  worker_ID VARCHAR(30),
  worker_first VARCHAR(30),
  worker_last VARCHAR(30),
  subcell integer,
  training integer,
  ergo_score double,
  PRIMARY KEY (worker_ID, worker_first, worker_last, subcell)
);

INSERT INTO TrainingMatrix (worker_ID, worker_first, worker_last, subcell, training, ergo_score) VALUES 
	('j100', 'JD', 'Stumpf', 1000, 1, .5),
	('j101', 'Tupac','Shakur', 1010, 1, .67),
	('j102', 'Tom', 'Petty', 1020, 1, .95),
	('j103', 'Wayne', 'Gretzky', 1030, 1, .85),
	('j104', 'Sergei', 'Fedorov', 1040, 1, .65),
	('j106', 'George', 'Carlin', 1050, 1, .55),
	('j104', 'Sergei', 'Fedorov', 1030, 1, .65),
	('j100', 'JD', 'Stumpf', 1010, 1, .5),
	('j100', 'JD', 'Stumpf', 1020, 1, .5),
	('j103', 'Wayne', 'Gretzky', 1010, 1, .85),
	('j103', 'Wayne', 'Gretzky', 1020, 1, .55),
	('j103', 'Wayne', 'Gretzky', 1060, 1, .35),
	('j105', 'Louis','CK',1040,1,.98);
	
SELECT * FROM TrainingMatrix;
SELECT DISTINCT subcell FROM TrainingMatrix;
SELECT DISTINCT worker_ID FROM TrainingMatrix;

DROP TABLE IF EXISTS WorkerInfo;
CREATE TABLE WorkerInfo (
 worker_ID VARCHAR(30),	
 worker_first VARCHAR(30),	
 worker_last VARCHAR(30),	
PRIMARY key (worker_ID)
);

INSERT INTO WorkerInfo (worker_ID, worker_first, worker_last) VALUES
	('j100','JD','Stumpf'),
	('j101','Tupac','Shakur'),
	('j102','Tom','Petty');
	
SELECT * FROM WorkerInfo;


DROP TABLE IF EXISTS Subcell;
CREATE TABLE Subcell(
	subcell integer,
PRIMARY key (subcell)
);

INSERT INTO Subcell (subcell) VALUES
	(1000),
	(1010),
	(1020),
	(1030),
	(1040),
	(1050),
	(1060);
	
SELECT * FROM Subcell;


