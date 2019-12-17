DROP DATABASE IF EXISTS carRental;
CREATE DATABASE carRental;
USE carRental;


CREATE TABLE Customers (socialSecurityNumber INTEGER NOT NULL PRIMARY KEY,
                        customerName VARCHAR(256),
                        address VARCHAR(256),
                        postalAddress VARCHAR(256),
                        phoneNumber INTEGER
                       );

CREATE TABLE Cars (registration VARCHAR(100) NOT NULL PRIMARY KEY,
                    year YEAR,
                    cost FLOAT,
                    renter INTEGER NOT NULL,
                    FOREIGN KEY (renter) REFERENCES Customers(socialSecurityNumber),
                    rentStartTime DATETIME
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

insert INTO Colors (color) values ("Black"),
                                  ("White"),
                                  ("Gray"),
                                  ("Blue"),
                                  ("Red"),
                                  ("Silver"),
                                  ("Orange"),
                                  ("Green");

#CREATE TABLE History ();