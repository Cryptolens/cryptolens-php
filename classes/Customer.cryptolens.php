<?php
namespace Cryptolens_PHP_Client {
    class Customer {

        private Cryptolens $cryptolens;

        private string $group;


        public function __construct(Cryptolens $cryptolens){
            $this->cryptolens = $cryptolens;
            $this->group = Cryptolens::CRYPTOLENS_CUSTOMER;
        }


        /**
         * `add_customer()` - Add a new customer
         *
         * @param string $name Name of the customer
         * @param string $email Emails of the customer
         * @param string $company_name Company the customer belongs to (max. 100 chars)
         * @param array $additional_flags Additional flags like "EnableCustomerAssociation" (bool), "AllowActivationManagement" (bool), "AllowMultipleUserAssociation" (bool) 
         * @return array|false Returns an array containing the customer ID, a secret to alternatively authenticate the customer, result and message. PortalLink is only returned if "EnableCustomerAssociation" is set to true
         */
        public function add_customer(string $name, string $email, string $company_name, array $additional_flags = null){
           if(!isset($additional_flags)){
                $additional_flags=array();
            };
            $parms = Helper::build_params($this->cryptolens->get_token(), $this->cryptolens->get_product_id(), null, null, array_merge(array("Name" => $name, "Email" => $email, "CompanyName" => $company_name), $additional_flags));
            $c = Helper::connection($parms, "addCustomer", $this->group);
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
         * `edit_customer()` - Allows you to edit an customer by their ID
         *
         * @param integer $customerId The ID of the customer to edit
         * @param array $additional_flags Specify the properties you want to edit. Possible keys: "Name", "Email", "CompanyName", "EnableCustomerAssociation" (bool), "AllowMultipleUserAssociation" (bool), "AllowActivationManagement" (bool), "MaxNoOfDevices" (int), "Secret", if true (bool)
         * @return array|false Returns either "Result" key with value 0 for success or "Error" key on an error
         */
        public function edit_customer(int $customerId, array $additional_flags){
            $parms = Helper::build_params($this->cryptolens->get_token(), $this->cryptolens->get_product_id(), null, null, array_merge(array("CustomerId" => $customerId), $additional_flags));
            $c = Helper::connection($parms, "editCustomer", $this->group);
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
         * `remove_customer()` - Allows you to remove an customer by their ID
         *
         * @param integer $customerId The ID of the customer to remove
         * @return array|false Either "Result" with value 0 or false
         */
        public function remove_customer(int $customerId){
            $parms = Helper::build_params($this->cryptolens->get_token(), $this->cryptolens->get_product_id(), null, null, array("CustomerId" => $customerId));
            $c = Helper::connection($parms, "removeCustomer", $this->group);
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
         * `get_customer_licenses()` - Allows you to retrieve all the customers licenses
         *
         * @param integer $customerId The ID of the customer to retrieve the licenses from
         * @param bool $detailed If set to true, the license will be returned as a License object, default is just returning the serial key (default: false)
         * @param bool $metadata If set to false, additional information such as number of activated devices will not be returned (default: true)
         * @return array|false Either "Result" with value 0 or false
         */
        public function get_customer_licenses(int $customerId, bool $detailed = false, bool $metadata = true){
            $parms = Helper::build_params($this->cryptolens->get_token(), $this->cryptolens->get_product_id(), null, null, array("CustomerId" => $customerId, "Detailed" => $detailed, "Metdata" => $metadata));
            $c = Helper::connection($parms, "getCustomerLicenses", $this->group);
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
         * `get_customers()` - Allows you to retrieve all customers 
         *
         * @param string $search If either "Name", "Company", "Email" or "Secret" contains the search string, the result will be returned.
         * @param int $modelversion Specify if you want a simplified version (1) of the customer objects or more advanced (2). - (default: 1)
         * @param int $limit Specifiy the number of customers to be returned.
         * @return array|false Either the customer objects or false
         */
        public function get_customers(string $search = null, int $modelversion = 1, int $limit = null){
            $additional_flags = array();
            if(isset($search)){
                $additional_flags["Search"] = $search;
            }
            if(isset($limit)){
                $additional_flags["Limit"] = $limit;
            }
            $additional_flags["ModelVersion"] = $modelversion;
            $parms = Helper::build_params($this->cryptolens->get_token(), $this->cryptolens->get_product_id(), null, null, $additional_flags);
            $c = Helper::connection($parms, "getCustomers", $this->group);
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