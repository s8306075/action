## 簡要說明

使用 Laravel 8 + MariaDB + Apache2 架構，Template 使用 [Paper Dashboard 2](https://github.com/creativetimofficial/paper-dashboard)

## Docker 開發環境

1. Clone 專案
2. 
    ```
    cd action
    ```
3. 
    ```
    cp .env.example .env
    ```
4. 
    ```
    docker-compose up -d
    ```
5. 
    ```
    docker-compose exec web bash
    ```
6. 
    ```
    composer install
    ```
7. 
    ```
    php artisan key:generate
    ```
8. 改 .env 檔 `DB_HOST=mysql`
9. 
    ```
    php artisan migrate --seed
    ```
10. URL 輸入 `http://localhost:8001`
