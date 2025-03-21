# Русский

## Проект по организации кошек

Этот проект предназначен для управления и организации кошек. Ниже приведены шаги для настройки и запуска проекта на локальной машине.

---

### Установка

Следуйте этим шагам, чтобы настроить проект на вашем локальном компьютере:

1. **Клонируйте репозиторий**:
   ```bash
   git clone git@github.com:thomas666-beast/cats-organization.git
   cd cats-organization
   ```

2. **Настройте файл окружения**:
    * CСкопируйте файл .env.example в .env:
   ```bash
   cp .env.example .env
   ```
    * Откройте файл .env и обновите конфигурацию базы данных с вашими учетными данными MariaDB:
   ```dotenv
   DB_HOST=your_database_host
   DB_PORT=your_database_port
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_username
   DB_PASSWORD=your_database_password
   ```
3. **Установите зависимости:**:
   * Запустите следующую команду для установки необходимых PHP зависимостей:
    ```bash
    composer install
    ```
  
4. **Запустите миграции базы данных:**:
    * Выполните скрипт миграции для создания таблиц ```cats``` и ```cat_fathers``` в вашей базе данных:
    ```bash
    php migrations/create_cats_table.php
    ```

5. **Запустите сервер разработки:**:
    * Запустите встроенный PHP сервер для запуска приложения:
    ```bash
    php -S localhost:8000 -t public
    ```

6. **Доступ к приложению:**:
    * Откройте ваш браузер и перейдите по адресу http://localhost:8000, чтобы просмотреть и протестировать приложение. <b>Удачного тестирования!</b>

7. **Запуск тестов (опционально):**:
    * Если вы хотите запустить тестовый набор, используйте следующую команду:
    ```bash
   ./vendor/bin/phpunit
    ```

## Примечание::
* Убедитесь, что MariaDB установлена и запущена на вашем компьютере перед настройкой проекта.
* Если вы столкнулись с проблемами во время настройки, дважды проверьте ваш файл .env на правильность учетных данных базы данных.


# English

## Cats Organization Project

This project is designed to manage and organize cats. Below are the steps to set up and run the project locally.

---

### Installation

Follow these steps to set up the project on your local machine:

1. **Clone the repository**:
   ```bash
   git clone git@github.com:thomas666-beast/cats-organization.git
   cd cats-organization
   ```

2. **Set up the environment file**:
   * Copy the .env.example file to .env:
   ```bash
   cp .env.example .env
   ```
   * Open the .env file and update the database configuration with your MariaDB credentials:
   ```dotenv
   DB_HOST=your_database_host
   DB_PORT=your_database_port
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_username
   DB_PASSWORD=your_database_password
   ```
3. **Install dependencies:**:
   * Run the following command to install the required PHP dependencies:
    ```bash
   composer install
    ```

4. **Run database migrations**:
    * Execute the migration script to create the ```cats``` and ```cat_fathers``` tables in your database:
    ```bash
    php migrations/create_cats_table.php
    ```

5. **Start the development server**:
    * Run the built-in PHP server to launch the application:
    ```bash
    php -S localhost:8000 -t public
    ```

6. **Access the application**:
   * Open your browser and navigate to http://localhost:8000 to view and test the application. <b>Happy testing!</b>

7. **Running Tests (Optional)**:
   * If you want to run the test suite, use the following command:
    ```bash
   ./vendor/bin/phpunit
    ```
   
## Note:
* Ensure that MariaDB is installed and running on your machine before setting up the project.
* If you encounter any issues during setup, double-check your .env file for correct database credentials.
