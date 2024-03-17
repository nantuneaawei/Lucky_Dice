### 安裝步驟

- 複製編輯 .env
```
cp .env.example .env
HOST設定 : .env : DB_HOST=db
```
## Docker

- 建立docker環境 : docker-compose up -d
- 進入app : docker-compose exec -it app /bin/sh

- 安裝套件 & 設定 app key
```
docker-compose exec app composer install
docker-compose exec app php artisan key:generate
```
## yarn

- yarn run dev
- npm run dev

## laravel migrate

- 建立資料表 : docker-compose exec app php artisan migrate
- 建立測試資料 : docker-compose exec app php artisan db:seed

## PHPUnit

- 單元測試 : docker-compose exec app vendor/bin/phpunit