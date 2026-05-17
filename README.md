## About Project

In this project, you can track the exchange rate in real time 

## Requirements 

- PHP 8.2+
- Laravel 12
- Composer
- MySQL
- HTML, Tailwind, JavaScript
- ApexCharts 
- Frankfurter API

## Currency Module

- USD
- EUR
- GBP
- UAH

## Admin Panel

- currency management;
- viewing exchange rates;
- the ability to initiate synchronization.
- URL: http://127.0.0.1:8000/admin
- Email: test@example.com
- Password: password

## --------------------SETUP--------------------

## Set dependencies

```bash
composer install
```

## Create a database

```bash
php artisan migrate --seed
```


## Starting the server 

```bash
php artisan serve
```

## API 

GET - `/api/currencies` (list of currencies )
GET - `/api/rates?currency=EUR` (Exchange rates)
GET -  `/api/chart?currency=EUR&days=7` (Data for the graph)

## Sync historical data

```bash
php artisan rates:sync --from=2025-01-01 or Admin Panel
```

## Clone repository

```bash
git clone https://github.com/your-username/currency-app.git
cd currency-app
```