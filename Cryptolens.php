<?php
namespace Cryptolens_PHP_Client {
    class Cryptolens {


        public const CRYPTOLENS_OUTPUT_PHP = 1;

        public const CRYPTOLENS_OUTPUT_JSON = 2;
        private string $token;

        private int $version = 2;

        private int $productId;

        public static int $output;

    
        private function set_token(string $token): void{
            $this->token = $token;
        }
        private function set_product_id($product_id){
            $this->productId = $product_id;
        }

        /**
         * If $output equals CRYPTOLENS_OUTPUT_PHP you recieve arrays, if it's on CRYPTOLENS_OUTPUT_JSON you recieve json
         */
        public function __construct($token, $productid, $output = self::CRYPTOLENS_OUTPUT_PHP){
            self::$output = $output;
            $this->set_token($token);
            $this->set_product_id($productid);
        }


        public function get_token(){
            return $this->token;
        }

      public function get_product_id(){
            return $this->productId;
        }

        public function set_output($output){
            $this->output = $output;
        }

        public static function loader(){
            require_once "./classes/Key.cryptolens.php";
            require_once "./classes/Endpoints.cryptolens.php";
            require_once "./classes/Results.endpoints.cryptolens.php";
        }

        public static function outputHelper($data){
            if(self::$output == self::CRYPTOLENS_OUTPUT_PHP){
                return (array) $data;
            } elseif(self::$output == self::CRYPTOLENS_OUTPUT_JSON){
                return json_encode($data);
            }
        }

    }
}



?>
