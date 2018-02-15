USE sso_idp_db;

INSERT INTO System (name)
VALUES('WMS'), ('Klantportaal');

INSERT INTO SystemDomain (system_id, domain_name)
VALUES
((SELECT system_id FROM System WHERE name='WMS'), 'http://localhost:8001'),
((SELECT system_id FROM System WHERE name='Klantportaal'), 'http://localhost:8002');