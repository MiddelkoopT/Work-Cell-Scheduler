DROP TABLE TrainingMatrix;
CREATE TABLE TrainingMatrix(
	person VARCHAR(30),
	cell integer,
	workstation integer,
	wcp double,
	wsp double
);

INSERT INTO TrainingMatrix (person,cell,workstation,wcp,wsp)
	VALUES 
	('Person 1',1000,1010,0.90,0.98),
	('Person 2',1000,1020,0.79,0.93),
	('Person 3',1000,1030,0.54,0.87),
	('Person 4',1000,1040,0.81,0.94),
	('Person 5',2000,2010,0.92,0.96),
	('Person 6',2000,2010,0.86,0.90);

SELECT * FROM TrainingMatrix;
SELECT person,cell,workstation FROM TrainingMatrix;

DROP TABLE OutputMatrix;
CREATE TABLE OutputMatrix(
	personcell VARCHAR(30),
	period1 integer,
	period2 integer,
	period3 integer,
	period4 integer,
	period5 integer,
	period6 integer
);

INSERT INTO OutputMatrix (personcell,period1,period2,period3,period4,period5,period6)
	VALUES 
	('Person 1 assignment',1,1,1,3,3,3),
	('Person 2 assignment',4,4,2,2,5,5),
	('Person 3 assignment',2,2,6,6,6,6),
	('Person 4 assignment',6,6,4,4,2,2),
	('Person 5 assignment',3,3,3,1,1,1),
	('Person 6 assignment',5,5,5,5,4,4);

SELECT * FROM OutputMatrix;
