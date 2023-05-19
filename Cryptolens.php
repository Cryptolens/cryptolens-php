<?php
namespace Cryptolens_PHP_Client {
    class Cryptolens {
        private string $token;

        private int $version = 2;

        private int $productId;

    
        private function set_token(string $token): void{
            $this->token = $token;
        }
        private function set_product_id($product_id){
            $this->productId = $product_id;
        }

        public function __construct($token, $productid){
            $this->set_token($token);
            $this->set_product_id($productid);
        }

        public function get_token(){
            return $this->token;
        }

        public function get_product_id(){
            return $this->productId;
        }

        public static function loader(){
            require_once "./classes/Key.cryptolens.php";
            require_once "./classes/Endpoints.cryptolens.php";
            require_once "./classes/Results.endpoints.cryptolens.php";
        }

    }
}



?>