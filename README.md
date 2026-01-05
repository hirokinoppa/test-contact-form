# 確認テスト お問い合わせフォーム

## 環境構築

## Dockerビルド
- git clone git@github.com:hirokinnoppa/test-contact-form.git
- docker-compose up -d --build

## Laravel環境構築
- docker compose exec php bash
- composer install
- cp .env.example .env
- php artisan key:generate
- php artisan migrate
- php artisan db:seed

## 開発環境
- お問い合わせフォーム：http://localhost/
- ユーザー登録：http://localhost/register
- 管理画面：http://localhost/admin
- phpMyAdmin：http://localhost:8080/

## 使用技術（実行環境）
- PHP 8.2.11
- Laravel 8.83.8
- MySQL 8.0.34
- nginx 1.21.1

## ER図
![ER図](docs/images/er.png)