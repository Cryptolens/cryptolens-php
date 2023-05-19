# Cryptolens PHP

This repository contains functions for interacting with the Cryptolens
Web API from PHP. Currently only a few endpoints are supported and more are following.

To use the library, you can `require_once` the `loader.php` which loads all other classes automatically.
Inside your script you need to `use` the classes, here is an example:

## Code example

```php
<?php
ini_set("display_errors", 1);
require_once "./loader.php";
use Cryptolens_PHP_Client\Cryptolens;
use Cryptolens_PHP_Client\Key;
$c = new Cryptolens("YOUR_TOKEN", 12345);
$k = new Key($c);

$key = "XXXXX-XXXXX-XXXXX-XXXXX";
$machine_id = "MACHINE-ID";

echo "<pre>";
print_r("Key 'activate':" . var_dump($k->activate($key, $machine_id)));
?>
```

The code above uses our testing access token, product id, license key and machine code.
In a real values for you can be obtained as follows:

* Access tokens can be created at <https://app.cryptolens.io/User/AccessToken> (remember to check 'Activate' and keep everything else unchanged)
* The product id is found by selecting the relevant product from the list of products
   (<https://app.cryptolens.io/Product>), and then the product id is found above the list
   of keys.
* The license key would be obtained from the user in an application dependant way.
* Currently the PHP library does not compute the machine code, either the machine
   code can be computed by the application, or a dummy value can be used. In a future
   release the library itself will compute the machine code.

## Endpoints

* Key
  * [x] activate
  * [x] deactivate
  * [x] create_key
  * [x] create_trial_key
  * [ ] create_key_from_template
  * [ ] get_key
  * [ ] add_feature
  * [ ] block_key
  * [ ] extend_license
  * [ ] remove_feature
  * [ ] unblock_key
  * [ ] machine_lock_limit
  * [ ] change_notes
  * [ ] change_reseller
  * [ ] change_customer
