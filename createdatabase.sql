CREATE DATABASE canvas;

USE canvas;

CREATE TABLE student (
  sID CHAR(10) NOT NULL,
  firstName VARCHAR(50) NOT NULL,
  lastName VARCHAR(50) NOT NULL,
  isInstructor BOOLEAN DEFAULT FALSE,
  isTA BOOLEAN DEFAULT FALSE,
  CONSTRAINT studentPK PRIMARY KEY(sID)
);

CREATE TABLE class (
  courseID VARCHAR(50) NOT NULL,
  year INT,
  semester VARCHAR(6) NOT NULL,
  courseNumber VARCHAR(50) NOT NULL,
  courseName VARCHAR(100) NOT NULL,
  instructorID CHAR(10) NOT NULL,
  CONSTRAINT classPK PRIMARY KEY(courseID),
  CONSTRAINT classFK FOREIGN KEY(instructorID)
  REFERENCES student(sID)
);

CREATE TABLE login (
  loginID VARCHAR(50) NOT NULL,
  sID CHAR(10) NOT NULL,
  CONSTRAINT loginPK PRIMARY KEY(loginID),
  CONSTRAINT loginFK FOREIGN KEY(sID)
	REFERENCES student(sID)
);

CREATE TABLE ta (
  sID CHAR(10) NOT NULL,
  courseID VARCHAR(50) NOT NULL,
  CONSTRAINT taPK PRIMARY KEY(sID, courseID),
  CONSTRAINT taFK1 FOREIGN KEY(sID)
  REFERENCES student(sID),
  CONSTRAINT taFK2 FOREIGN KEY(courseID)
  REFERENCES class(courseID)
);

CREATE TABLE enrollment_grade (
  sID CHAR(10) NOT NULL,
  courseID VARCHAR(50) NOT NULL,
  letterGrade VARCHAR(2),
  CONSTRAINT class_gradePK PRIMARY KEY(sID, courseID),
  CONSTRAINT class_gradeFK1 FOREIGN KEY(sID)
  REFERENCES student(sID),
  CONSTRAINT class_gradeFK2 FOREIGN KEY(courseID)
  REFERENCES class(courseID)
);

CREATE TABLE assignment (
  courseID VARCHAR(50) NOT NULL,
  assignmentName VARCHAR(50) NOT NULL,
  dueDate DATE,
  assignmentText VARCHAR(1000),
  totalPoints INT CHECK (totalPoints > 0),
  CONSTRAINT assignmentPK PRIMARY KEY(courseID, assignmentName),
  CONSTRAINT assignmentFK FOREIGN KEY(courseID)
  REFERENCES class(courseID)
);

CREATE TABLE assignment_grade (
  sID CHAR(10) NOT NULL,
  courseID VARCHAR(50) NOT NULL,
  assignmentName VARCHAR(50) NOT NULL,
  grade VARCHAR(3),
  CONSTRAINT assignment_gradePK PRIMARY KEY(sID, courseID, assignmentName),
  CONSTRAINT assignment_gradeFK1 FOREIGN KEY(sID)
  REFERENCES student(sID),
  CONSTRAINT assignment_gradeFK2 FOREIGN KEY(courseID)
  REFERENCES class(courseID)
);

CREATE TABLE post (
  postID VARCHAR(50) NOT NULL,
  posterID CHAR(10),
  courseID VARCHAR(50) NOT NULL,
  title VARCHAR(150),
  postDate TIMESTAMP,
  postText varchar(1000),
  CONSTRAINT postPK PRIMARY KEY(postID),
  CONSTRAINT postFK1 FOREIGN KEY(posterID)
  REFERENCES student(sID),
  CONSTRAINT postFK2 FOREIGN KEY(courseID)
  REFERENCES class(courseID)
);

CREATE TABLE tag (
  postID VARCHAR(50) NOT NULL,
  tag VARCHAR(50) NOT NULL,
  CONSTRAINT tagPK PRIMARY KEY(postID, tag),
  CONSTRAINT tagFK FOREIGN KEY(postID)
  REFERENCES post(postID)
);

CREATE TABLE reply (
  postID VARCHAR(50) NOT NULL,
  replyNumber INT CHECK (replyNumber > 0),
  replierID CHAR(10),
  replyTime TIMESTAMP NOT NULL,
  replyText VARCHAR(1000),
  CONSTRAINT replyPK PRIMARY KEY(postID, replyNumber),
  CONSTRAINT replyFK1 FOREIGN KEY(replierID)
  REFERENCES student(sID)
);
