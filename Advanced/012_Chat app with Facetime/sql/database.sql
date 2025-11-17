CREATE DATABASE chat_app;
USE chat_app;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT,
    receiver_id INT,
    message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES users(id),
    FOREIGN KEY (receiver_id) REFERENCES users(id)
);

CREATE TABLE video_calls (
    id INT AUTO_INCREMENT PRIMARY KEY,
    caller_id INT,
    receiver_id INT,
    room_id VARCHAR(100) UNIQUE,
    status ENUM('pending', 'accepted', 'rejected', 'ended'),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);