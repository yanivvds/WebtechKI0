-- @block
-- Users
CREATE TABLE User (
    UserID INT PRIMARY KEY,
    UserName VARCHAR(255),
    Email VARCHAR(255),
    Password VARCHAR(255),
    RegistrationDate DATE
);

-- Destinations
CREATE TABLE Destination (
    DestinationID INT PRIMARY KEY,
    DestinationName VARCHAR(255),
    Continent VARCHAR(255),
    Description TEXT,
    ImageURL VARCHAR(255)
);

-- Reviews
CREATE TABLE Review (
    ReviewID INT PRIMARY KEY,
    UserID INT,
    DestinationID INT,
    Rating INT,
    ReviewText TEXT,
    ReviewDate DATE,
    FOREIGN KEY (UserID) REFERENCES User(UserID),
    FOREIGN KEY (DestinationID) REFERENCES Destination(DestinationID)
);

