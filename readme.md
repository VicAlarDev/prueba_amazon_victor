
# Symfony Technical Test Project ⭐

This application is a demonstration for the technical test required to apply for the developer position at Widitrade.

## Deployment 🚀

To deploy this project, run the init.sh script located at the project's root directory.

```bash
  ./init.sh
```

Prerequisites: Ensure you have Docker and Docker Compose installed before running the script.

That script will do the following:

- Build and run the docker services.

- Install Composer dependencies for the project.

- Execute database migrations to set up the database schema.

- Create a test user for initial access.

- Start the project at: [localhost](http://localhost)

## Environment Variables

To run this project successfully, you'll need to add the following environment variables to your `.env` file

Example:

```bash
# Project name
COMPOSE_PROJECT_NAME=dockersymfony

# PostgreSQL settings
POSTGRES_HOST=postgres
POSTGRES_DB=landing
POSTGRES_USER=dbuser
POSTGRES_PASSWORD=dbpassword
POSTGRES_HOST_PORT=5432
POSTGRES_CONTAINER_PORT=5432

INSTALL_XDEBUG=false

# www user
PUID=1000
PGID=1000

APP_ENV=dev
APP_SECRET=00000

DATABASE_URL="postgresql://${POSTGRES_USER}:${POSTGRES_PASSWORD}@postgres:${POSTGRES_CONTAINER_PORT}/${POSTGRES_DB}?serverVersion=13&charset=utf8"
MESSENGER_TRANSPORT_DSN=doctrine://default?auto_setup=0
```

## Explanation

I chose to implement a command for processing the JSON data and storing the relevant content in the database.  This decision was based on several key reasons:

- Processing all the JSON in each request will take more time and resources, this can be more notable when the JSON has a lot of content.

- Having the data in a database enables efficient filtering, sorting, and other data manipulation operations.

- Utilizing a command offers greater flexibility for future modifications and feature enhancements.
