# Changelog

## v0.6

* added support to Reseller endpoints `addReseller`, `editReseller`, `removeReseller`, `getResellers` and `getResellerCustomers`

## v0.5

* now supporting the Messages endpoints `createMessage`, `removeMessage` and `getMessages`
* rewritten some error messages

## v0.4.3

* `$additional_flags` is now parsed correctly to the `Helper::build_params()` function
* booleans are now parsed correctly to the Cryptolens API
* added support for Payment Form endpoint `createSession`
* updated `README.md` with another Code Example and updated the current status of the machine ID generation
* small changes to the `composer.json`
* fixed return values for `Key::activate()` to now return arrays on errors to be compliant with the `Helper::outputHelper()` function


## v0.4.2

* fixed require path for `Cryptolens::loader()`-function

## v0.4.1

* added two functions to generate a machine ID for the PHP instance. `Key::getMachineId()` returns a hash of the machine ID, whereas `Key::getMachineIdPlain()` returns the machine ID in readable format, not hashed. Read the function documentation for information of this hash being calculated.

## v0.4

* outsourced helper function into the `Helper.cryptolens.php` class
* improved error messages and removed unnecessary information on failure
* added the `Auth.cryptolens.php` which brings support to the `keyLock` Auth endpoint
* added the `Product.cryptolens.php` to support the `getKeys` and `getProducts` endpoint

## v0.3.1

* added support for composer
* minor change to the `unblock_key`-function, it now returns a true on success and not the full Cryptolens response

## v0.3

* added support for Key endpoints `removeFeature`, `unblockKey`, `machineLockLimit`

## v0.2

* removed debugging code
* fixed incorrect array keys for `createTrialKey`-endpoint
* added support for Key endpoints `createKeyFromTemplate`, `getKey`, `addFeature`, `blockKey` and `extendLicense`
* added the possibility to change the output format to either JSON or PHP, therefore added the `$output` variable to the `Cryptolens` constructor
  * when using `Cryptolens::CRYPTOLENS_OUTPUT_PHP` as output, it significantly increases the time to load, where as `Cryptolens::CRYPTOLENS_OUTPUT_JSON` works way faster
  * certain functions return only a boolean, therefore they are not affected by this setting

## v0.1

* added Cryptolens classes
* added support for Key endpoints `activate`, `deactivate`, `createKey` and `createTrialKey`
