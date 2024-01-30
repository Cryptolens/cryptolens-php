<?php
namespace Cryptolens_PHP_Client {
    class Product {

        private Cryptolens $cryptolens;

        private string $group;

        private array $OrderByDefinitions = [
            "cd" => "Created descending",
            "ca" => "Created ascending",
            "ia" => "ID ascending",
            "id" => "ID descending",
            "ka" => "Key ascending",
            "kd" => "Key descending",
            "da" => "Decives ascending",
            "dd" => "Devices descending",
            "ea" => "Expires ascending",
            "ed" => "Expire descending",
            "pa" => "Period ascending",
            "pd" => "Period descending",
            "f1a" => "F1 ascending",
            "f1d" => "F1 descending",
            "f2a" => "F2 ascending",
            "f2d" => "F2 descending", 
            "f3a" => "F3 ascending",
            "f3d" => "F3 descending", 
            "f4a" => "F4 ascending",
            "f4d" => "F4 descending", 
            "f5a" => "F5 ascending",
            "f5d" => "F5 descending", 
            "f6a" => "F6 ascending",
            "f6d" => "F6 descending", 
            "f7a" => "F7 ascending",
            "f7d" => "F7 descending", 
            "f8a" => "F8 ascending",
            "f8d" => "F8 descending", 
            "f9a" => "F9 ascending",
            "f9d" => "F9 descending",
        ];

        public function __construct(Cryptolens $cryptolens){
            $this->cryptolens = $cryptolens;
            $this->group = Cryptolens::CRYPTOLENS_PRODUCT;
        }

        /**
         * get_keys() Allows you to retrieve all keys
         * 
         * @param int $page A page only returns 99 keys. If you want to see the remaining ones, increment by 1
         * @param $additional_flags You can set the additional `OrderBy` and `SearchQuery` flags.
         * 
         * `OrderBy`: For shorter usage, we defined filters for you
         * * Take a look at the $OrderByDefinitions variable to see, which filter are available
         * 
         * `SearchQuery`: For more information, see <https://help.cryptolens.io/web-interface/linq-search-product>
         */
        public function get_keys($page = 1, $additional_flags = null){
            if(isset($additional_flags)){
                if(in_array("orderBy", array_flip($additional_flags))){
                    foreach($this->OrderByDefinitions as $d => $f){
                        switch($d){
                            case $d == $additional_flags["orderBy"]:
                                $additional_flags["orderBy"] = $f;
                        }
                    }
                    $additional_flags = array_merge(["page" => $page], $additional_flags);
                };
            }
            $parms = Helper::build_params($this->cryptolens->get_token(), $this->cryptolens->get_product_id(), null, null, $additional_flags);
            $c = Helper::connection($parms, "getKeys", $this->group);

            if($c == true){
                if(Helper::check_rm($c)){
                    return Cryptolens::outputHelper($c);
                } else {
                    return Cryptolens::outputHelper($c, 1);
                }
            }
        }

        public function get_products(){
            $parms = Helper::build_params($this->cryptolens->get_token(), $this->cryptolens->get_product_id());
            $c = Helper::connection($parms, "getProducts", $this->group);
            if($c == true){
                if(Helper::check_rm($c)){
                    return Cryptolens::outputHelper($c);
                } else {
                    return Cryptolens::outputHelper($c, 1);
                }
            }
        }
    }
}


?>