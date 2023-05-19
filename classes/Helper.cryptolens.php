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
                return "Res == null";
            } else {
                if(in_array($endpoint, Endpoints::$no_response_check)){
                    return true;
                }
                foreach($res as $r){
                    foreach(Results::get_results()[$group][$endpoint] as $e){
                        if(!strcasecmp($r, $e) == 0){
                            return "Not found variable";
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