<?php

/**
 * @param string $userIds
 * @return array
 */
function load_users_data(string $userIds): array
{
    $userIds = explode(',', $userIds);
    // Подключение к БД осуществляем один раз
    $mysqli = new \mysqli('localhost', 'root', '123123', 'database');
    if ($mysqli->connect_errno) {
        echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
    // Создаем текст для части запроса с массивов
    $in = implode(',', array_fill(0, count($userIds), '?'));
    // Подготавливаем запрос, чтобы избежать инъекции
    $statement = $mysqli->prepare("SELECT * FROM users WHERE id IN ($in)");
    // привязываем параметры к подготовленному запросу, считаем что ИД у нас - это число
    $statement->bind_param(str_repeat('i', count($userIds)), ...array_values($userIds));
    // выполняем запрос
    $statement->execute();
    $result = $statement->get_result();
    // сохраняем результат запроса как массив объектов
    $data = [];
    while ($obj = $result->fetch_object()) {
        $data[] = $obj;
    }
    // Закрываем соединение с БД
    $statement->close();
    $mysqli->close();

    return $data;
}

// Как правило, в $_GET['user_ids'] должна приходить строка
// с номерами пользователей через запятую, например: 1,2,17,48

$data = load_users_data($_GET['user_ids']);

foreach ($data as $user) {
    echo "<a href=\"/show_user.php?id={$user->id}\">{$user->name}</a>";
}