# Changelog

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
