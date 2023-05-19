<?php
namespace Cryptolens_PHP_Client {
    class Key {
        private Cryptolens $cryptolens;

        public function __construct($cryptolens){
            $this->cryptolens = $cryptolens;
        }

        /**
         * activate() - Activates a Key
         * 
         * @param string $key The key to activate
         * @param string $machineid A unique ID for the machine the key is being activated
         * @return bool|array Returns an array with the Cryptolens reponse and the decoded license including informations about the key itself. Returns false on failure.
         * @link https://app.cryptolens.io/docs/api/v3/activate
         */
        public function activate($key, $machineid){
            $parms = $this->build_params($this->cryptolens->get_token(), $this->cryptolens->get_product_id(), $key, $machineid);
            $c = $this->connection($parms, "activate");
            if($c == true){
                $license = json_decode(base64_decode($c["licenseKey"]), true);
                # check for missing license elements
                if(is_null($license) ||
                !array_key_exists("ProductId", $license)||
                !array_key_exists("Key", $license)||
                !array_key_exists("Expires", $license)||
                !array_key_exists("ActivatedMachines", $license)){
                    return false; # Key, productid, expires or activatedMachines are not set
                }

                if($license["ProductId"] !== $this->cryptolens->get_product_id() || $license["Key"] !== $key){
                    return "Malformed response."; # cryptolens response malformed or incorrect on client side
                }

                $m = false;
                foreach($license["ActivatedMachines"] as $machine){
                    if(!array_key_exists("Mid", $machine)){
                        return "Already activated on this client."; # already activated on this client
                    }
                    if($machine["Mid"] !== $machineid){
                        return "Devide could not be found."; # device not found
                    }
                }
                if($license["Expires"] < time()){
                    return "Key already expired."; # key already expired.
                }

                return [
                    "response" => $c,
                    "license" => $license
                ];
            } else {
                return $c;
            }
        }

        /**
         * deactivate() - Deactivates the given key
         * 
         * @param string $key The key that should be deactivated
         * @param string $machineid The machine ID the key is mapped to, you can leave this empty, but sometimes you recieve an error. Read more in the documentation.
         * @link https://api.cryptolens.io/api/key/deactivate
         */
        public function deactivate($key, $machineid = null){
            $parms = $this->build_params($this->cryptolens->get_token(), $this->cryptolens->get_product_id(), $key, $machineid);
            $c = $this->connection($parms, "deactivate");

            if($c == true){
                # check response values
                if($c["result"] == 0){
                    return true;
                } else {
                    return $c;
                }
            }
        }

        /**
         * create_key() - Creates a key for a specific project
         * 
         * @param array $additional_flags Allows to add more than the required parameters e.g. Period, F1-8, Notes, Block, CustomerId, NewCustomer, AddOrUseExistingCustomer, TrialActivations, MaxNoOfMachines, AllowedMachines, ResellerId, NoOfKeys*
         * @return array|bool Returns an array with the keys "Key", "CustomerId" (only if "NewCustomer" or "AddOrUseExistingCustomer" is set), "Result" and "Message". The key "Key" gets renamed to "Keys" if "NoOfKeys" is greater than 1. On error it returns the Cryptolens response, with the "error" and "response" key
         * @link https://api.cryptolens.io/api/key/createKey
         */
        public function create_key($additional_flags = null){
            $parms = $this->build_params($this->cryptolens->get_token(), $this->cryptolens->get_product_id(), null, null, $additional_flags);
            $c = $this->connection($parms, "createKey");
            if($c == true){
                switch($c){
                    case $c["Result"] != 0:
                        return [
                            "error" => "An error occured.",
                            "response" => $c
                        ];
                    case $c["key"] == null && $c["keys"] == null:
                        return [
                            "error" => "Key is empty.",
                            "reponse" => $c
                        ];
                };
                return $c;
            } else {
                return false;
            }
        }

        public function create_trial_key($machineId = null){
            $parms = $this->build_params($this->cryptolens->get_token(), $this->cryptolens->get_product_id(), null, $machineId);
            $c = $this->connection($parms, "createTrialKey");
            if($c == true){
                switch($c){
                    case $c["Result"] != 0:
                        return [
                            "error" => "An error occured.",
                            "response" => $c
                        ];
                    case $c["Result"] == 0 && $c["Key"] == null:
                        return [
                            "error" => "The key response is empty even though the Result returned 0 (success).",
                            "response" => $c
                        ];
                }
                return $c;
            } else {
                return false;
            }
        }

        /** 
         * build_params() - Internal helper function building the parameters for the cURL request
         */
        private function build_params($token, $product_id, $key = null, $machineid = null, array $additional_flags = null){
            $parms = array(
                "token" => $token,
                "ProductId" => $product_id,
                "Sign" => "True",
                "v" => 1,
                "SignMethod" => 1
            );
            if($key != null){
                $parms["Key"] = $key;
            };
            if($machineid != null){
                $parms["MachineCode"] = $machineid;
            }
            if($additional_flags != null){
                $parms = array_merge($parms, $additional_flags);
            }
            $postfields = ''; $first = true;
            foreach($parms as $i => $x){
                if($first) { $first = false; } else { $postfields .= '&';}

                $postfields .= urlencode($i) . "=" . urlencode($x);

            }
            unset($i, $x);
            return $postfields;
        }

        private function connection($post, $endpoint){
            $c = curl_init();
            curl_setopt_array($c, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => Endpoints::get_endpoint($endpoint),
                CURLOPT_POST => 1,
                CURLOPT_POSTFIELDS => $post
            ));
            print_r($post);
            $res = curl_exec($c);
            if($res == false){
                return curl_error($c);
            }
            curl_close($c);

            $resp = json_decode($res, true);
            if($this->check_response($resp, $endpoint) == true){
                return $resp;
            } else {
                return "Could not validate reponse";
            }
        }

        private function check_response($res, $endpoint){
            if(is_null($res)){
                return "Res == null";
            } else {
                if(in_array($endpoint, Endpoints::$no_response_check)){
                    return true;
                }
                foreach($res as $r){
                    foreach(Results::get_results()["Key"][$endpoint] as $e){
                        if(!strcasecmp($r, $e) == 0){
                            return "Not found variable";
                        }
                    }
                }
                return true;
            }
        }
    }
}

?>