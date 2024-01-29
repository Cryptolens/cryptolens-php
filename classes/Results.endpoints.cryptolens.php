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
                    "Keyid",
                    "Token",
                    "Result",
                    "Message"
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
            ],
            "PaymentForm" => [
                "createSession" => [
                    "SessionId",
                    "Result",
                    "Message"
                ]
            ],
            "Message" => [
                "createMessage" => [
                    "MessageId",
                    "Result",
                    "Message"
                ],
                "removeMessage" => [
                    "Result",
                    "Message"
                ],
                "getMessages" => [
                    "Messages",
                    "Result",
                    "Message"
                ]
            ],
            "Reseller" => [
                "addReseller" => [
                    "ResellerId",
                    "Result",
                    "Message"
                ],
                "editReseller" => [
                    "Result",
                    "Message"
                ],
                "removeReseller" => [
                    "Result",
                    "Message"
                ],
                "getResellers" => [
                    "Resellers",
                    "Result",
                    "Message"
                ],
                "getResellerCustomers" => [
                    "Customers",
                    "Result",
                    "Message"
                ]
            ],
            "Subscription" => [
                "recordUsage" => [
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