-- Create the `departments` table
CREATE TABLE `departments` (
    `id` BIGINT(20) AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL
);

-- Create the `courses` table
CREATE TABLE `courses` (
    `id` BIGINT(20) AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `department_id` BIGINT(20) NOT NULL,
    FOREIGN KEY (`department_id`) REFERENCES `departments`(`id`)
);

-- Create the `users` table
CREATE TABLE `users` (
    `id` BIGINT(20) AUTO_INCREMENT PRIMARY KEY,
    `student_id` VARCHAR(12) NOT NULL,
    `first_name` VARCHAR(50) NOT NULL,
    `middle_name` VARCHAR(50),
    `last_name` VARCHAR(50) NOT NULL,
    `gender` VARCHAR(10),
    `course_id` BIGINT(20) NOT NULL,
    `user_type` ENUM('STUDENT', 'ADMIN') NOT NULL,
    FOREIGN KEY (`course_id`) REFERENCES `courses`(`id`)
);
