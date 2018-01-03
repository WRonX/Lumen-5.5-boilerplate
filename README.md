## Lumen 5.5 boilerplate

This was created to make working with Lumen a bit faster, especially when it comes to deal with thousands of microservices.

**This is still a work in progress.** Feel free to let me know about any problems.


#### Installation

```
git clone https://github.com/WRonX/Lumen-5.5-boilerplate.git
cd Lumen-5.5-boilerplate
nano .env.example
cp .env.example .env
composer install
``` 

(well, you know, what I mean)

#### Components used

##### Third party components

1. [Lumen](https://github.com/laravel/lumen) (duh...)
2. [Roave Security Advisories](https://github.com/Roave/SecurityAdvisories)
2. [Laravel IDE Helper](https://github.com/barryvdh/laravel-ide-helper) (`dev` only)
3. [Laravel Debugbar](https://github.com/barryvdh/laravel-debugbar) (`dev` only)
4. [Lumen Generator](https://github.com/flipboxstudio/lumen-generator) (`dev` only)

Check them out, if you don't know, what they do.

##### Other added components

There's simplified version of Laravel's `ThrottlesLogins` trait (with an example in controller), custom route helper function for unit tests and a JSON request middleware. You probably will see it once you check it out. Feel free not to use it at all.


#### Tips 

1. If you don't have DB connection credentials configured, IDE helper will report an error when trying to run `php artisan ide-helper:models` (it's added to post-update scripts in `composer.json`).
2. On production environment, post-install script will report errors, because `IDE helper` will not be present. This is probably going to be fixed with custom script to avoid problems with automated deploy. 
3. You may need to enable facades (uncomment `$app->withFacades();` in `bootstrap/app.php`) 