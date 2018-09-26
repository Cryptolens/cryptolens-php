<?php

function cryptolens_activate($token, $product_id, $key, $machine_code)
{
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
    return FALSE;
  }

  $license_key_string = base64_decode($resp->{'licenseKey'});
  if (!$license_key_string) { return FALSE; }

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
    return FALSE;
  }

  if ( $license_key->{'ProductId'} !== $product_id
    || $license_key->{'Key'} !== $key
     )
  {
    return FALSE;
  }

  $machine_found = FALSE;
  foreach ($license_key->{'ActivatedMachines'} as $machine) {
    if (!property_exists($machine, 'Mid'))
    {
      return FALSE;
    }

    if ($machine->{'Mid'} == $machine_code) { $machine_found = TRUE; }
  }
  unset($machine);
  if (!$machine_found) { return FALSE; }

  $time = time();
  if ($license_key->{'Expires'} < $time) { return FALSE; }

  return TRUE;
}

?>
