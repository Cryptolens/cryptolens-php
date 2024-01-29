<?php
namespace Cryptolens_PHP_Client {
    /**
     * Messages - Allows you to broadcast messages.
     * You can create messages via GUI here: https://app.cryptolens.io/Message
     * @link https://help.cryptolens.io/messaging/index
     * @link https://app.cryptolens.io/docs/api/v3/Message
     */
    class Message {

        private Cryptolens $cryptolens;

        private string $group;

        private string $channel;

        /**
         * __construct
         *
         * @param Cryptolens $cryptolens
         * @param string|null $channel Additonal parameter to overwrite 
         */
        public function __construct(Cryptolens $cryptolens, string $channel = null){
            $this->cryptolens = $cryptolens;
            $this->group = Cryptolens::CRYPTOLENS_MESSAGE;
            if($channel == null){
                $this->channel = "";
            } else {
                $this->channel = $channel;
            }
        }

        /**
         * `create_message()` - Allows you to create a new message to broadcast
         * 
         * @param string $content The content of your message (This is optional for the API but what's the point of it, if you don't specify a message.) A link or something similar can be set aswell.
         * @param array|null $additional_flags This allows you to set additional flags, such as the Channel (string, can be overwritten via constructor) or Time (unix timestamp)
         * @return array|false Returns the response array with the message ID or false on error.
         * @link https://api.cryptolens.io/api/message/CreateMessage
         */

        public function create_message(string $content, array $additional_flags = null){
            if($this->channel != ""){
                $additional_flags["Channel"] = $this->channel;
            }
            if($additional_flags == null){$additional_flags = array();};
            $parms = Helper::build_params($this->cryptolens->get_token(), $this->cryptolens->get_product_id(), null, null, array_merge(array("Content" => $content), $additional_flags));
            $c = Helper::connection($parms, "createMessage", "Message");
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
         * `remove_message()` - Removes a message with id.
         *
         * @param integer $message_id The Id from the message to be removed.
         * @return array|false Returns either an array, containing the "Result" key which either is 0 for success or 1 if an error occured. Returning false on connection error. 
         */
        public function remove_message(int $message_id){
            $parms = Helper::build_params($this->cryptolens->get_token(), $this->cryptolens->get_product_id(), null, null, array("Id" => $message_id));
            $c = Helper::connection($parms, "removeMessage", "Message");
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
         * `get_messages()` - Allows you to retrieve messages for a specific channel or time
         *
         *  This function retrieves messages for a specific `$channel` (or all, if left empty) which are older than `$greather_than` timestamp.
         *  If you leave `$channel` and `$greater_than` empty, it will return you all messages
         * 
         * @param string|null $channel The channel you want to retrieve messages for (may be overwritten if you set the channel variable in the constructor).
         * @param integer|null $greater_than Retrieve messages created after `$greather_than` (unix timestamp, strictly 'greather than'). Might be useful to retrieve messages from last time you used this function.
         * @return array|false Returns an array with all messages or false on error
         */
        public function get_messages(string $channel = null, int $greater_than = null){
            if(isset($channel)){
                $additional_flags["Channel"] = $channel;
            }
            if(isset($greater_than)){
                $additional_flags["Time"] = $greater_than;
            }
            $parms = Helper::build_params($this->cryptolens->get_token(), $this->cryptolens->get_product_id(), null, null, $additional_flags);
            $c = Helper::connection($parms, "getMessages", "Message");
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