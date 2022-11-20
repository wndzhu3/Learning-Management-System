# Learning Management System

My final project submission for CS 377 - Database Systems at Emory University. I created a learning management system similar to Canvas that allows students and faculty to manage grades and discussion questions. I created the database design and used PHP to create a dynamic website.

## The Entity Relationship Diagram

<img width="734" alt="Screen Shot 2022-11-19 at 7 32 28 PM" src="https://user-images.githubusercontent.com/55262996/202877042-a0388b10-e240-4540-aedf-102844c04416.png">

I designed the above ER diagram using the following requirements.
<details>
<summary>Requirements list</summary>

- A class is assigned a course name, course number, semester and year. For example, the database course you are currently taking is course name Database Systems, course number CS 377, Fall semester, and 2021 respectively. For the purpose of this project, we will assume there is only one offering of the course is available in any given semester.
- A student can take any number of classes.
- Each course must be taught by an instructor and may have teaching assistants who are students. Note that an instructor and teaching assistant can be a student in another class.
- A student (instructor and teaching assistant) is assigned a unique student identifier, a login ID, and their first name and last name.
- Each course can have several assignments. To simplify your application, we will consider all quizzes, surveys, and exams to be assignments. For example, the course you are taking has 8 assignments (5 assignments, 1 final project, 2 exams). Each assignment has a due date (just the date and not a timestamp), assignment-related text, and the total number of points for the assignment. For this project, you do not need to support assignment submission (e.g., submission is done on Gradescope).
- A student will receive a numeric grade (i.e., 0-100) for each assignment that can only be entered by the instructor or a teaching assistant.
- A student will receive a final letter grade for the course1.
- A class can have multiple question and answer posts, similar to how Piazza works. A student or instructor can post a question with a title, one or more tags (e.g., assignment1, exam, etc.), the text, and the post date. You should assume that some classes may also not have any posts associated with it.
- For each Q&A post, there is a “thread” or a sequence of replies from students and in- structors. Each reply should contain the following information: who posted it, the time, and the text. For the purpose of the project, you do not need to allow post anonymity (i.e., all names should be visible) nor do you need to differentiate whether the poster is a student or a a member of the teaching staff.
</details>

## The Relational Model

<img width="494" alt="Screen Shot 2022-11-19 at 7 36 47 PM" src="https://user-images.githubusercontent.com/55262996/202877241-b14f1b1c-13a5-4e8e-8a29-7278c5054dfc.png">

I created the relational model from my ER diagram and normalized the relational schema based after defining the functional dependencies of my application.

## SQL Database Creation

From my relational model, I created and populated CSV data files using provided bulk data files, `canvas.csv` and `qa.csv`. I created the SQL files `createdatabase.sql` and `dropdatabase.sql` to build and delete my database schema.

## The Webpages

I designed 4 different types of webpages which were dynamically populated using data from my databases.
- The **Student Course** page(s) allows a student to view a particular course they have taken or are taking, see their current assignment grades and the details of their assignments, and view their final letter grade for the course.
- The **Teaching Staff** page(s) allows the instructor or teaching assistant to see all the students who are taking a specific course they're teaching, view the course content, create new assignments for the course, and enter grades for each student.
- The **Q&A** page(s) allows users to view, post, and answer questions associated with their courses. Users can view posts and associated threads, filter questions and threads based on the tag of the posts, and create and respond to posts.
- The **Home/Login** page allows the user to log in to the application using their student ID and login ID. It informs the user if their login information is not valid. Once they are logged in, they are shown all the courses they can access.
