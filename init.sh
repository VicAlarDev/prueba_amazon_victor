#!/bin/bash

set -e 

echo "Starting Docker containers..."
docker-compose up -d --build

echo "Installing Composer dependencies..."
docker-compose exec php composer install

echo "Applying Doctrine migrations..."
docker-compose exec php symfony console doctrine:migrations:migrate --no-interaction

echo "Creating test user..."
docker-compose exec php symfony console app:create-test-user --no-interaction

echo "Processing JSON..."
docker-compose exec php symfony console app:process-json --no-interaction

echo "Setup complete!"
