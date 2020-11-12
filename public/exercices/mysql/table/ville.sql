DROP TABLE IF EXISTS villes;

CREATE TABLE villes(
    id INT PRIMARY KEY AUTO_INCREMENT, 
    nom VARCHAR(255) NOT NULL,
    code_postal VARCHAR(5) NOT NULL,
    pays VARCHAR(255) NOT NULL
);

DROP TABLE IF EXISTS habitations;

CREATE TABLE habitations(
    id INT PRIMARY KEY AUTO_INCREMENT,
    num_addr VARCHAR(255) NOT NULL, 
    rue VARCHAR(255) NOT NULL,
    ville INT NOT NULL REFERENCES villes(id) ON DELETE CASCADE ON UPDATE CASCADE
);

DROP TABLE IF EXISTS habitants;

CREATE TABLE habitants(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(255) NOT NULL, 
    prenom VARCHAR(255) NOT NULL,
    date_naissance DATE NOT NULL,
    habitation INT NOT NULL REFERENCES habitations(id) ON DELETE CASCADE ON UPDATE CASCADE
);


-- INSERT INTO villes (nom, code_postal, pays) VALUES    ('Lille','59000','France'),
--                                                 ('Lens', '62300', 'France');
--
--
-- INSERT INTO habitations (num_addr, rue,ville) VALUES    ('140', 'Rue du guet', 1),
--                                                         ('16', 'Rue de l''université', 2);
--
-- INSERT INTO habitants (nom, prenom, date_naissance, habitation) VALUES  ('Bonnaire','Eric','1995-11-13', 1),
--                                                                         ('Cernuta','Valentin','2000-12-22', 2);
--
-- UPDATE habitants SET prenom = 'Nicolas' WHERE prenom like 'Eric';
--
-- UPDATE habitants SET nom = 'Houillon';
--
--
-- DELETE FROM villes where nom = 'Lille';
--
--
-- TRUNCATE TABLE habitants;
--
--
-- DROP TABLE habitants;