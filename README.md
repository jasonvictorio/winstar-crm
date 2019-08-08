# Winstar_crm
Winstar's CRM system to manage its customers and projects

# Setup

1. Clone repository
2. Install composer
3. If laravel is not installed run:
  composer global require laravel/installer
4. rename env.example to .env
5. Install dependencies run: 
  composer update
6. generate app key:
  php artisan key:generate
7. Set server root to winstar_crm\public

# Migrations & Seeding

1. Create DB
2. Edit .env DB config as needed
3. Run*: php artisan migrate
4. Run: php artisan db:seed
5. Run: php artisan storage:link

--If you get the foreign key incorrectly formed error, during migrations change int lengths of both the related table columns to match and unsigned.

