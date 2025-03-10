# pro-test

## Dockerビルド
1. git clone git@github.com:Jaynielyn/pro-test.git
2. docker-compose up -d --build

## 環境構築
1. docker-compose exec php bash
2. composer install
3. cp .env.example .env
4. .env.exampleファイルから.envを作成し、環境変数を変更
5. php artisan key:generate
6. php artisan migrate
7. php artisan db:seed

## 使用技術
Laravel Framework 8.83.29

## URL
環境開発:http://localhost
phpMyAdmin:http://localhost:8080/

## 備考
基本口コミを記入できる。但し1店舗に対し1件の口コミのみしか追加することはできない。