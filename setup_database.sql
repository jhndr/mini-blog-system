-- Create database for mini blog system
-- Run this in phpMyAdmin before running Laravel migrations

CREATE DATABASE IF NOT EXISTS mini_blog_system CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Optional: Create a dedicated user (you can skip this if using root)
-- CREATE USER 'mini_blog_user'@'localhost' IDENTIFIED BY 'password';
-- GRANT ALL PRIVILEGES ON mini_blog_system.* TO 'mini_blog_user'@'localhost';
-- FLUSH PRIVILEGES;
