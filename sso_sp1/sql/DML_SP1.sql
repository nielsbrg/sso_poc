USE `sso_sp1_db`;

INSERT INTO users(username, password, taalcode, startdatum, einddatum, actief, aanhef, voornaam, tussenvoegsel,
                  achternaam, geslacht, straat, huisnummer, huisnummertoevoeging,
                  postcode, plaats, landcode, telefoon, email, bedrijfsnaam, afbeelding, role_id, created, creator, modified, modifier)
VALUES
('hpu','$2y$10$HZFFQogAZab2wcGmvfXkiOgD70gtzdQUnYv8SOZU..kE5VCZoOptK',
'nl', '2018-01-22', '0000-00-00', 1, '', 'Sander', '', 'Keurentjes', '', 'Innovatieweg',
20, '', '7007CD', 'Doetinchem', 'nl', '0612345678', 'sander.k@hpu.nl', '', '', 1, NOW(), NULL, NULL, NULL),

('JasperBouman','$2y$10$U2zqjQ9w5BTP0VXl9ozHMe/33lVGcM6VKlME11tJ0njt8N1QS7k3W',
'nl', '2017-09-05', '0000-00-00', 1, 'Professor', 'Jasper', '', 'Bouman', 'M', 'Innovatieweg',
20, 'B', '7007CD', 'Doetinchem', '61', '0314-365008', 'jasper@hpu.nl', 'HPU Internetservices', 'fm/userfiles/users/20170703-182016.jpg', 4, NOW(), NULL, NULL, NULL),

('JasperBouman-copy','$2y$10$p9En6n1pFgh5LXtaNmyGaejJMS4/Lcsj/WsAd9cOyfgIJb9y3zq8q',
'nl', '2017-09-05', '0000-00-00', 1, 'Professor', 'Jasper', '', 'Bouman', 'M', 'Innovatieweg',
20, 'B', '7007CD', 'Doetinchem', '61', '0314-365008', 'jasper@hpu.nl', 'HPU Internetservices', 'fm/userfiles/users/20170703-182016-1.jpg', 4, NOW(), NULL, NULL, NULL),

('webshop','$2y$10$Skzvf/35YuZ2kBE.vr7PjuXcOFzTphyJ9b1sDs/tdMBoUr9d4pb6C',
'nl', '2017-09-27', '0000-00-00', 1, 'drs.', 'Anja', 'von', 'Fickenstein', 'M', 'Wilhemstraße',
4058, 'Q', '98745', 'Chemnitz', '', '060000000', 'anja@vonfickenstein.de', 'Kattentrimsalon de kale kat', '', 3, NOW(), NULL, NULL, NULL),

('hpu','$2y$10$cQdsDwJjz4pYsMuWptQ4mOZ.BVCNS.WFYy9EipdbYT3M3VX9RjxXm',
'nl', '2018-01-22', '0000-00-00', 1, '', 'Sander', '', 'Keurentjes', '', 'Innovatieweg',
20, '', '7007CD', 'Doetinchem', 'nl', '0612345678', 'sander.k@hpu.nl', '', '', 1, NOW(), NULL, NULL, NULL),

('hpu','$2y$10$XGm3kKextivxIhtKTlujVOTl9x4nif9SIBzcqpULM8AybLdqxT9Ni',
'nl', '2018-01-22', '0000-00-00', 1, '', 'Sander', '', 'Keurentjes', '', 'Innovatieweg',
20, '', '7007CD', 'Doetinchem', 'nl', '0612345678', 'sander.k@hpu.nl', '', '', 1, NOW(), NULL, NULL, NULL);