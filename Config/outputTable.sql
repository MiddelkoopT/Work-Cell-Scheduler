DROP TABLE ScheduleMatrix;
DROP TABLE TrainingMatrix;

CREATE TABLE TrainingMatrix(
	person VARCHAR(30), 
	cell INTEGER,
	training double,
	ergo double
);

INSERT INTO TrainingMatrix (person,cell,training,ergo)
	VALUES ('Joe ',2000,.9,.8), ('JD',2000,.4,.99), ('Bob',2000,.8,.77);
	
CREATE TABLE ScheduleMatrix(
	person VARCHAR(30),
	cell integer,
	period integer
);
INSERT INTO ScheduleMatrix (person, cell, period)
	VALUES ('Joe Ahlbrandt', 2000, 1), ('JD', 2000, 1), ('Bob', 2000, 2);
	
