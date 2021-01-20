<?php
    session_start();
    class Session{
        public function login($user_id){
            $_SESSION['user_id'] = $user_id;
        }

        public function set_user_details($data){
            $_SESSION['user_data'] = $data;
        }

        public function isUserLoggedIn(){
            if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])){
                return true;
            }else{
                return false;
            }
        }
    }
?>