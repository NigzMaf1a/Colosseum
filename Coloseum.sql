-- Step 1: Rename the database
-- MySQL doesn't support renaming databases directly, so we will create a new database and migrate the tables manually

-- Create the database Colosseum
CREATE DATABASE IF NOT EXISTS Colosseum;

-- Use the Colosseum database
USE Colosseum;

-- Step 2: Create the Registration table
CREATE TABLE Registration (
    RegID INT AUTO_INCREMENT PRIMARY KEY,
    Name1 VARCHAR(15),
    Name2 VARCHAR(15),
    PhoneNo VARCHAR(15),
    Email VARCHAR(20),
    NatID VARCHAR(12),
    Password VARCHAR(10),
    RegType ENUM('Admin', 'Realtor', 'Caretaker', 'Tenant', 'Viewer'),
    dLocation ENUM('Urban', 'Rural', 'Suburban'), -- Example ENUM values
    Gender ENUM('Male', 'Female'),
    PhotoPath VARCHAR(255), -- Column for storing the file path to the photo
    accStatus ENUM('Pending', 'Approved', 'Inactive'),
    RegDate DATE,
    lastAccessed TIMESTAMP, -- Timestamp column for tracking last access
    latitude DECIMAL(9, 6), -- Column for latitude
    longitude DECIMAL(9, 6) -- Column for longitude
);

-- Step 3: Create Admin Table
CREATE TABLE Admin (
    RegID INT,
    AdminID INT AUTO_INCREMENT PRIMARY KEY,
    AdminName VARCHAR(20),
    FOREIGN KEY (RegID) REFERENCES Registration(RegID)
);

-- Step 4: Create Viewer Table
CREATE TABLE Viewer (
    RegID INT,
    ViewerID INT AUTO_INCREMENT PRIMARY KEY,
    FOREIGN KEY (RegID) REFERENCES Registration(RegID)
);
--Create Landlord Table
CREATE TABLE Landlord (
    LandlordID INT AUTO_INCREMENT PRIMARY KEY, -- Primary key for Landlord table
    RegID INT NOT NULL, -- Foreign key referencing Registration table
    LandlordName VARCHAR(100) NOT NULL, -- Name of the landlord
    Balance DECIMAL(10, 2) DEFAULT 0.00, -- Balance amount with a default value of 0.00
    FOREIGN KEY (RegID) REFERENCES Registration(RegID) -- Foreign key constraint
);

-- Step 5: Create Realtors Table
CREATE TABLE Realtors (
    RegID INT,
    RealtorID INT AUTO_INCREMENT PRIMARY KEY,
    RealtorName VARCHAR(20),
    Balance INT,
    FOREIGN KEY (RegID) REFERENCES Registration(RegID)
);

-- Step 6: Create Property Table
CREATE TABLE Property (
    RealtorID INT,
    PropertyID INT AUTO_INCREMENT PRIMARY KEY,
    RealtorName VARCHAR(20),
    PropertyName VARCHAR(20),
    Valid ENUM('YES', 'NO'),
    PhotoPath VARCHAR(255),
    FOREIGN KEY (RealtorID) REFERENCES Realtors(RealtorID)
);

-- Step 7: Create Unit Table
CREATE TABLE Unit (
    RealtorID INT,
    PropertyID INT,
    UnitID INT AUTO_INCREMENT PRIMARY KEY,
    UnitType ENUM('Single', 'Bedsitter', 'One Bedroom', 'Two Bedroom', 'Three Bedroom', 'AirBnB'),
    UnitName VARCHAR(10),
    PropertyName VARCHAR(20),
    RealtorName VARCHAR(20),
    Price INT,
    propCondition ENUM('CAT1', 'CAT2', 'CAT3', 'CAT4'), -- Renamed 'Condition' to 'propCondition'
    Vacant ENUM('YES', 'NO'),
    PhotoPath VARCHAR(255),
    FOREIGN KEY (RealtorID) REFERENCES Realtors(RealtorID),
    FOREIGN KEY (PropertyID) REFERENCES Property(PropertyID)
);

-- Step 8: Create Deposit Table
CREATE TABLE Deposit (
    RegID INT,
    DepositID INT AUTO_INCREMENT PRIMARY KEY,
    DepositDate DATE,
    Amount INT,
    Confirmed ENUM('YES', 'NO'),
    FOREIGN KEY (RegID) REFERENCES Registration(RegID)
);

-- Step 9: Create Caretaker Table
CREATE TABLE Caretaker (
    RegID INT,
    PropertyID INT,
    CaretakerID INT AUTO_INCREMENT PRIMARY KEY,
    PropertyName VARCHAR(20),
    CaretakerName VARCHAR(20),
    FOREIGN KEY (PropertyID) REFERENCES Property(PropertyID),
    FOREIGN KEY (RegID) REFERENCES Registration(RegID)
);

-- Step 10: Create Tenant Table
CREATE TABLE Tenant (
    RegID INT,
    RealtorID INT,
    PropertyID INT,
    UnitID INT,
    TenantName VARCHAR(20),
    Arrears INT,
    EvictionStatus ENUM('YES', 'NO'), 
    FOREIGN KEY (RealtorID) REFERENCES Realtors(RealtorID),
    FOREIGN KEY (PropertyID) REFERENCES Property(PropertyID),
    FOREIGN KEY (RegID) REFERENCES Registration(RegID),
    FOREIGN KEY (UnitID) REFERENCES Unit(UnitID)
);

-- Step 11: Create the Feedback Table
CREATE TABLE Feedback (
    FeedbackID INT AUTO_INCREMENT PRIMARY KEY,
    TenantID INT,
    TenantName VARCHAR(25),
    Comments TEXT,
    Response TEXT,
    Rating INT CHECK (Rating >= 1 AND Rating <= 5), -- Renamed 'Check' to 'Rating' and applied constraint
    FOREIGN KEY (TenantID) REFERENCES Tenant(TenantID)
);

-- Step 12: Create the About Table
CREATE TABLE About (
    AboutID INT AUTO_INCREMENT PRIMARY KEY,
    RealtorID INT,
    PropertyID INT,
    RealtorName VARCHAR(20),
    PropertyName VARCHAR(20),
    Detail TEXT,
    FOREIGN KEY (RealtorID) REFERENCES Realtors(RealtorID),
    FOREIGN KEY (PropertyID) REFERENCES Property(PropertyID)
);

-- Step 13: Create the Contact Table
CREATE TABLE Contact (
    RealtorID INT,
    PropertyID INT,
    RealtorName VARCHAR(20),
    PhoneNo VARCHAR(15),
    Email VARCHAR(25),
    Instagram VARCHAR(15),
    Facebook VARCHAR(15),
    POBox VARCHAR(25),
    FOREIGN KEY (RealtorID) REFERENCES Realtors(RealtorID),
    FOREIGN KEY (PropertyID) REFERENCES Property(PropertyID)
);

-- Step 14: Create the Landlord Table (with FK from Registration)
CREATE TABLE Landlord (
    LandlordID INT AUTO_INCREMENT PRIMARY KEY,
    RegID INT,
    LandlordName VARCHAR(20),
    FOREIGN KEY (RegID) REFERENCES Registration(RegID)
);
