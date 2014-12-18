# Laravel Cron Validator

## Installation

Begin by installing this package through Composer. Edit your project's `composer.json` file to require `coop182/laravel-cron-validator`.

    "require": {
        "coop182/laravel-cron-validator": "0.*"
    }

Next, update Composer from the Terminal:

    composer update

Once this operation completes, the final step is to add the service provider. Open `app/config/app.php`, and add a new item to the providers array.

    'Coop182\LaravelCronValidator\CronValidatorServiceProvider'
    
## Usage

Add the following to your Model's validation rules

    // Add your validation rules here
    public static $rules = [
        'cron_field' => 'cron_expression'
    ];
