DROP TABLE TrainingMatrix;
CREATE TABLE TrainingMatrix(

 person VARCHAR(30)
 cell integer,
 workstation integer,
 wcp double,
 wsp double

);

INSERT INTO TrainingMatrix (person,workstation,cell,wsp,wcp)
   VALUE ('Dr.Middelkoop',1000,1010,0.99,0.99),('JD',1000,1011,0.8,0.9),('KT',1000,1012,0.3,0.7);
   
   
