### Задача №1

Имеется база со следующими таблицами:

```
CREATE TABLE `users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) DEFAULT NULL,
  `gender` INT(11) NOT NULL COMMENT '0 – не указан, 1 - мужчина, 2 - женщина.',
  `birth_date` INT(11) NOT NULL COMMENT 'Дата в unixtime.',
  PRIMARY KEY (`id`)
);

CREATE TABLE `phone_numbers` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `phone` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
);
```

Оптимизируйте структуру таблиц и напишите запрос, возвращающий имена и количества телефонных номеров девушек в возрасте от 18 до 22 лет.

### Задача №2

Имеется строка:

*https://www.somehost.com/test/index.html?param1=4&param2=3&param3=2&param4=1&param5=3*

Напишите функцию (предпочтительно с использованием механизмов Yii2), которая:

1. удалит параметры со значением “3”;
2. отсортирует параметры по значению;
3. добавит параметр url со значением из переданной ссылки без параметров (в примере: /test/index.html);
4. сформирует и вернёт валидный URL на корень указанного в ссылке хоста.

В указанном примере функцией должно быть возвращено: *https://www.somehost.com/?param4=1&param3=2&param1=4&url=%2Ftest%2Findex.html*

### Задача №3

Напишите код в парадигме ООП, соответствующий следующей структуре.

**Сущности:** Пользователь, Статья.  
**Связи:** Один пользователь может написать несколько статей. У каждой статьи может быть только один пользователь-автор.

Функциональность:
* возможность для пользователя создать новую статью;
* возможность получить автора статьи;
* возможность получить все статьи конкретного пользователя;
* возможность сменить автора статьи.

Если вы применили какие-либо паттерны при написании, укажите какие и с какой целью.

Код, реализующий конкретную функциональность, не требуется, только общая структура классов и методов. Код должен быть прокомментирован в стиле PHPDoc.

### Задача №4

Проведите рефакторинг, исправьте баги и продокументируйте в стиле PHPDoc код, приведённый ниже (таблица users здесь аналогична таблице users из задачи №1).
*Примечание:* код написан исключительно в тестовых целях, это не "жизненный пример" :)

```
function load_users_data($user_ids) {
  $user_ids = explode(',', $user_ids);
  foreach ($user_ids as $user_id) {
    $db = mysqli_connect("localhost", "root", "123123", "database");
    $sql = mysqli_query($db, "SELECT * FROM users WHERE id=$user_id");
    while($obj = $sql->fetch_object()){
      $data[$user_id] = $obj->name;
    }
    mysqli_close($db);
  }

return $data;
}

// Как правило, в $_GET['user_ids'] должна приходить строка с номерами пользователей через запятую, например: 1,2,17,48

$data = load_users_data($_GET['user_ids']);

foreach ($data as $user_id=>$name) {
  echo "<a href=\"/show_user.php?id=$user_id\">$name</a>";
}
```

Плюсом будет, если укажете, какие именно уязвимости присутствуют в исходном варианте (если таковые, на ваш взгляд, имеются), и приведёте примеры их проявления.

### Задача №5

Необходимо разработать на Yii2 минисервис по управлению списком услуг. Он должен состоять из двух частей: админ-панель (для CRUD) и простого RESTful API (для получения информации об услугах).

Услуга (Service) имеет следующие атрибуты:

1. Название
2. Код
3. Цена
4. Описание
5. Статус (включена/выключена)
6. Срок действия
7. Город действия

Пользователи могут совершать следующие действия:

1. Создание услуги
2. Включение/выключение услуги
3. Редактирование остальных параметров

В API должно быть как минимум 2 метода:

1. Получение списка услуг в указанном городе
2. Просмотр информации о конкретной услуге по ее id

Необходимо задействовать встроенные в фреймворк механизм миграций.
Должен использоваться шаблон приложения advanced. Реализацию недостающих и неуказанных сущностей (например User) делайте по своему усмотрению.
Если есть уточняющие вопросы — задавайте.

### Задача №6

Доработать класс yii\db\ActiveRecord: 
1. При удалении записи (метод delete) - запись должна помечаться на удаление, но не удаляться. Описать требования к структуре таблиц БД.
2. Запрет повторного вызова удаления помеченной на удаление записи. 3) Реализовать метод восстановления помеченной на удаление записи.
