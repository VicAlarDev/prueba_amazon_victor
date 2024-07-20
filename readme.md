
# Prueba Tecnica Symfony ⭐

This App is a showcase for the requested application for a technical test to apply for the position of developer in Widitrade.

## Deployment 🚀

To deploy this project run the init.sh file at the root of the project.

```bash
  ./init.sh
```

Make sure to first have already installed Docker and Docker-compose.

That script will do the following:

- Build and run the docker services.

- Install composer dependencies.

- Run the migrations to the database.

- Create a test user.

- Start the project at: [localhost](http://localhost)

## Environment Variables

To run this project, you will need to add the following environment variables to your `.env` file

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

For the resolution of the app I decided to create a command that will process the json and save the necesary content into the database.

I took in consideration the following reason to use this method:

- Processing all the JSON in every request will take more time and resources, this can be more notable when the JSON has a lot of content.

- With the data in the database gives more advantages like filtering, sort and manipulate.

- Using the command we have more benefits for the flexibility to modify an implement more features.
