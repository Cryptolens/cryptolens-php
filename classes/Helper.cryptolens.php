<?php
namespace Cryptolens_PHP_Client {
    class Helper extends Cryptolens {

        public static function build_params($token, $product_id, $key = null, $machineid = null, array $additional_flags = null){
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
                $parms["MachineCode"] = "";# empty string to prevent error
            }
            if($additional_flags != null){
                if(is_array($additional_flags)){
                    foreach($additional_flags as $key => $value){
                        if(is_array($value)){
                            $value = implode(",", $value);
                        } elseif(is_bool($value)){
                            if($value == true){
                                $value = "true";
                            } else {
                                $value = "false";
                            }
                        } elseif(!is_string($value)){
                            $value = (string) $value;
                        }
                        $parms[$key] = $value;
                    }
                    #print_r(var_dump($parms));
                } else {
                    echo "\$additional_flags is not parsed as an array!";
                }
            }
            $postfields = ''; $first = true;
            foreach($parms as $i => $x){
                if (is_array($x)) {
                    // detect array an skip
                    continue; // Überspringe die Kodierung für diesen Durchlauf
                }
                if($first) { $first = false; } else { $postfields .= '&';}

                $postfields .= urlencode($i) . "=" . urlencode($x);

            }
            unset($i, $x);
            return $postfields;
        }


        public static function connection($post, $endpoint, $group){
            $c = curl_init();
            curl_setopt_array($c, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => Endpoints::get_endpoint($endpoint),
                CURLOPT_POST => 1,
                CURLOPT_POSTFIELDS => $post
            ));
            $res = curl_exec($c);
            if($res == false){
                return curl_error($c);
            }
            curl_close($c);

            $resp = json_decode($res, true);
            if(self::check_response($resp, $endpoint, $group) == true){
                return $resp;
            } else {
                return "Could not validate reponse";
            }
        }

        private static function check_response($res, $endpoint, $group){
            if(is_null($res)){
                return "Cryptolens response returned null. Aborting.";
            } else {
                if(in_array($endpoint, Endpoints::$no_response_check)){
                    return true;
                }
                foreach($res as $r){
                    foreach(Results::get_results()[$group][$endpoint] as $e){
                        if(!strcasecmp($r, $e) == 0){
                            return "Could not validate response correctly, as some expected keys could not be found in the response.";
                        }
                    }
                }
                return true;
            }
        }

        public static function check_rm($data){
            if($data["result"] == 0){
                return true;
            } else {
                return false;
            }
        }
    }
}



?>