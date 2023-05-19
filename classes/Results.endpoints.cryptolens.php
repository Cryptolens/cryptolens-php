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
                ],
                "createKeyFromTemplate" => [
                    "Result",
                    "Key",
                    "RawResponse",
                    "Message"
                ],
                "getKey" => [
                    "LicenseKey",
                    "Signature",
                    "Metadata",
                    "Result",
                    "Message"
                ],
                "addFeature" => [
                    "Result",
                    "Message"
                ],
                "blockKey" => [
                    "Result",
                    "Message"
                ],
                "extendLicense" => [
                    "Result",
                    "Message"
                ],
                "removeFeature" => [
                    "Result",
                    "Message"
                ],
                "unblockKey" => [
                    "Result",
                    "Message"
                ],
                "machineLockLimit" => [
                    "Result",
                    "Message"
                ],
            ],
            "Auth" => [
                "keyLock" => [
                    "keyid",
                    "token",
                    "result",
                    "message"
                ]
                ],
            "Product" => [
                "getKeys" => [
                    "LicenseKeys",
                    "Returned",
                    "Total",
                    "PageCount",
                    "Result",
                    "Message"
                ],
                "getProducts" => [
                    "Products",
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