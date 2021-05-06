# Alpha IT Centre - Helpdesk

This is a helpdesk system. Has Company / Organization management, user permissions, SMS / Email integrateion, built on top of Laravel Jetstream using inertia.

---

## Installation

1. Clone the repository with git clone


```shell script
git clone git@github.com/codemonkey76/ait_helpdesk.git
```

2. Install composer dependencies

```shell script
composer install
```

3. Create .env file (using .env.example template)

```shell script
cp .env.example .env
```

4. Generate application key

```shell script
php artisan key:generate
```

5. Install and compile node dependencies

```shell script
npm install && npm run dev
```

6. Migrate database (optional seeding)

```shell script
php artisan migrate --seed
```

