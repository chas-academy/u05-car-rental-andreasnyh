DROP DATABASE IF EXISTS carRental;
CREATE DATABASE carRental;
USE carRental;


CREATE TABLE Customers (socialSecurityNumber BIGINT NOT NULL UNIQUE KEY,
                        customerName VARCHAR(256),
                        address VARCHAR(256),
                        postalAddress VARCHAR(256),
                        phoneNumber INTEGER
                       );

CREATE TABLE Cars (registration VARCHAR(100) NOT NULL,
                    year YEAR,
                    cost FLOAT,
                    renter BIGINT NOT NULL,
                    FOREIGN KEY (renter) REFERENCES Customers(socialSecurityNumber),
                    rentStartTime DATETIME,
                    returnTime DATETIME,
                    UNIQUE KEY (registration),
                    PRIMARY KEY (rentStartTime, returnTime)
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

CREATE TABLE History (registration VARCHAR(100), FOREIGN KEY (registration) REFERENCES Cars(registration),
                      renter BIGINT NOT NULL, FOREIGN KEY (renter) REFERENCES Customers(socialSecurityNumber),
                      rentStartTime DATETIME, FOREIGN KEY (rentStartTime) REFERENCES Cars(rentStartTime),
                      returnTime DATETIME, CONSTRAINT carRental FOREIGN KEY (returnTime) REFERENCES Cars(returnTime)
                      #days INTEGER,
                      #cost FLOAT, FOREIGN KEY (cost) REFERENCES Cars(cost)
                      );