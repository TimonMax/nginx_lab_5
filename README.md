# Лабораторная работа №5: Работа с MySQL через PHP и Docker


## 👩‍💻 Автор
**ФИО:** Фаткин Артем Александрович  
**Группа:** 2ПМ-1  

---

## 📌 Описание задания
1. Научиться работать с базой данных MySQL через PHP.
2. Создать таблицу для данных формы.
3. Сохранять данные формы в базу данных.
4. Выводить данные из базы на странице.
5. Использовать классы PHP для работы с таблицей.
6. Работать с Docker контейнерами: nginx (уже есть), PHP-FPM, MySQL, Adminer.
http://localhost:8080

---

## ⚙️ Как запустить проект

### 1. Клонировать репозиторий
```bash
git clone https://github.com/TimonMax/nginx_lab_5.git
cd nginx_lab_5
```
### 2. Запустить контейнеры Docker
```bash
docker-compose up -d --build
```
### 3. Открыть в браузере
```bash
http://localhost:8080
```
### 4. Проверка работы
1. Форма для заполнения
2. Просморт заявок
3. Adminer
```bash
http://localhost:8080/form.html
http://localhost:8080/index.php
http://localhost:8081
```
## Содержимое проекта
```docker-compose.yml``` — описание сервиса Nginx

```Dockerfile``` — параметры для запуска

```www/form.html``` — главная HTML-страница с формой

```www/index.php``` — подключает form.html

```www/process.php``` — серверный обработчик: валидация, сессия, запись в БД

```www/db.php``` — База данных

```nginx/default.conf``` — файл для обработки PHP

```www/RepairRequest.php``` — класс заявки

```www/delete.php``` — удаление записи

```www/edit.php``` — редактирование имени записи