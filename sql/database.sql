DROP DATABASE IF EXISTS carRental;
CREATE DATABASE carRental;
USE carRental;

-- Customers
CREATE TABLE Customers (socialSecurityNumber BIGINT NOT NULL UNIQUE PRIMARY KEY,
                        customerName VARCHAR(256),
                        address VARCHAR(256),
                        postalAddress VARCHAR(256),
                        phoneNumber VARCHAR(10)
                       );

INSERT INTO Customers VALUES
     (2905039497, "Göran Persson", "Lingonstigen 8", "181 64 Lidingö", "0733456456"),
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
                    rentStart DATETIME,
                    KEY (rentStart),
                    FOREIGN KEY (make) REFERENCES Makes(make),
                    FOREIGN KEY (color) REFERENCES Colors(color),
                    FOREIGN KEY (renter) REFERENCES Customers(socialSecurityNumber),
                    UNIQUE KEY (registration)
                  );

INSERT INTO Cars VALUES ("ABC123", 2018, 250,"Ford", "Focus","Black", NULL, NULL),
                        ("BCD234", 2019, 495,"Volkswagen", "Golf GTE", "White", NULL, NULL),
                        ("CDE345", 2017, 200, "Toyota", "Aygo", "Gray", NULL, NULL),
                        ("DEF456", 2019, 450, "Hyundai", "i30 N", "Blue", NULL, NULL),
                        ("EFG567", 2019, 295, "Chevrolet", "Spark", "Gray", NULL, NULL);

UPDATE Cars SET renter = 1802222685, rentStart = CURRENT_TIMESTAMP
WHERE registration = "ABC123";
/*
-- History
CREATE TABLE Rents (registration VARCHAR(100) NULL, FOREIGN KEY (registration) REFERENCES Cars(registration),
                      renter BIGINT NULL, FOREIGN KEY (renter) REFERENCES Customers(socialSecurityNumber),
                      rentStartTime DATETIME
                     # returnTime DATETIME #,
                     # days INTEGER,
                     # totalCost FLOAT
                      );
*/
-- Add columns to history
CREATE TABLE History (registrationHistory VARCHAR(100),
                      renterHistory BIGINT,
                      rentStartHistory DATETIME,
                      returnTimeHistory DATETIME,
                      FOREIGN KEY (registrationHistory) REFERENCES Cars(registration),
                      FOREIGN KEY (renterHistory) REFERENCES Customers(socialSecurityNumber));


/*
INSERT INTO History (registrationHistory, renterHistory, rentStartHistory, returnTimeHistory) VALUES
('PHP666', 9601248876, '2020-01-10 09:51:37', '2020-01-10 09:55:14');
INSERT INTO History (registrationHistory, renterHistory, rentStartHistory, returnTimeHistory) VALUES
('PHP666', 7001266894, '2020-01-10 10:26:46', '2020-01-10 10:26:55');
INSERT INTO History (registrationHistory, renterHistory, rentStartHistory, returnTimeHistory) VALUES
('EFG567', 3903118788, '2020-01-10 14:20:59', '2020-01-13 14:22:16');
*/

-- INSERT INTO History VALUES ("BCD234", 6505088283)
#INSERT INTO Rents(registration, renter, rentStartTime)VALUES ("BCD234", 6505088283, CURRENT_TIMESTAMP);
#INSERT INTO Rents(registration, renter, rentStartTime)VALUES ("DEF456", 9905085115, CURRENT_DATE() );

# ALTER TABLE  Cars ADD (rentStartTime TIMESTAMP, FOREIGN KEY (rentStartTime) REFERENCES History (rentStartTime));


# SELECT * from Cars;
# SELECT * from Customers;
# SELECT * from History;
# SELECT * FROM Cars WHERE renter = ;
# SELECT * FROM Rents;
# SELECT * FROM Rents WHERE registration = "bcd234";