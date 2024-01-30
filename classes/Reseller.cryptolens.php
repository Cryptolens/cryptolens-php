<?php
namespace Cryptolens_PHP_Client {
    class Reseller {

        private Cryptolens $cryptolens;

        private string $group;


        public function __construct(Cryptolens $cryptolens){
            $this->cryptolens = $cryptolens;
            $this->group = Cryptolens::CRYPTOLENS_RESELLER;
        }

        /**
         * 
         * `add_reseller()` - Adds a reseller
         * 
         * This function seems to be buggy as it always creates a new reseller and returns a value instead of an error if nothing is specified.
         * You should not use this function at the time as the whole Reseller module is being updated
         * 
         * @param string $name Name of the Reseller
         * @param string $email The email of the Reseller
         * @param array|null $additional_flags Allows you to set "Url", "Phone", "Description" or "Metadata" (JSON dictionary)
         * @return array|false Either returns an array containing a "Result" key, if it's 0 the operation succeded.
         * 
         * @link https://app.cryptolens.io/docs/api/v3/AddReseller
         */

        public function add_reseller(string $name, string $email, array $additional_flags = null){
            if($additional_flags == null){$additional_flags = array();};
            $parms = Helper::build_params($this->cryptolens->get_token(), $this->cryptolens->get_product_id(), null, null, array_merge(array("Name" => $name, "Email" => $email), $additional_flags));
            $c = Helper::connection($parms, "addReseller", $this->group);
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

        /**
         * `edit_reseller()` - Edits a reseller on the passed properties.
         * 
         * Only properties specified will be changed within this request
         * The additional_flags array can may only contain the keys "Name", "Url, "Email", "Phone", "Description", "Metadata"
         *
         * @param array $additional_flags Possible keys are "Name", "Url, "Email", "Phone", "Description" or "Metadata"
         * @return array|false On success the function returns an array containing the "Result" key, if it's a 0 the reseller has been edited successfully.
         * @link https://api.cryptolens.io/api/reseller/EditReseller
         */
        public function edit_reseller(int $resellerId, array $additional_flags){
            $parms = Helper::build_params($this->cryptolens->get_token(), $this->cryptolens->get_product_id(), null, null, array_merge(array("ResellerId" => $resellerId), $additional_flags));
            $c = Helper::connection($parms, "editReseller", $this->group);
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

        /**
         * `remove_reseller()` - Removes the given Reseller
         *
         * @param integer $resellerId The ID of the Reseller to be removed
         * @return array|false Returns an array key "Result" value 0 on success, if an error occurs, the message can be obtained from the "Message" key
         * @link https://api.cryptolens.io/api/reseller/RemoveReseller
         */
        public function remove_reseller(int $resellerId){
            $parms = Helper::build_params($this->cryptolens->get_token(), $this->cryptolens->get_product_id(), null, null, array("ResellerId" => $resellerId));
            $c = Helper::connection($parms, "removeReseller", $this->group);
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

        /**
         * `get_resellers()` - Search or return all Resellers
         *
         * @param array $search If either "Name", "Phone", "Email" or "Description" contains the search string, the result will be returned.
         * @param integer|null $limit Specifiy the number of resellers to be returned.
         * @return array|false Contains the Resellers if found or false. 
         * @link https://api.cryptolens.io/api/reseller/GetResellers
         */
        public function get_resellers(string $search = null, int $limit = null){
            $additional_flags = array();
            if(isset($search)){
                $additional_flags["Search"] = $search;
            }
            if(isset($limit)){
                $additional_flags["Limit"] = $limit;
            }

            $parms = Helper::build_params($this->cryptolens->get_token(), $this->cryptolens->get_product_id(), null, null, $additional_flags);
            $c = Helper::connection($parms, "getResellers", $this->group);
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

        /**
         * `get_reseller_by_id()` - Return a Reseller by his ID
         *
         * @param integer $resellerId The ID of the reseller to be returned
         * @return array|false Contains either the Reseller object or false
         * @link https://api.cryptolens.io/api/reseller/GetResellers
         */
        public function get_reseller_by_id(int $resellerId){
            $parms = Helper::build_params($this->cryptolens->get_token(), $this->cryptolens->get_product_id(), null, null, array("ResellerId" => $resellerId));
            $c = Helper::connection($parms, "getResellers", $this->group);
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

        /**
         * `get_reseller_customers` - Returns all customers from a given Reseller
         *
         * @param integer $resellerId The ID of the reseller to return all customers
         * @return array|false Contains either the Customer objects or false
         * @link https://api.cryptolens.io/api/reseller/GetResellerCustomers
         */
        public function get_reseller_customers(int $resellerId){
            $parms = Helper::build_params($this->cryptolens->get_token(), $this->cryptolens->get_product_id(), null, null, array("ResellerId" => $resellerId));
            $c = Helper::connection($parms, "getResellerCustomers", $this->group);
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