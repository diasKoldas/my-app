
<h1>Мои инструменты QueryBuilder и Route храняться в директории [vendor/diaskoldas/..]</h1>

<h2>Инструмент по работе с базой данных QueryBuilder [vendor/diaskoldas/my-querybuilder]:</h2>
<p>1) Состоит из двух файлов QueryBuilder.php и QueryFactory.php</p>
<p>2) Их нужно подключить к проекту</p>
<p>3) Для стандартных запросов используйте экземпляр класса MyQueryBuilder\QueryBuilder:</p>
<p>Код подключения:</p>
<ul>
<li>$queryBuilder = new QueryBuilder(
new PDO('mysql:host=localhost;dbname=app2;charset=utf8;','root',''),
new QueryFactory());
</li>
</ul>
<p>Он принемает два параметра:</p>
<ul>
<li>1) Экземпляр готового к работе класса PDO</li>
<li>2) Экземпляр класса MyQueryBuilder\QueryFactory</li>
</ul>
<p>Методы возвращают:</p>
<ul>
<li>Массив данных полученных с базы</li>
</ul>
<p>Методы:</p>
<ul>
<li>1) Возвращает одну запись с таблицы: $queryBuilder->getOne(string $table_name, integer $id)</li>
<li>2) Возвращает все записи с таблицы: $queryBuilder->getAll(string $table_name)</li>
<li>3) Удаляет одну запись с таблицы: $queryBuilder->delete(string $table_name, integer $id)</li>
<li>
4) Добавляет одну запись в таблицу: $queryBuilder->add(string $table_name, array $data)
<ul>
<li>Формат записи второго параметра $data: Array('название столбца в таблице' => 'значение')</li>
</ul>
</li>
<li>
5) Обновляет значения одной записи в таблице: $queryBuilder->update(string $table, array $data, integer $id)
<ul>
<li>Формат записи второго параметра $data: Array('название столбца в таблице' => 'значение')</li>
</ul>
</li>
</ul>
<p>4) Для построения своих sql запросов используйте экземпляр класса MyQueryBuilder\QueryFactory:</p>
<p>Код подключения:</p>
<ul>
<li>$queryFactory = new QueryFactory();</li>
</ul>
<p>Методы возвращают:</p>
<ul>
<li>Сгенерированную строку SQL запроса</li>
</ul>
<p>Примечания:</p>
<ul>
<li>Всегда перед построением новой строки SQL запроса, объявляйте об этом методом: $queryFactory->newSelect()</li>
<li>
Пример того как выглядит построения двух строк SQL запросов:
<ul>
<li>
$queryFactory->newSelect();<br>
$queryFactory
->cols(['*'])
->from('posts');
</li>
<li>
$queryFactory->newSelect();<br>
$queryFactory
->cols(['*'])
->from('users');
</li>
</ul>
</li>
</ul>
<p>Методы:</p>
<ul>
<li>1) Объявит о построении новой строки SQL: $queryFactory->newSelect()</li>
<li>2) Возвратит строку "INSERT INTO $table": $queryFactory->insert(string $table)</li>
<li>
3) Возвратит строку "($keys) VALUES ($values)": $queryFactory->values(array $data)
<ul>
<li>
Формат параметра:
<ul>
<li>Array('название столбца таблици' => 'значение')</li>
</ul>
</li>
</ul>
</li>
<li>Возвратит строку "UPDATE $table": $queryFactory->update(string $table)</li>
<li>
Возвратит строку " SET $data": $queryFactory->set(array $data)
<ul>
<li>
Формат параметра:
<ul>
<li>Array('название столбца таблици' => 'значение')</li>
</ul>
</li>
</ul>
</li>
<li>Возвратит строку "DELETE": $queryFactory->delete()</li>
<li>
Возвратит строку "SELECT $cols": $queryFactory->cols(array $cols)
<ul>
<li>
фармат записи для передаваемого параметра:
<ul>
<li>Array('title','name', n..) - массив с названиями колонок</li>
<li>Array('*') - все колонки</li>
</ul>
</li>
</ul>
</li>
<li>Возвратит строку " FROM $table": $queryFactory->from(string $table)</li>
<li>
Возвратит строку " WHERE $data": $queryFactory->where(array $data)
<ul>
<li>
Формат параметра:
<ul>
<li>Array('название столбца таблици' => 'значение')</li>
</ul>
</li>
</ul>
</li>
<li>Возвратит готовую SQL строку: $queryFactory->getStatement()</li>
<li>Возвратит готовый массив данных для меток: $queryFactory->getBindParams()</li>
</ul>
<p>Пример запроса:</p>
<p>
$this->queryFactory->newSelect();<br>
$this->queryFactory
->cols(['*'])
->from('posts');<br>

$sth = $this->pdo->prepare($this->queryFactory->getStatement());<br>
$sth->execute($this->queryFactory->getBindParams());<br>

$posts = $sth->fetchAll(PDO::FETCH_ASSOC);<br>
</p>


<h2>Инструмент по работе с http запросами "Маршрутизатор" Route [vendor/diaskoldas/my-route]:</h2>

<p>1) состоит из трех файлов: Route.php, Parser.php, Helper.php</p>
<ul>
<li>Route.php - происходят все главные процессы для роутинга</li>
<li>Parser.php - парсит данные для работы роутинга</li>
<li>Helper.php - просто маленький помошник который можно не использовать</li>
</ul>
<p>2) Их нужно подключить к проекту</p>
<p>3) Для работы используйте сам класс MyRoute\Route</p>
<p>4) Основное что делает MyRoute\Route это два действия:</p>
<ul>
<li>Добавляет/Регистрирует ваши шаблоны для http запросов</li>
<li>Проверяет http запрос пользователя на соответствие шаблонам которые вы добавили/зарегистрировали</li>
</ul>
<p>5) Примеры использования роутов:</p>
<ul>
<li>
<p>Добавление роутов:</p>
<ul>
<li>
Route::addRoute("GET","/home", [MainController::class, 'index']);
<ul>
<li>Первый параметр это тип запроса: "POST","GET"</li>
<li>
Второй параметр это шаблон запроса:
<ul>
<li>Статичный строгий шаблон "/gallery": "/gallery/space/13"</li>
<li>Нестатичный строгий шаблон с обязательными параметрами "/{tag_name}": "/gallery/{tag_name}/{id:\d+}"</li>
<li>Нестатичный гибкий шаблон с необязательными параметрами "[/{id:\d+}]": "/gallery/{tag_name}[/{id:\d+}]"</li>
</ul>
</li>
<li>Третий параметр это массив из двух элементов (первый это класс, второй метод этого класса)</li>
</ul>
</li>
</ul>
</li>
<li>
<p>Проверка http запроса:</p>
<ul>
<li>
$routeInfo = Route::checkQuery($ttpMethod, Helper::prepareQuery($_SERVER['REQUEST_URI']));
<ul>
<li>
Принимаемые параметры:
<ul>
<li>$ttpMethod - это метод запроса POST или GET</li>
<li>Helper::prepareQuery($_SERVER['REQUEST_URI']) - это запрос пользователя без GET параметров</li>
</ul>
</li>
</ul>
<ul>
<li>
$routeInfo будет содержать в себе:
<ul>
<li>
Статус проверки: $routeInfo['status']
<ul>
<li>1 - Запрос прошел проверку</li>
<li>2 - Неверный метод обращения запроса</li>
<li>0 - Запрос не прошел проверку</li>
</ul>
</li>
<li>Обработчик и его метод: $routeInfo[1]</li>
<li>Массив переменных: $routeInfo['vars']</li>
</ul>
</li>
</ul>
</li>

</ul>
</li>
</ul>
