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

SELECT *
FROM Dosen;
INSERT INTO Dosen
    (UserID, NIP, Nama)
VALUES
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

SELECT *
FROM Dosen;

DELETE FROM Dosen
WHERE UserID IS NULL;

-- Table Pelanggaran
-- Membuat Tabel Pelanggaran
CREATE TABLE Pelanggaran
(
    PelanggaranID INT IDENTITY(1,1) PRIMARY KEY,
    -- Kolom auto-increment
    NamaPelanggaran VARCHAR(200),
    -- Nama pelanggaran (panjang maksimal 200 karakter)
    Tingkat INT,
    -- Tingkat pelanggaran (misalnya: tingkat 1, 2, 3, dll)
    SanksiID INT NOT NULL,
    -- SanksiID yang menghubungkan ke tabel Sanksi
    CONSTRAINT fk_sanksi_id FOREIGN KEY (SanksiID) REFERENCES Sanksi(SanksiID)
    -- Constraint FOREIGN KEY
);


CREATE TABLE Sanksi
(
    SanksiID INT IDENTITY
(1,1) PRIMARY KEY,
    NamaSanksi varchar
(200)
);

ALTER TABLE Pelanggaran
DROP COLUMN SanksiID;


ALTER TABLE Sanksi
ADD PelanggaranID INT
CONSTRAINT fk_pelanggaran_id
FOREIGN KEY (PelanggaranID) REFERENCES Pelanggaran(PelanggaranID);

SELECT *
FROM Sanksi;

DROP TABLE Pelanggaran;

CREATE TABLE Pelanggaran
(
    PelanggaranID INT IDENTITY(1,1) PRIMARY KEY,
    NamaPelanggaran VARCHAR(255),
    TingkatID INT
        CONSTRAINT fk_tingkat_id2 FOREIGN KEY (TingkatID) REFERENCES TingkatPelanggaran(TingkatID)
)

CREATE TABLE TingkatPelanggaran
(
    TingkatID INT IDENTITY(1,1) PRIMARY KEY,
    Tingkat INT,
)

CREATE TABLE Sanksi
(
    SanksiID INT IDENTITY(1,1) PRIMARY KEY,
    TingkatID INT,
    NamaSanksi VARCHAR(255)
    CONSTRAINT fk_tingkat_id
    FOREIGN KEY (TingkatID) REFERENCES TingkatPelanggaran(TingkatID)
)

ALTER TABLE TingkatPelanggaran
ADD SanksiID INT CONSTRAINT fk_sanksi_id
FOREIGN KEY (SanksiID) REFERENCES Sanksi(SanksiID)

ALTER TABLE Sanksi
ADD CONSTRAINT fk_tingkat_id
FOREIGN KEY (TingkatID) REFERENCES TingkatPelanggaran(TingkatID)

INSERT INTO TingkatPelanggaran (Tingkat)
VALUES (1),(2),(3),(4),(5);

SELECT * FROM Pelanggaran;
INSERT INTO Pelanggaran (NamaPelanggaran, TingkatID)
VALUES ('Berkomunikasi dengan tidak sopan, baik tertulis atau tidak
tertulis kepada mahasiswa, dosen, karyawan, atau orang lain', 5);
