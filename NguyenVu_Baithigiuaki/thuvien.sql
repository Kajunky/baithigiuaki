CREATE DATABASE thuvien;

USE thuvien;

CREATE TABLE authors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    author_name NVARCHAR(255) NOT NULL,
    book_numbers INT DEFAULT 0
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_name NVARCHAR(255) NOT NULL
);

CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title NVARCHAR(255) NOT NULL,
    author_id INT,
    category_id INT,
    publisher NVARCHAR(255),
    publish_year YEAR,
    quantity INT DEFAULT 1,
    FOREIGN KEY (author_id) REFERENCES authors(id) ON DELETE SET NULL,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);


INSERT INTO authors (author_name, book_numbers)
	values
		(N'Marquez', 3),
		(N'Patricia Highsmith', 6),
		(N'Daphne du Maurier', 5),
		(N'Ian McEwan', 7),
		(N'Toni Morrison', 4),
		(N'Yann Martel', 2);
		



INSERT INTO categories (category_name)
	VALUES 
	    (N'Fiction'),
		(N'Detective'),
		(N'Comedy'),
		(N'Romantic'),
		(N'Novel'),
		(N'Mysterious');


INSERT INTO books (title,author_id, category_id, publisher, publish_year, quantity) 
	values
		(N'Love in the Time of Cholera',1, 1, N'Gabriel Garcia', 1990, 2),
		(N'The Talented Mr. Ripley',2, 2, N'The Talented', 1988, 4),
		(N'Rebecca ',3, 3, N'Romic A', 1962 , 6),
		(N'Atonement',4, 4, N'Briony Tallis', 1999 , 8),
		(N'Beloved',5, 5, N'Baby Suggs', 1985 , 5),
		(N'Life of Pi',6, 6, N'Bengal', 1976, 3);
		
	
	
	