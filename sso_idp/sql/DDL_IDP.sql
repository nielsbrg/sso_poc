DROP DATABASE IF EXISTS sso_idp_db;

CREATE DATABASE sso_idp_db;

USE sso_idp_db;

CREATE TABLE System (
	system_id INT(10) AUTO_INCREMENT NOT NULL,
	name VARCHAR(255) NOT NULL,
	CONSTRAINT PK_System PRIMARY KEY(system_id)
);

CREATE TABLE SystemDomain (
	system_id INT(10) NOT NULL,
	domain_name VARCHAR(255) NOT NULL,
	CONSTRAINT PK_SystemDomain PRIMARY KEY (system_id, domain_name),
	CONSTRAINT FK_SystemDomain_System FOREIGN KEY (system_id)
		REFERENCES System(system_id)
);

CREATE TABLE SystemMigrationApi(
  system_id INT(10) NOT NULL,
  api_url VARCHAR(255) NOT NULL,
  CONSTRAINT PK_SystemMigrationApi PRIMARY KEY (system_id),
  CONSTRAINT FK_SystemMigrationApi_System FOREIGN KEY (system_id)
    REFERENCES System(system_id)
);

CREATE TABLE User (
	system_id INT(10) NOT NULL,
	user_id INT(10) NOT NULL,
	username VARCHAR(255) NOT NULL,
	password VARCHAR(255) NOT NULL,
	CONSTRAINT PK_User PRIMARY KEY(system_id, user_id),
	CONSTRAINT FK_User_System FOREIGN KEY (system_id) 
		REFERENCES System (system_id) ON DELETE CASCADE
);

CREATE TABLE SystemUserSession (
	system_id INT(10) NOT NULL,
	user_id INT(10) NOT NULL,
	session_id VARCHAR(255) NOT NULL,
	expires_at DATETIME NOT NULL,
	created_at DATETIME NOT NULL,
	CONSTRAINT PK_SystemUserSession PRIMARY KEY(system_id, user_id),
	CONSTRAINT FK_SystemUserSession FOREIGN KEY (system_id, user_id)
		REFERENCES User(system_id, user_id)
);