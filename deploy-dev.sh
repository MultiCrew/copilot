#!/bin/sh
set -e

echo "Deploying application ..."

# Enter maintenance mode
(php artisan down --message 'The app is being (quickly!) updated. Please try again in a minute.') || true
    # Update codebase
    git fetch origin dev
    git reset --hard origin/dev

    # Install dependencies based on lock file
    composer install --no-interaction --prefer-dist --optimize-autoloader

    # Migrate database
    php artisan migrate --force

    # Compile frontend
    npm install
    npm run prod

    # Clear cache
    php artisan optimize

# Exit maintenance mode
php artisan up

echo "Application deployed!"
