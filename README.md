## Google Mining
### Requirements

- PHP Version
````
PHP ^<8.0
````

- [Google Custom Search for Laravel](https://github.com/jdrda/laravel-google-custom-search-engine)

- [HTML Dom Parser](https://github.com/Kub-AT/php-simple-html-dom-parser)

### Configuration
routes/web.php for need.
````
app/Providers/RouteServiceProvider.php
protected $namespace = 'App\\Http\\Controllers';
````
Google Custom Search EngineId and API Config
````
laravelGoogleCustomSearchEngine.php
````

### Informations
- [HTML DOM Parser Example](https://github.com/juangsalaz/php-scrapping/blob/master/app/Exports/DataExport.php) 
- Cron test : php artisan schedule:run 

Login
admin
rk973na9UBTH
