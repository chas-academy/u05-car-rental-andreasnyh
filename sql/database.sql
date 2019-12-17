DROP DATABASE IF EXISTS carRental;
CREATE DATABASE carRental;
USE carRental;


CREATE TABLE Customers (socialSecurityNumber INTEGER NOT NULL KEY,
                        customerName VARCHAR(256), address VARCHAR(256),
                        postalAddress VARCHAR(256), phoneNumber INTEGER
                       );

CREATE TABLE Cars (registration INTEGER NOT NULL KEY,
                    make VARCHAR(256),
                    color VARCHAR(256),
                    year INTEGER,
                    cost INTEGER,
                    renter INTEGER NOT NULL,
                    FOREIGN KEY (renter) REFERENCES Customers(socialSecurityNumber),
                    rentStartTime TIMESTAMP
                  );

