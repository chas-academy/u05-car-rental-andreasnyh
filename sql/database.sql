DROP DATABASE IF EXISTS carRental;
CREATE DATABASE carRental;
USE carRental;


CREATE TABLE Customers (socialSecurityNumber BIGINT NOT NULL UNIQUE KEY,
                        customerName VARCHAR(256),
                        address VARCHAR(256),
                        postalAddress VARCHAR(256),
                        phoneNumber VARCHAR(10)
                       );

CREATE TABLE Cars (registration VARCHAR(100) NOT NULL,
                    year YEAR,
                    cost FLOAT,
                    renter BIGINT NOT NULL,
                    FOREIGN KEY (renter) REFERENCES Customers(socialSecurityNumber),
                    UNIQUE KEY (registration)
                  );

CREATE TABLE Makes (make VARCHAR(256));

INSERT INTO Makes (make) VALUES ("Ford"),
                                ("Volkswagen"),
                                ("Toyota"),
                                ("Hyundai"),
                                ("Checrolet"),
                                ("Honda"),
                                ("Kia"),
                                ("Mazda");

CREATE TABLE Colors (color VARCHAR(256));

INSERT INTO Colors (color) values ("Black"),
                                  ("White"),
                                  ("Gray"),
                                  ("Blue"),
                                  ("Red"),
                                  ("Silver"),
                                  ("Orange"),
                                  ("Green");

CREATE TABLE History (registration VARCHAR(100), FOREIGN KEY (registration) REFERENCES Cars(registration),
                      renter BIGINT NOT NULL, FOREIGN KEY (renter) REFERENCES Customers(socialSecurityNumber),
                      rentStartTime DATETIME,
                      returnTime DATETIME,
                      days INTEGER,
                      totalCost FLOAT
                      );

INSERT INTO Customers VALUES (2905039497, "Göran Persson", "Lingonstigen 8", "181 64 Lidingö", "0733456456"),
                             (8205030789, "Glen Hysen", "Kungsportsavenyen 2", "411 38 Göteborg", "0709123432"),
                             (1802222685, "Frida Fridh", "Eksätravägen 471", "126 54 Stockholm", "0763452722"),
                             (9905085115, "Kristina Kristen", "Kyrkängsbacken 14", "141 35 Huddinge", "0702456776"),
                             (4604279796, "Hjördis Hansson", "Älvkarlevägen 17", "115 43 Stockholm", "0712430556"),
                             (9601248876, "Theodor af Gryta", "Gamla Brogatan 29", "111 20 Stockholm", "0709876678"),
                             (6505088283, "Leif \"Loket\" Olsson", "Drottninggatan 60", "411 07 Göteborg", "0700867768"),
                             (7001266894, "Richard Faußt", "Glaciärvägen 5", "806 30 Gävle", "0763456234");
