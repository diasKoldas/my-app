<h1>Мои инструменты QueryBuilder и Route храняться в директории [vendor/diaskoldas/..]</h1>
    <h2>Инструмент по работе с базой данных QueryBuilder [vendor/diaskoldas/my-querybuilder]:</h2>
    <p>1) Состоит из двух файлов QueryBuilder.php и QueryFactory.php</p>
    <p>2) Их нужно подключить к проекту</p>
    <p>3) Для стандартных запросов используйте экземпляр класса MyQueryBuilder\QueryBuilder:</p>
    <p>Код подключения:</p>
    <div>
        <ul>
            <li>$queryBuilder = new QueryBuilder(
                new PDO('mysql:host=localhost;dbname=app2;charset=utf8;','root',''),
                new QueryFactory());</li>
        </ul>
    </div>
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
                    $queryFactory->newSelect();</br>
                    $queryFactory
                    ->cols(['*'])
                    ->from('posts');
                </li>
                <li>
                    $queryFactory->newSelect();</br>
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
        <li>4) Возвратит строку "UPDATE $table": $queryFactory->update(string $table)</li>
        <li>
            5) Возвратит строку " SET $data": $queryFactory->set(array $data)
            <ul>
                <li>
                    Формат параметра:
                    <ul>
                        <li>Array('название столбца таблици' => 'значение')</li>
                    </ul>
                </li>
            </ul>
        </li>
        <li>6) Возвратит строку "DELETE": $queryFactory->delete()</li>
        <li>
            7) Возвратит строку "SELECT $cols": $queryFactory->cols(array $cols)
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
        <li>8) Возвратит строку " FROM $table": $queryFactory->from(string $table)</li>
        <li>
            9) Возвратит строку " WHERE $data": $queryFactory->where(array $data)
            <ul>
                <li>
                    Формат параметра:
                    <ul>
                        <li>Array('название столбца таблици' => 'значение')</li>
                    </ul>
                </li>
            </ul>
        </li>
        <li>10) Возвратит готовую SQL строку: $queryFactory->getStatement()</li>
        <li>11) Возвратит готовый массив данных для меток: $queryFactory->getBindParams()</li>
    </ul>
    <p>Пример запроса:</p>
    <p>
        $this->queryFactory->newSelect();</br>
        $this->queryFactory
        ->cols(['*'])
        ->from('posts');</br>

        $sth = $this->pdo->prepare($this->queryFactory->getStatement());</br>
        $sth->execute($this->queryFactory->getBindParams());</br>

        $posts = $sth->fetchAll(PDO::FETCH_ASSOC);</br>
    </p>
