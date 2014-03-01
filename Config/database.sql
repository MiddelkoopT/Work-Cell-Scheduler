--  Database Copyright 2014 by WebIS Spring 2014 License Apache 2.0
DROP TABLE IF EXISTS TrainingMatrix;

CREATE TABLE TrainingMatrix (
  person VARCHAR(30),
  cell integer,
  training VARCHAR(30),
  ergonomicscore double
);

INSERT INTO TrainingMatrix (person,cell,training,ergonomicscore) VALUES 
	('Jennifer',1,'yes',1),
	('Jennifer',2,'yes',1),
	('JD',1,1,'yes',1),
	('Ann',2,1,'yes',1);
	

CREATE TABLE Schedule (
  person VARCHAR(30),
  cell integer
);

INSERT INTO Schedule (person,cell) VALUES 
	('Jennifer',1),
	('Jennifer',2),
	('JD',1),
	('Ann',2);
	
	
-- SELECT * FROM TrainingMatrix;
-- SELECT person,cell,w
