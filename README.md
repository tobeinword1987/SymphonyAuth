1)Клонируйте проект

2)В корневой директории проекта выполните следующие команды:

    2.1 php bin/console server:start

    2.2 php bin/console doctrine:database:drop --force (Это в случае, если БД уже была создана ранее)

    2.3 php bin/console doctrine:database:create (Создание БД)

    2.4 php bin/console doctrine:schema:update --force (Создание таблиц в БД)

    2.5 php bin/console doctrine:schema:validate (синхронизация БД и сущностей в проекте)

3)(Выполните эти запросы в любом sql редакторе, так как я создала отдельную таблицу с возможными интересами пользователей)
INSERT INTO `interest` (`id`, `hobby`) VALUES
(1, 'music'),
(2, 'sport');

4)Пройдите по адресу http://localhost:8000/auth
Начала с такого адреса, так как не захотела портить страницу, полученную при создании проекта (http://localhost:8000/auth).
Оттуда очень удобно путешествовать по документации)

Файл с настройками я не ложила в гитигнор, чтоб не надо было долго настройки прописывать, это же всего лишь тестовый проект)

PS. Тут еще много чего можно дорабатывать. Например, у меня не реализован rest API, так же пароли у меня это простые
строковые значения.Я не создавала их с использованием хэш функций. В формах отсутствует csrf токены. Я довольно долго
копалась в документации. Таки симфони отличается от ларавель, но как мне показалось он будет помощнее)) особенно при
работе с БД.

Если описанное выше все же надо доработать, напишите, я доделаю.