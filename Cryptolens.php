<?php

# ADDED:
#
# - function documentation
# - added type declaration to function parameters (Prevents returning false, if product id is passed as string)
# - added better error return value handling
#

/**
 * cryptolens_activate - Allows you to activate a license key through the Cryptolens API
 * 
 * @param string $token The access token from the website <https://app.cryptolens.io/User/AccessToken#/>
 * @param int $product_id The product id the license is for. You can get this Info by clicking on Products > [Your product] > "Product ID"
 * @param string $key The license key to activate
 * @param string $machine_code A unique machine code for the machine the license is being activated for. Length >= 1;
 * @return boolean|array Returns true on success and an array on failure. Details can be gained with the "error_message" key
 */
function cryptolens_activate(string $token, int $product_id, string $key, string $machine_code)
{

# Check 

  $params = 
    array(
        'token' => $token
      , 'ProductId' => $product_id
      , 'Key' => $key
      , 'Sign' => 'True'
      , 'MachineCode' => $machine_code
      , 'SignMethod' => 1
      , 'v' => 1
      );
  $postfields = '';
  $first = TRUE;
  foreach ($params as $i => $x) {
    if ($first) { $first = FALSE; } else { $postfields .= '&'; }

    $postfields .= urlencode($i);
    $postfields .= '=';
    $postfields .= urlencode($x);
  }
  unset($i, $x);

  $curl = curl_init();
  curl_setopt_array($curl, array(
      CURLOPT_RETURNTRANSFER => 1
    , CURLOPT_URL => 'https://app.cryptolens.io/api/key/Activate'
    , CURLOPT_POST => 1
    , CURLOPT_POSTFIELDS => $postfields
  ));
  $result = curl_exec($curl);
  curl_close($curl);

  $resp = json_decode($result);
  if ( is_null($resp)
    || !property_exists($resp, 'message')
    || $resp->{'message'} !== ''
    || !property_exists($resp, 'licenseKey')
    || !property_exists($resp, 'signature')
     )
  {
    return [
      "error_message" => "Either message, licenseKey or the signature is missing or empty in the Cryptolens response. Possibly the license key is invalid."
    ];
  }

  $license_key_string = base64_decode($resp->{'licenseKey'});
  if (!$license_key_string) { return ["error_message" => "Could not decode license key"]; }

  $license_key = json_decode($license_key_string);
  if ( is_null($license_key)
    || !property_exists($license_key, 'ProductId')
    || !is_int($license_key->{'ProductId'})
    || !property_exists($license_key, 'Key')
    || !is_string($license_key->{'Key'})
    || !property_exists($license_key, 'Expires')
    || !is_int($license_key->{'Expires'})
    || !property_exists($license_key, 'ActivatedMachines')
    //|| !is_iterable($license_key->{'ActivatedMachines'})
     )
  {
    return ["error_message" => "Either the license key is missing or some elements are in the incorrect type in the Cryptolens response"];
  }

  if ( $license_key->{'ProductId'} !== $product_id
    || $license_key->{'Key'} !== $key
     )
  {
    return ["error_message" => "Either the key or the product id might be incorrect."];
  }

  $machine_found = FALSE;
  foreach ($license_key->{'ActivatedMachines'} as $machine) {
    if (!property_exists($machine, 'Mid'))
    {
      return ["error_message" => "The License key has been already activated for this machine"];
    }

    if ($machine->{'Mid'} == $machine_code) { $machine_found = TRUE; }
  }
  unset($machine);
  if (!$machine_found) { return FALSE; }

  $time = time();
  if ($license_key->{'Expires'} < $time) { return ["error_message" => "Your key expired! Please get a new one."]; }
  return TRUE;
}

}}

?>
