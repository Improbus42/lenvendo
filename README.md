Установка
------------


1.Для сборки docker контейнера используйте:


    docker-compose up -d
    

2.Далее выполняем следующую команду:


    docker-compose exec php-cli bash
    
    
3.Запуск composer:


    composer install
    
    
4.Выполняем миграции:


    php artisan migrate
    
    

Использование
-----

Переходим по адресу http://localhost:88

P.S. Пароль: lenvendo
