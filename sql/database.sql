DROP DATABASE IF EXISTS carRental;
CREATE DATABASE carRental;
USE carRental;

-- Customers
CREATE TABLE Customers (socialSecurityNumber BIGINT NOT NULL UNIQUE KEY,
                        customerName VARCHAR(256),
                        address VARCHAR(256),
                        postalAddress VARCHAR(256),
                        phoneNumber VARCHAR(10)
                       );

INSERT INTO Customers VALUES (2905039497, "Göran Persson", "Lingonstigen 8", "181 64 Lidingö", "0733456456"),
     (8205030789, "Glen Hysen", "Kungsportsavenyen 2", "411 38 Göteborg", "0709123432"),
     (1802222685, "Frida Fridh", "Eksätravägen 471", "126 54 Stockholm", "0763452722"),
     (9905085115, "Kristina Kristen", "Kyrkängsbacken 14", "141 35 Huddinge", "0702456776"),
     (4604279796, "Hjördis Hansson", "Älvkarlevägen 17", "115 43 Stockholm", "0712430556"),
     (9601248876, "Theodor af Gryta", "Gamla Brogatan 29", "111 20 Stockholm", "0709876678"),
     (6505088283, "Leif \"Loket\" Olsson", "Drottninggatan 60", "411 07 Göteborg", "0700867768"),
     (7001266894, "Richard Faußt", "Glaciärvägen 5", "806 30 Gävle", "0763456234");

-- Makes
CREATE TABLE Makes (make VARCHAR(256) PRIMARY KEY);

INSERT INTO Makes (make) VALUES ("Ford"),
                                ("Volkswagen"),
                                ("Toyota"),
                                ("Hyundai"),
                                ("Chevrolet"),
                                ("Honda"),
                                ("Kia"),
                                ("Mazda");
-- Colors
CREATE TABLE Colors (color VARCHAR(256) PRIMARY KEY);

INSERT INTO Colors (color) values ("Black"),
                                  ("White"),
                                  ("Gray"),
                                  ("Blue"),
                                  ("Red"),
                                  ("Silver"),
                                  ("Orange"),
                                  ("Green");

-- Cars
CREATE TABLE Cars (registration VARCHAR(100) NOT NULL,
                    year YEAR,
                    cost FLOAT,
                    make VARCHAR(256),
                    model VARCHAR(256),
                    color VARCHAR(256),
                    renter BIGINT,
                    FOREIGN KEY (make) REFERENCES Makes(make),
                    FOREIGN KEY (color) REFERENCES Colors(color),
                    FOREIGN KEY (renter) REFERENCES Customers(socialSecurityNumber),
                    UNIQUE KEY (registration)
                  );

INSERT INTO Cars VALUES ("ABC123", 2018, 250,"Ford", "Focus","Black", NULL),
                        ("BCD234", 2019, 495,"Volkswagen", "Golf GTE", "White", NULL),
                        ("CDE345", 2017, 200, "Toyota", "Aygo", "Gray", NULL),
                        ("DEF456", 2019, 450, "Hyundai", "i30 N", "Blue", NULL),
                        ("EFG567", 2019, 295, "Chevrolet", "Spark", "Gray", NULL);


-- History
CREATE TABLE History (registration VARCHAR(100), FOREIGN KEY (registration) REFERENCES Cars(registration),
                      renter BIGINT NOT NULL, FOREIGN KEY (renter) REFERENCES Customers(socialSecurityNumber),
                      rentStartTime TIMESTAMP NULL ,
                      returnTime TIMESTAMP NULL ,
                      days INTEGER,
                      totalCost FLOAT
                      );

-- ALTER TABLE  Cars ADD (rentStartTime TIMESTAMP, FOREIGN KEY (rentStartTime) REFERENCES History (rentStartTime));


-- SELECT * from Cars;
-- SELECT * from Customers;

