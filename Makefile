init: refresh-user

refresh-user: clear-user insert-user

clear-user:
	sudo -u postgres psql hashbon_mvc_db -c 'TRUNCATE TABLE users;';

# password: qwerty123
insert-user:
	sudo -u postgres psql hashbon_mvc_db -c "insert into users (username, password, balance) values ('mozart', '3fc0a7acf087f549ac2b266baf94b8b1', 1000);";
