DROP TABLE ScheduleMatrix;
DROP TABLE TrainingMatrix;

CREATE TABLE TrainingMatrix(
	person VARCHAR(30), 
	cell INTEGER,
	workstation INTEGER,
	wcp double,
	wsp double
);

INSERT INTO TrainingMatrix (person,cell,workstation,wcp,wsp)
	VALUES ('Joe ',2000,2010,.9,.8), ('JD',2000,2011,.4,.99), ('Bob',2000,2001,.8,.77);
	
CREATE TABLE ScheduleMatrix(
	person VARCHAR(30),
	cell integer,
	period integer
);
INSERT INTO ScheduleMatrix (person, cell, period)
	VALUES ('Joe Ahlbrandt', 2000, 1), ('JD', 2000, 1), ('Bob', 2000, 2);
	
