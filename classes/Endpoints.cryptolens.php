<?php
namespace Cryptolens_PHP_Client {
    class Endpoints {
        public static array $endpoints = [
            # Keys
            "activate" => "https://api.cryptolens.io/api/key/activate",
            "deactivate" => "https://api.cryptolens.io/api/key/deactivate",
            "createKey" => "https://api.cryptolens.io/api/key/createkey",
            "createTrialKey" => "https://api.cryptolens.io/api/key/createtrialkey",
            "createKeyFromTemplate" => "https://api.cryptolens.io/api/key/createkeyfromtemplate",
            "getKey" => "https://api.cryptolens.io/api/key/getkey",
            "addFeature" => "https://api.cryptolens.io/api/key/addfeature",
            "blockKey" => "https://api.cryptolens.io/api/key/blockkey",
            "extendLicense" => "https://api.cryptolens.io/api/key/extendlicense",
            "removeFeature" => "https://api.cryptolens.io/api/key/removefeature",
            "unblockKey" => "https://api.cryptolens.io/api/key/unblockkey",
            "machineLockLimit" => "https://api.cryptolens.io/api/key/machinelocklimit",
            # Auth
            "keyLock" => "https://api.cryptolens.io/api/auth/keylock",
            # Products
            "getKeys" => "https://api.cryptolens.io/api/product/getkeys",
            "getProducts" => "https://api.cryptolens.io/api/product/getproducts",
            # PaymentForm
            "createSession" => "https://api.cryptolens.io/api/paymentform/CreateSession",
            # Message
            "createMessage" => "https://api.cryptolens.io/api/message/CreateMessage",
            "removeMessage" => "https://api.cryptolens.io/api/message/RemoveMessage",
            "getMessages" => "https://api.cryptolens.io/api/message/GetMessages",
            # Reseller
            "addReseller" => "https://api.cryptolens.io/api/reseller/AddReseller",
            "editReseller" => "https://api.cryptolens.io/api/reseller/EditReseller",
            "removeReseller" => "https://api.cryptolens.io/api/reseller/RemoveReseller",
            "getResellers" => "https://api.cryptolens.io/api/reseller/GetResellers",
            "getResellerCustomers" => "https://api.cryptolens.io/api/reseller/GetResellerCustomers",
        ];

        public static array $no_response_check = [
            "createKey",
            "getKeys",
            "getProducts",
            "getMessages",
            "getResellers",
            "getResellerCustomers",
        ];

        public static function get_endpoint($function_name){
            if(array_search($function_name, array_flip(self::$endpoints))){
                return self::$endpoints[$function_name];
            }
        }
    }
}


?>