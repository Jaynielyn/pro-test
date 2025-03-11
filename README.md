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

## CSVインポート機能
1. 管理者画面でcsvインポート機能導入
2. 「ファイルを選択」をクリックしpro-test/shops-data.csvを挿入。(プロジェクトディレクトリ直下)
3. その内容を下の方に表示され確認できる。
4. 「インポート」をクリックするとshopsテーブルに保存される。
5. 一般ユーザーのトップページにも反映され表示される。

## 備考
基本口コミを記入できる。但し1店舗に対し1件の口コミのみしか追加することはできない。