init: refresh-user-table refresh-user

refresh-user: clear-user insert-user

clear-user:
	sudo -u postgres psql hashbon_mvc_db -c 'TRUNCATE TABLE users;';

# password: qwerty123
insert-user:
	sudo -u postgres psql hashbon_mvc_db -c "insert into users (username, password, balance) values ('mozart', '3fc0a7acf087f549ac2b266baf94b8b1', 1000);";

refresh-user-table: drop-users-table create-users-table

create-users-table:
	sudo -u postgres psql hashbon_mvc_db -c 'CREATE TABLE users (id bigserial PRIMARY KEY, username varchar(50) NOT NULL UNIQUE, password varchar(50) NOT NULL, balance int NOT NULL default 0);';

drop-users-table:
	sudo -u postgres psql hashbon_mvc_db -c 'DROP TABLE users;';

