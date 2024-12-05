CREATE DATABASE DBEthicX;
GO

USE DBEthicX;

CREATE TABLE Users
(
    UserID INT IDENTITY(1,1) PRIMARY KEY,
    Username NVARCHAR(50) NOT NULL UNIQUE,
    Password_hash NVARCHAR(255) NOT NULL,
    Role NVARCHAR(20) CHECK (role IN ('admin', 'dosen', 'mahasiswa')) NOT NULL,
);

INSERT INTO Users
    (Username, Password, Role)
VALUES
    ('admin', HASHBYTES('SHA2_256', 'admin1234'), 'admin'),
    ('jaksmiths', HASHBYTES('SHA2_256', 'dosen1234'), 'dosen'),
    ('jakcrzy', HASHBYTES('SHA2_256', 'mahasiswa1987
    '), 'mahasiswa'),
    ('igaramadana', HASHBYTES('SHA2_256', 'igaramadana'), 'admin');

SELECT *
FROM Users;

DELETE FROM Users
WHERE UserID >= 1;

ALTER TABLE Users ADD Password_hash_temp VARBINARY(MAX);
UPDATE Users
SET Password_hash_temp = CONVERT(VARBINARY(MAX), Password_hash);
EXEC sp_rename 'Users.Password_hash', 'Password', 'COLUMN';
ALTER TABLE Users DROP COLUMN Password_hash;


UPDATE Users 
SET Password = HASHBYTES('SHA2_256', 'admin1234') 
WHERE Username = 'admin';

UPDATE Users 
SET Password = HASHBYTES('SHA2_256', 'dosen1234') 
WHERE Username = 'spongebob';

UPDATE Users 
SET username = '123456' 
WHERE Username = 'spongebob';

UPDATE Users 
SET Password = HASHBYTES('SHA2_256', 'igaramadana') 
WHERE Username = 'igaramadana';

UPDATE Dosen 
SET UserID = 11
WHERE DosenID = 4;



CREATE TABLE Mahasiswa
(
    MhsID INT IDENTITY(1,1) PRIMARY KEY,
    UserID INT,
    NIM VARCHAR(20),
    Nama VARCHAR(50),
    Jurusan VARCHAR(50),
    Prodi varchar(50),
    Kelas VARCHAR(10),
    Angkatan VARCHAR(5),
    CONSTRAINT fk_user_id
    FOREIGN KEY (UserID) REFERENCES Users(UserID)
);
ALTER TABLE Mahasiswa ADD FotoProfil VARCHAR(255) NULL;


INSERT INTO Mahasiswa
    (UserID, NIM, Nama, Jurusan, Prodi, Kelas, Angkatan)
VALUES
    (6, '2341760083', 'Iga Ramadana Sahputra', 'Teknologi Informasi', 'D-IV Sistem Informasi Bisnis', 'SIB-2C', '2023');

SELECT *
FROM Mahasiswa;

CREATE TABLE Dosen
(
    DosenID INT IDENTITY(1,1) PRIMARY KEY,
    UserID INT,
    NIP VARCHAR(20),
    Nama VARCHAR(50),
    CONSTRAINT fk_user_id2
    FOREIGN KEY (UserID) REFERENCES Users(UserID)
);

SELECT * FROM Dosen;
INSERT INTO Dosen (UserID, NIP, Nama) VALUES
(5, '87654321', 'Dr. Spongebob');

CREATE TABLE Admin
(
    AdminID INT IDENTITY(1,1) PRIMARY KEY,
    UserID INT,
    Nama VARCHAR(50)
        CONSTRAINT fk_user_id3
    FOREIGN KEY (UserID) REFERENCES Users(UserID)
);

CREATE TABLE Users
(
    UserID INT IDENTITY(1,1) PRIMARY KEY,
    Username NVARCHAR(50) NOT NULL UNIQUE,
    Password VARBINARY(MAX) NOT NULL,
    Role NVARCHAR(20) CHECK (role IN ('admin', 'dosen', 'mahasiswa')) NOT NULL,
);

SELECT Dosen.DosenID, Dosen.NIP, Dosen.Nama AS NamaDosen, Users.Username, Users.Role
    FROM Dosen
    INNER JOIN Users ON Dosen.UserID = Users.UserID
WHERE Role = 'dosen';

SELECT *
FROM Users;

SELECT * FROM Dosen;

DELETE FROM Dosen
WHERE UserID IS NULL;