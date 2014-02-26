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
	('Dr.Middelkoop',1000,1010,0.19,0.19),
	('JD',1000,1010,0.99,0.99);

-- SELECT * FROM TrainingMatrix;
-- SELECT person,cell,w