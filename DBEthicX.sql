CREATE DATABASE DBEthicX;
GO

USE DBEthicX;

CREATE TABLE Users (
    UserID INT IDENTITY(1,1) PRIMARY KEY,
    Username NVARCHAR(50) NOT NULL UNIQUE,
    Password_hash NVARCHAR(255) NOT NULL,
    Role NVARCHAR(20) CHECK (role IN ('admin', 'dosen', 'mahasiswa')) NOT NULL,
);

INSERT INTO Users (Username, Password_hash, Role) 
VALUES ('admin', HASHBYTES('SHA2_256', 'admin1234'), 'admin'),
('spongebob', HASHBYTES('SHA2_256', 'dosen1234'), 'dosen'),
('patrik', HASHBYTES('SHA2_256', 'mahasiswa1234'), 'mahasiswa'),
('igaramadana', HASHBYTES('SHA2_256', 'igaramadana'), 'admin');

SELECT * FROM Users;

DELETE FROM Users
WHERE UserID >= 1;

ALTER TABLE Users ADD Password_hash_temp VARBINARY(MAX);
UPDATE Users
SET Password_hash_temp = CONVERT(VARBINARY(MAX), Password_hash);
EXEC sp_rename 'Users.Password_hash', 'Password', 'COLUMN';
ALTER TABLE Users DROP COLUMN Password_hash;





UPDATE Users 
SET Password_hash = HASHBYTES('SHA2_256', 'admin1234') 
WHERE Username = 'admin';

UPDATE Users 
SET Password_hash = HASHBYTES('SHA2_256', 'dosen1234') 
WHERE Username = 'spongebob';

UPDATE Users 
SET Password_hash = HASHBYTES('SHA2_256', 'mahasiswa1234') 
WHERE Username = 'patrik';

UPDATE Users 
SET Password_hash = HASHBYTES('SHA2_256', 'igaramadana') 
WHERE Username = 'igaramadana';

