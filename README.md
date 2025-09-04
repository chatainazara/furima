# Furima

## 環境構築

### Docker ビルド

1. git clone git@github.com:chatainazara/furima.git
2. DockerDesktop アプリを立ち上げる
3. docker-compose up -d --build

### Laravel 環境構築

1. docker-compose exec php bash

2. composer install

3. cp .env.example .env

4. .env に以下の環境変数を追加または変更
   DB_CONNECTION=mysql
   DB_HOST=mysql
   DB_PORT=3306
   DB_DATABASE=laravel_db
   DB_USERNAME=laravel_user
   DB_PASSWORD=laravel_pass

MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@example.com"
MAIL_FROM_NAME="${APP_NAME}"

STRIPE_KEY=pk_test_xxxxxxxxxxxxxxxxx（<-stripe の API キーをコピー）
STRIPE_SECRET=sk_test_xxxxxxxxxxxxxxxxx（<-stripe の API キーをコピー）

5. アプリケーションキーの作成
   php artisan key:generate

6. マイグレーションの実行
   php artisan migrate

7. シーディングの実行
   php artisan db:seed

8. シンボリックリンクの作成
   php artisan storage:link

### 決済実行用のダミークレジットカード

No 4242 4242 4242 4242
期限とセキュリティコードは任意の数字

### テストの実行

1. 本アプリのテストを一度に実行
   vendor/bin/phpunit tests/Feature

## 使用技術(実行環境)

1. PHP: 8.1.33
2. Laravel: 8.83.29
3. MySQL: 8.0.2
4. nginx: 1.21.1
5. mailhog: 1.0.1
6. stripe: 17.6

## ER 図

![ER図](src/document/er_diagram.png)

## URL

### 開発環境

1. phpMyAdmin: http://localhost:8080
2. ユーザー登録画面: http://localhost/register
3. ホーム画面: http://localhost/
4. MailHog: http://localhost:8025
