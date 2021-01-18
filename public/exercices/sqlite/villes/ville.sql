DROP TABLE IF EXISTS villes;

CREATE TABLE villes(
    id INT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    code_postal VARCHAR(5) NOT NULL
);

DROP TABLE IF EXISTS habitations;

CREATE TABLE habitations(
    id INT PRIMARY KEY,
    num_addr VARCHAR(255) NOT NULL, 
    rue VARCHAR(255) NOT NULL,
    ville INT NOT NULL REFERENCES villes(id) ON DELETE CASCADE ON UPDATE CASCADE
);

DROP TABLE IF EXISTS habitants;

CREATE TABLE habitants(
    id INT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL, 
    prenom VARCHAR(255) NOT NULL,
    date_naissance DATE NOT NULL,
    habitation INT NOT NULL REFERENCES habitations(id) ON DELETE CASCADE ON UPDATE CASCADE
);


INSERT INTO villes (id,nom, code_postal) VALUES    (1,'Lille','59000'),
                                                (2,'Lens', '62300');


INSERT INTO habitations (id, num_addr, rue,ville) VALUES    (1,'140', 'Rue du guet', 1),
                                                        (2,'16', 'Rue de l''université', 2);

INSERT INTO habitants (id, nom, prenom, date_naissance, habitation) VALUES  (1,'Bonnaire','Eric','1995-11-13', 1),
                                                                        (2,'Cernuta','Valentin','2000-12-22', 2);
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

-- SELECT * from habitants;
--
-- SELECT * from habitants where prenom like 'Eric';
--
-- SELECT habitants.*, num_addr, rue from habitants join habitations h on habitants.habitation = h.id;
--
-- SELECT * from villes ORDER BY code_postal desc;
--
-- SELECT v.nom , COUNT(*) as 'nb_habitations' from habitations join villes v on habitations.villes = v.id GROUP BY v.nom;
--
-- SELECT YEAR(date_naissance) as 'annee de naissance' from habitants where prenom like 'Eric';