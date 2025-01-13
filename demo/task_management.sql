-- Create database
DROP DATABASE IF EXISTS task_management;
     CREATE DATABASE IF NOT EXISTS task_management;
USE task_management;

-- Create table Task
CREATE TABLE Task (
    id INT AUTO_INCREMENT PRIMARY KEY,
    description TEXT,
    status ENUM('TODO', 'DOING', 'DONE') DEFAULT 'TODO',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert data
INSERT INTO Task (description, status) VALUES ('Task 1', 'TODO');
INSERT INTO Task (description, status) VALUES ('Task 2', 'DOING');
INSERT INTO Task (description, status) VALUES ('Task 3', 'DONE');
INSERT INTO Task (description, status) VALUES ('Task 4', 'TODO');
INSERT INTO Task (description, status) VALUES ('Task 5', 'DOING');
INSERT INTO Task (description, status) VALUES ('Task 6', 'DONE');

