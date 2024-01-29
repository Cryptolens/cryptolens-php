<?php
namespace Cryptolens_PHP_Client {
    class Subscription {

        private Cryptolens $cryptolens;

        private string $group;


        public function __construct(Cryptolens $cryptolens){
            $this->cryptolens = $cryptolens;
            $this->group = Cryptolens::CRYPTOLENS_SUBSCRIPTION;
        }


        /**
         * `record_usage()` - Allows you to record usage for Stripe's metered billing.
         * 
         * This API request is parsed to Stripe with the action "increment" - https://app.cryptolens.io/docs/api/v3/RecordUsage
         *
         * @param string $key The Key to record usage on
         * @param integer $amout The amount to increment the usage counter (this is actually optional)
         * @return array|false On success the "Result" key has the value 0 otherwise the "Error" key is set
         * 
         * @link https://api.cryptolens.io/api/subscription/RecordUsage
         */
        public function record_usage(string $key, int $amount = 0){
            $parms = Helper::build_params($this->cryptolens->get_token(), $this->cryptolens->get_product_id(), null, null, array("Key" => $key, "Amount" => $amount));
            $c = Helper::connection($parms, "recordUsage", $this->group);
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