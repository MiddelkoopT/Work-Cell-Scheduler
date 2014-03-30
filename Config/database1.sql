DROP TABLE IF EXISTS Worker;
CREATE TABLE Worker (
  person VARCHAR(30),
  name VARCHAR(30),
  workerID VARCHAR(30),
  PRIMARY KEY (workerID)
);


DROP TABLE IF EXISTS TrainingMatrix;
CREATE TABLE TrainingMatrix (
 workerID VARCHAR(30),
 training VARCHAR(30),
  PRIMARY KEY (workerID)
);

	
	
DROP TABLE IF EXISTS Subcell;
CREATE TABLE Subcell (
  workerID VARCHAR(30),
  subcell  VARCHAR(30),
  PRIMARY KEY (workerID)

);

