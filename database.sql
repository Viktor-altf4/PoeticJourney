-- Create the database if not already done
CREATE DATABASE poetry_blog_website;

-- Switch to the database
USE poetry_blog_website;

-- Create the table for storing form submissions
CREATE TABLE submissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    type ENUM('poem', 'blog') NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);