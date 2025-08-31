# Furima

## 環境構築

### Docker ビルド

1. git clone git@github.com:chatainazara/furima.git
2. DockerDesktop アプリを立ち上げる
3. docker-compose up -d --build

### Laravel 環境構築

1. docker-compose exec php bash

2. composer install

3. 「.env.example」ファイルを 「.env」ファイルに命名を変更。

4. .envに以下の環境変数を追加
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass

5. アプリケーションキーの作成
php artisan key:generate

6. マイグレーションの実行
php artisan migrate

7. シーディングの実行
php artisan db:seed

8. シンボリックリンクの作成
php artisan storage:link

### テストの実行

1. 本アプリのテストを一度に実行
vendor/bin/phpunit tests/Feature

## 使用技術(実行環境)

PHP: 8.1.33
Laravel: 8.83.29
MySQL: 8.0.2
nginx: 1.21.1

## ER 図

![ER図](document/ER図.png)

## URL

### 開発環境

phpMyAdmin: http://localhost:8080
ユーザー登録: http://localhost/register
ホーム画面: http://localhost/
