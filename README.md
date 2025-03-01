# Tecnofit Ranking API

API de ranking de movimentos para usuários. Desenvolvida em Laravel 10.

## 📋 Pré-requisitos

- PHP 8.2
- Composer 2.6
- MySQL 8.0
- Laravel 10.3

## 🚀 Instalação
Documentação: <a href="https://laravel.com/docs/10.x"> ref : LARAVEL </a>
 ```
composer create-project "laravel/laravel:^10.0" tecnofit
```
- Permissão pasta storage (Linux)
```
sudo chmod 777 -R storage/
```
 **Clonar repositório**
```
git clone git@github.com:Alikson-Ramos/Tecnofit.git
cd tecnofit
```
**Instalar dependências**
```
composer install
```
**Configurar ambiente**
```
cp .env.example .env
php artisan key:generate
```

## 🛠️ Base de dados MySql
- No arquivo .env
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tecnofit
DB_USERNAME=root
DB_PASSWORD=
```
## 🛠️ Instalando Migrations
```
php artisan migrate
```
## 🛠️ Seeders

```bash
php artisan db:seed --class=MovementSeeder
```
## 🧪 Dados Iniciais
O seeder inclui:

3 usuários

3 movimentos

17 registros de performance

## ▶️ Executar Servidor
```
php artisan serve
```
## 🔍 Testar Endpoints
```
GET http://127.0.0.1:8000/api/movements/{id}/ranking
```
Exemplo para Deadlift:

```
http://127.0.0.1:8000/api/movements/1/ranking
```
![image](https://github.com/user-attachments/assets/a9840f0a-2505-4851-ac5c-69d9fa1bcde5)

Exemplo para Back Squat:

```
http://127.0.0.1:8000/api/movements/2/ranking
```
![image](https://github.com/user-attachments/assets/c2c0c51f-1768-4560-a15d-e88af7cf9856)

Exemplo para Bench Press:

```
http://127.0.0.1:8000/api/movements/3/ranking
```
![image](https://github.com/user-attachments/assets/afd8d9f2-e6fc-41db-8e21-dd7ae1a6e215)

Exemplo para Erro:

```
http://127.0.0.1:8000/api/movements/999/ranking
```
![image](https://github.com/user-attachments/assets/8fcfe73a-1271-4f26-b08c-2969e9fa759c)

## 📚 Documentação Adicional

Documentação Laravel 10

Postman Collection (disponível na pasta docs)

## ⚙️ Especificações Técnicas

PHP 8.2.12

Laravel 10.3.3

MySQL 8.0

Arquitetura REST

Desenvolvido por Alikson Ramos - 2025 📦🚀


