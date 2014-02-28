--  Database Copyright 2014 by WebIS Spring 2014 License Apache 2.0
DROP TABLE TrainingMatrix;
CREATE TABLE TrainingMatrix (
  person VARCHAR(30),
  cell integer,
  workstation integer,
  wcp double,
  wsp double 
);

INSERT INTO TrainingMatrix (person,cell,workstation,wcp,wsp) VALUES 
	('Dr.Middelkoop',1000,1010,0.19,0.99),
	('Dr.Middelkoop',1000,1020,0.19,0.30),
	('Dr.Middelkoop',1000,1030,0.19,0.90),
	('Dr.Middelkoop',1000,1040,0.19,0.60),
	('Dr.Middelkoop',1000,1050,0.19,0.30),
	('JD',1000,1010,0.99,0.40),
	('JD',1000,1020,0.99,0.80),
	('JD',1000,1030,0.99,0),
	('JD',2000,1040,0.99,0.88),
	('JD',2000,1050,0.99,0.85),
	('AL',1000,1010,0.90,0.50),
	('AL',1000,1020,0.90,0.60),
	('AL',1000,1030,0.90,0.60),
	('AL',2000,1040,0.90,0.40),
	('AL',2000,1050,0.90,0.33),
	('BG',1000,1010,0.75,0.40),
	('BG',1000,1020,0.75,0),
	('BG',1000,1030,0.75,0),
	('BG',2000,1040,0.75,0.80),
	('BG',2000,1050,0.75,0.66),
	('SM',1000,1010,0.66,0.66),
	('SM',1000,1020,0.66,0.35),
	('SM',1000,1030,0.66,0.55),
	('SM',2000,1040,0.66,0.25),
	('SM',2000,1050,0.66,0),

-- SELECT * FROM TrainingMatrix;
-- SELECT person,cell,w