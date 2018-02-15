USE sso_sp2_db;

DELETE FROM user;

INSERT INTO user(username, password, firstname, surname, email, phone, mobilePhone, roleId)
VALUES
('admin', '$2y$14$cCSLRYNudnI7mWHdwmWiOeXlzel/1dEeWAf113EeXXcrp1uzQUixi', 'Rick', 'Roelofsen', 'rick@hpu.nl', '05754684544', '0681147505', 1),
('klant', '$2y$14$ilgFHl2zt4d587XilN2/4eGqhcyRSDiPzvo.qwP5VI4RlAEOy5ZJO', 'Joop', 'Jansen', 'email@adres.de', '0575-460000', '06-00000000', 1),
('klant2', '$2y$14$/wzkzxjvYLtcrfPvjvnS5Of56YyN251jePXbKsVV8cd3ZYCFmtuve', 'Drikus', 'Air', 'email@adres.de', '0575-460000', '06-00000000', 1),
('dennie', '$2y$14$x6U4Yl8FrIw9uVvhjeVtsuHu0Oi.lQAlU2vmm2Q.DzE3iPMOarVDa', 'Dennie', 'Rensink', 'dennie@hpu.nl', '615173914', '615173914', 1);