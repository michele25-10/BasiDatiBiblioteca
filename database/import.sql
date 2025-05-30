USE library; 

-- Inserimento dipartimenti
insert into department(name, address) values
("Architettura", "Via Ghiara, 36 - 44121 Ferrara"),
("Economia e Managment", "Via Voltapaletto n.11 - 44121 Ferrara"), 
("Fisica e Scienze della Terra", "Via Saragat, 1 - 44121 Ferrara"), 
("Giurisprudenza", "Corso Ercole l d'Este n. 37 - 44121 Ferrara"), 
("Ingegneria", "Via Saragat, 1 - 44121 Ferrara"), 
("Matematica e Informatica", "Via Macchiavelli, 30 - 44121 Ferrara"), 
("Medicina Traslazionale e per la Romagna", "Via Luigi Borsarsi, 46 - 44121 Ferrara"), 
("Neuroscienze e Riabilitazione", "Via Luigi Borsari, 46 - 44121 Ferrara"), 
("Scienze Chimiche, Farmaceutiche ed Agrarie", "Via Luigi Borsari, 46 - 44121 Ferrara"),
("Scienze dell'Ambiente e della Prevenzione", "Via Luigi Borsari, 46 - 44121 Ferrara"), 
("Scienze della Vita e Biotecnologie", "Via Luigi Borsari, 46 - 44121 Ferrara"), 
("Scienze Mediche", "Via Fossato di Mortara, 64/B - 44121 Ferrara"), 
("Studi Umanistici", "Via Paradiso, 12 - 44121 Ferrara");

-- Inserimento libri
INSERT INTO book (ISBN, title, publication_year, language) VALUES
('978-3-16-148410-0', 'The Architecture of Space', 2005, 'Italian'),
('978-1-4028-9462-6', 'Economic Strategies for the Future', 2012, 'English'),
('978-0-262-13472-9', 'Physics Beyond the Standard Model', 2018, 'French'),
('978-0-14-044913-6', 'The Law of Civil Societies', 2010, 'German'),
('978-0-123-45678-9', 'Engineering Modern Systems', 2015, 'Spanish');

-- Inserimento autori
INSERT INTO author (name, surname, birth_date, birth_place) VALUES
('Mario', 'Rossi', '1965-07-12', 'Rome'),
('Anna', 'Bianchi', '1970-11-23', 'Milan'),
('Jean', 'Dupont', '1958-04-10', 'Paris'),
('Hans', 'Müller', '1962-01-30', 'Berlin'),
('Carlos', 'Gomez', '1975-09-14', 'Madrid');

-- Associazione libro-autore
INSERT INTO book_author (ISBN, author_name, author_surname, author_birth_date, author_birth_place) VALUES
('978-3-16-148410-0', 'Mario', 'Rossi', '1965-07-12', 'Rome'),
('978-1-4028-9462-6', 'Anna', 'Bianchi', '1970-11-23', 'Milan'),
('978-0-262-13472-9', 'Jean', 'Dupont', '1958-04-10', 'Paris'),
('978-0-14-044913-6', 'Hans', 'Müller', '1962-01-30', 'Berlin'),
('978-0-123-45678-9', 'Carlos', 'Gomez', '1975-09-14', 'Madrid');

-- Inserimento utenti
INSERT INTO user (serial_number, name, surname, telephone, address) VALUES
('U00001', 'Luigi', 'Verdi', '+390531234567', 'Via Roma 1, Ferrara'),
('U00002', 'Giulia', 'Neri', '+390532345678', 'Via Bologna 15, Ferrara'),
('U00003', 'Luca', 'Bruni', '+390533456789', 'Via Modena 20, Ferrara');

-- Inserimento copie
INSERT INTO copy (ISBN, department_name) VALUES
('978-3-16-148410-0', 'Architettura'),
('978-1-4028-9462-6', 'Economia e Managment'),
('978-0-262-13472-9', 'Fisica e Scienze della Terra'),
('978-0-14-044913-6', 'Giurisprudenza'),
('978-0-123-45678-9', 'Ingegneria'),
('978-0-123-45678-9', 'Ingegneria'); -- seconda copia dello stesso libro

-- Inserimento prestiti
INSERT INTO loan (copy_code, serial_number, start_date) VALUES
(1, 'U00001', '2025-05-20 10:00:00'),
(2, 'U00002', '2025-05-21 11:00:00'),
(3, 'U00001', '2025-05-22 09:30:00'),
(4, 'U00003', '2025-05-23 14:00:00'),
(5, 'U00002', '2025-05-24 15:30:00');
