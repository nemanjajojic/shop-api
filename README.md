# Shop API

Change dir to `[my-app-name]` with the desired directory name for your new application. You'll want to:

* Point your virtual host document root to your new application's `public/` directory.
* Ensure `logs/` is web writable.

## Install dependencies
Install dependencies via command
```bash
composer install
```

## ENV vars
Edit following env vars in `.env` file in order to setup database connection:
* `DB_HOST`
* `DB_NAME`
* `DB_USERNAME`
* `DB_PASSWORD`

To run the application in development, you can run these commands 

```bash
cd [my-app-name]
composer start
```
After that, open `http://localhost:8080` in your browser.

Run this command in the application directory to run the test suite

```bash
composer test
```
### OpenAPI documentation
Doc files are in `[my-app-name]/swagger-doc` and JSON documentation is available via api endpoint for swagger
 ui which btw, is not included in this project. Endpoint is 
 `http://localhost:8080/open-api`