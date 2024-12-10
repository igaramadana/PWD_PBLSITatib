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
    FotoProfil varchar(255)
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

ALTER TABLE dosen
ADD ProfilDosen VARCHAR(255);

UPDATE Dosen 
SET EmailDosen = 'jkw@example.com' 
WHERE Nama = 'jkw';


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

DELETE FROM Users
WHERE UserID = 39;

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


ALTER TABLE Sanksic
ADD PelanggaranID INT
CONSTRAINT fk_pelanggaran_id
FOREIGN KEY (PelanggaranID) REFERENCES Pelanggaran(PelanggaranID);

SELECT *
FROM Sanksi;

SELECT * FROM Pelanggaran;
DELETE FROM Pelanggaran
WHERE NamaPelanggaran IS NULL;

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


CREATE TABLE PengaduanPelanggaran (
    PengaduanID INT IDENTITY(1,1) PRIMARY KEY,
    MhsID INT NOT NULL,
    PelanggaranID INT NOT NULL,
    TanggalPengaduan DATE NOT NULL,
    StatusPelanggaran VARCHAR(20) CHECK (StatusPelanggaran IN ('Diajukan', 'Diproses', 'Selesai')),
    SanksiID INT,
    Catatan TEXT,
    BuktiPelanggaran VARCHAR(255)
    FOREIGN KEY (MhsID) REFERENCES Mahasiswa(MhsID),
    FOREIGN KEY (PelanggaranID) REFERENCES Pelanggaran(PelanggaranID),
    FOREIGN KEY (SanksiID) REFERENCES Sanksi(SanksiID)
);

ALTER TABLE PengaduanPelanggaran
ADD BuktiPelanggaran VARCHAR(255);

SELECT TanggalPengaduan FROM PengaduanPelanggaran WHERE PelanggaranID = [ID_Pelanggaran];

SELECT p.PelanggaranID, m.NIM, m.Nama, pp.Catatan, pp.StatusPelanggaran, m.FotoProfil,
          pp.BuktiPelanggaran, p.NamaPelanggaran, pp.TanggalPengaduan
          FROM PengaduanPelanggaran pp
          JOIN Mahasiswa m ON pp.MhsID = m.MhsID
          JOIN Pelanggaran p ON pp.PelanggaranID = p.PelanggaranID
          WHERE 1=1

SELECT p.PelanggaranID, m.NIM, m.Nama, pp.Catatan, pp.StatusPelanggaran, m.FotoProfil,
          pp.BuktiPelanggaran, p.NamaPelanggaran, pp.TanggalPengaduan
          FROM PengaduanPelanggaran pp
          JOIN Mahasiswa m ON pp.MhsID = m.MhsID
          JOIN Pelanggaran p ON pp.PelanggaranID = p.PelanggaranID
          WHERE pp.MhsID = 8;


-- Store Procedure Daftar Mahasiswa
CREATE PROCEDURE sp_GetMahasiswa
    @SearchTerm NVARCHAR(255),
    @StartFrom INT,
    @PerPage INT
AS
BEGIN
    SELECT m.MhsID, m.NIM, m.Nama, m.Jurusan, m.Prodi, m.Kelas, m.Angkatan, u.Username, u.Password, m.FotoProfil
    FROM Mahasiswa m
    INNER JOIN Users u ON m.UserID = u.UserID
    WHERE m.NIM LIKE @SearchTerm OR m.Nama LIKE @SearchTerm OR u.Username LIKE @SearchTerm
    ORDER BY m.MhsID
    OFFSET @StartFrom ROWS FETCH NEXT @PerPage ROWS ONLY
END
GO

-- Store Procedure Count MHS
CREATE PROCEDURE sp_CountMahasiswa
    @SearchTerm NVARCHAR(255)
AS
BEGIN
    SELECT COUNT(*) AS total
    FROM Mahasiswa m
    INNER JOIN Users u ON m.UserID = u.UserID
    WHERE m.NIM LIKE @SearchTerm OR m.Nama LIKE @SearchTerm OR u.Username LIKE @SearchTerm
END
GO

-- SP PelanggaranData
CREATE PROCEDURE GetPelanggaranData
    @Page INT,
    @PerPage INT,
    @Search NVARCHAR(255)
AS
BEGIN
    -- Declare variables for pagination
    DECLARE @StartFrom INT = (@Page - 1) * @PerPage;

    -- Calculate total count of matching records
    SELECT COUNT(*) AS Total
    FROM Pelanggaran
    WHERE Pelanggaran.NamaPelanggaran LIKE '%' + @Search + '%';

    -- Fetch the paginated results
    SELECT 
        Pelanggaran.PelanggaranID, 
        Pelanggaran.NamaPelanggaran, 
        TingkatPelanggaran.Tingkat
    FROM Pelanggaran
    JOIN TingkatPelanggaran 
        ON Pelanggaran.TingkatID = TingkatPelanggaran.TingkatID
    WHERE Pelanggaran.NamaPelanggaran LIKE '%' + @Search + '%'
    ORDER BY Pelanggaran.PelanggaranID
    OFFSET @StartFrom ROWS 
    FETCH NEXT @PerPage ROWS ONLY;
END;
GO

BACKUP DATABASE DBEthicX TO DISK = N'/home/gatrons/DBEthicX3.bak' WITH FORMAT, INIT;
GO
