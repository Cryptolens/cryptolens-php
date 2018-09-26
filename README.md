# Cryptolens PHP

This repository contains functions for interacting with the Cryptolens
Web API from PHP. Currently only activation of keys is supported.

## Code example

```php
<?php
require_once('Cryptolens.php');

$activate = cryptolens_activate(
      // Access token
      'WyI0NjUiLCJBWTBGTlQwZm9WV0FyVnZzMEV1Mm9LOHJmRDZ1SjF0Vk52WTU0VzB2Il0='
      // Product Id
    , 3646
      // License Key
    , 'MPDWY-PQAOW-FKSCH-SGAAU'
      // Machine code
    , '289jf2afs3'
    );

// $activate is now a boolean indicating if the activation attempt was successful or not

?>
```

The code above uses our testing access token, product id, license key and machine code.
In a real values for you can be obtained as follows:

 * Access tokens can be created on app.cryptolens.io by in the main menu
   (Hello, <username>!) -> Access Tokens -> Create new Access Token.
 * The product id is found by selecting the relevant product from the list of products
   (https://app.cryptolens.io/Product), and then the product id is found above the list
   of keys.
 * The license key would be obtained from the user in an application dependant way.
 * Currently the PHP library does not compute the machine code, either the machine
   code can be computed by the application, or a dummy value can be used. In a future
   release the library itself will compute the machine code.
