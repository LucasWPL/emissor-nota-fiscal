up:
	docker-compose up
stop:
	docker-compose stop
down:
	docker-compose down
build:
	docker-compose up --build
install:
	docker exec -it emissor-nota-fiscal-php composer install
update:
	docker exec -it emissor-nota-fiscal-php composer update
db:
	docker exec -it emissor-nota-fiscal-mysql bash -c "mysql -uroot -proot"
php:
	docker exec -it emissor-nota-fiscal-php bash
