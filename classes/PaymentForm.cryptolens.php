<?php
namespace Cryptolens_PHP_Client {
    class PaymentForm {

        private Cryptolens $cryptolens;

        private string $group;


        public function __construct(Cryptolens $cryptolens){
            $this->cryptolens = $cryptolens;
            $this->group = Cryptolens::CRYPTOLENS_PRODUCT;
        }

        /**
         * `create_session()` - Allows you to create a new session for a payment form. You can change the appearance of the form (such as price, heading, etc.)
         * 
         * Sessions should only be generated server-side e.g. from your application. A session only works once and may expire if the if it exceeds "Expire" parameter.
         * This API endpoint does return the "Message" key without providing a message on success.
         * 
         * @param int $form_id The ID of the payment form. (Obtained by opening your Payment Form and copying the number at the end of the URL)
         * @param int $expires Number of seconds the session should be valid. (Default: 60)
         * @param float $price The amount to charge the customer (Default: 0)
         * @param string $currency ISO currency code (alphabetical) (Default: USD) - See here for a list: https://en.wikipedia.org/wiki/ISO_4217#Active_codes_(List_One)
         * @param array $additional_flags Set optional parameters such as "Heading", "ProductName", "CustomField" or "Metadata"
         * @return int|array Returns either the UID for the session associated with the customer or an array with "error" and "message" keys
         * @link https://api.cryptolens.io/api/paymentform/CreateSession
         */

        public function create_session($form_id, $expires = 60, $price = 0, $currency = "USD", $additional_flags = null){
            if($additional_flags == null){$additional_flags = array();};
            $parms = Helper::build_params($this->cryptolens->get_token(), $this->cryptolens->get_product_id(), null, null, array_merge(array("PaymentFormId" => $form_id, "Expires" => $expires, "Prices" => $price, "Currency" => $currency), $additional_flags));
            $c = Helper::connection($parms, "createSession", "PaymentForm");
            if($c == true){
                if(Helper::check_rm($c)){
                    return Cryptolens::outputHelper($c);
                } else {
                    return Cryptolens::outputHelper($c, 1);
                }
            } else {
                return false;
            }
        }
    }
}


?>