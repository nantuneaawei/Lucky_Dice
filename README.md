### 安裝步驟

- 複製編輯 .env
```
cp .env.example .env
HOST設定 : .env : DB_HOST=db
```

## 修改.env
```
APP_URL=http://localhost:8080
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

## 修改權限：
如果發現權限不正確(出現The stream or file "/var/www/html/storage/logs/laravel.log" could not be opened in append mode: Failed to open stream: Permission denied The exception occurred while attempting to log)，你可以在容器內使用 chmod 命令修改權限。例如，將存儲目錄及其子目錄的權限設置為 775：
```
chmod -R 775 /var/www/html/storage

chmod -R ugo+rw storage
```

## 安裝vue
```
docker-compose exec app npm install vue@3.4.21 vue-router@4.2.5
```
出現Error [ERR_MODULE_NOT_FOUND]: Cannot find package '@vitejs/plugin-vue' imported from
```
docker-compose exec app npm install @vitejs/plugin-vue
```
## 
```
docker-compose exec app npm install
docker-compose exec app npm run dev
```

##
出現在console(http://localhost:5173/@vite/client net::ERR_EMPTY_RESPONSE)
```
docker-compose exec app npm run build
```