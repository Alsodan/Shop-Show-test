Для отображения я не подключал никаких дополнительных виджетов, все сделано силами "чистого" фреймворка

API также не вынесен в отдельный модуль, чтобы не усложнять (поэтому и не имеет версионирования).
Запросы к API:
* Получение списка услуг в указанном городе - /api/services?city=cityTitle
* Просмотр информации о конкретной услуге по ее id - /api/services/<serviceId>