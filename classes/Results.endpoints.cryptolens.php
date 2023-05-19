<?php
namespace Cryptolens_PHP_Client {
    class Results extends Endpoints {
        public static array $results = [
            "Key" => [
                "activate" => [
                    "LicenseKey",
                    "Signature",
                    "Result",
                    "Message"
                ],
                "deactivate" => [
                    "Result",
                    "Message"
                ],
                "createKey" => [
                    "Key",
                    "CustomerId",
                    "Result",
                    "Message"
                ],
                "createTrialKey" => [
                    "Key",
                    "Result",
                    "Message"
                ]
            ]
        ];

        public static function get_results(){
            return self::$results;
        }
    }
}



?>