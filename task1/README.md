### Оптимизированная таблица

```
CREATE TABLE `users` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `gender` varchar(20) NOT NULL COMMENT 'none – не указан, male - мужчина, female - женщина.',
    `birth_date` date NOT NULL,
    PRIMARY KEY (`id`),
    KEY `users_name_idx` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `users` VALUES 
    (1,'test_male_1','male','1995-01-01'),
    (2,'test_male_2','male','2001-01-01'),
    (3,'test_male_3','male','2010-01-01'),
    (4,'test_female_3','female','1995-01-01'),
    (5,'test_female_2','female','2001-01-01'),
    (6,'test_female_3','female','2010-01-01'),
    (7,'test_female_4','female','1998-01-01');
```
##### Комментарий
* Аттрибут name сделан обязательным (вряд ли нам потребуется хранить данные пользователя без его имени) и по нему добавлен индекс для поиска
* Аттрибут gender сделан текстовым для удобства чтения данных в БД (значения со смысловой нагрузкой, чтобы не нужно было запоминать значения)
* Аттрибут birth_date сделан типом дата, тоже для удобства чтения в БД

```
CREATE TABLE `phone_numbers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `phone` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `phone_numbers_phone_unique` (`phone`) USING BTREE,
  KEY `phone_numbers_fk` (`user_id`),
  CONSTRAINT `phone_numbers_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `phone_numbers` VALUES 
	(1,1,'+79001111111'),
	(2,2,'+79002222222'),
	(3,3,'+79003333333'),
	(4,4,'+79004444444'),
	(5,5,'+79005555555'),
	(6,6,'+79006666666'),
	(7,7,'+79007777777'),
	(8,5,'+79008888888');
```
##### Комментарий
* Аттрибут phone сделан короче, т.к. номер телефона помещается в 20 символов
* Добавлен внешний ключ для обеспечения целотности данных

##### Запрос, возвращающий имена и количества телефонных номеров девушек в возрасте от 18 до 22 лет
```
SELECT
	phone_numbers.user_id as user_id,
	users.name as user_name,
	TIMESTAMPDIFF(YEAR, users.birth_date, CURDATE()) as user_age,
	COUNT(phone_numbers.phone) as phones_count
FROM phone_numbers
JOIN
	users
ON
	phone_numbers.user_id = users.id
WHERE
	users.gender = 'female' AND TIMESTAMPDIFF(YEAR, users.birth_date, CURDATE()) BETWEEN 18 AND 22
GROUP BY
	phone_numbers.user_id;
```