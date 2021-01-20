<?php 

    class Functions {

        function login(){
            //get username and password
            if(isset($_POST['username']) && isset($_POST['password'])){
                $username = $this->real_escape($_POST['username']);
                $password = $this->real_escape($_POST['password']);
                $password = md5($password);

                //login user
                $sql = "select * from users where user_name = '$username' and password = '$password'";
                $results = $this->fetch_rows($this->query($sql));
               
                if(sizeof($results) > 0){
                    $session = new Session();
                    $session->login($results[0]['user_id']);
                    $session->set_user_details($results[0]);
                    $this->redirect('home.php');
                }else{
                    echo $this->message('Incorrect username or password','red');
                }
            }
        }

        public function logout(){
            session_unset();
            session_destroy();
            $this->redirect('index.php');
        }

        function real_escape($str){
            global $conn;
            $escape = mysqli_real_escape_string($conn,$str);
            return $escape;
        }

        function query($sql){
            global $conn;
            return $query = mysqli_query($conn,$sql);
        } 

        function fetch_rows($query){
           $rows = array();
           while($fetch = mysqli_fetch_assoc($query)){
               array_push($rows,$fetch);
           }
           return $rows;
        }

        function fetch_num_rows($query){
            return $num = mysqli_num_rows($query);
        }

        public function redirect($url, $permanent = false){
            echo '<script>window.open(\''.$url.'\',\'_self\')</script>';
        }

        public function message($msg, $color){
            return "<div class=\"ui $color message\">$msg</div>";
        }
        public function get_insert_id(){
            global $conn;
            return mysqli_insert_id($conn);
        }
        public function add_product(){
            if(isset($_SESSION['error']) && !empty($_SESSION['error'])){
                echo $this->message($_SESSION['error'],'red');
                unset($_SESSION['error']);
            }

            if(isset($_POST['submit'])){
                $fields = $this->validate_fields('add_products.php');
                //fetch check if product already exist
                $sql = "select * from products where p_NAME = '".$fields['product_name']."' and p_CAT = '".$fields['category']."' and p_SKU = '".$fields['sku']."'";
                if($this->fetch_num_rows($this->query($sql)) > 0){
                    $_SESSION['error'] = '<strong>'.$fields['product_name'].'</strong> already added';
                    $this->redirect('add_product.php');
                }else{

                    $sql = "insert into `products` (`p_ID`, `p_SKU`, `p_QTY`, `p_LOW_ALERT`, `p_CAT`, `p_NAME`, `p_PRICE`, `p_AVAILABILITY`,`p_MODEL`,`p_YEAR`, `p_STATUS`) VALUES (NULL, '".$fields['sku']."', '".$fields['qty']."', '".$fields['low']."', '".$fields['category']."', '".$fields['product_name']."', '".$fields['price']."', '".$fields['availability']."','".$fields['model']."','".$fields['year']."', 'active');";
                    $this->query($sql);
                    
                    if($this->get_insert_id() > 0){
                        $_SESSION['success'] = '<strong>'.$fields['product_name'].'</strong> added successfully';
                        $action = 'Product inserted';
                        $this->insert_product_history($action,$this->get_insert_id());
                        $this->redirect('products.php');
                    }
                }
            }
        }

        public function update_product(){
            if(isset($_SESSION['error']) && !empty($_SESSION['error'])){
                echo $this->message($_SESSION['error'],'red');
                unset($_SESSION['error']);
            }
            if(isset($_POST['submit'])){
                $fields = $this->validate_fields('edit_product.php?id='.$_POST['id']);
                
                //fetch check if product already exist
                $sql = "select * from products where p_NAME = '".$fields['product_name']."' and p_CAT = '".$fields['category']."' and p_SKU = '".$fields['sku']."' and p_ID != '".base64_decode($_POST['id'])."'";
                if($this->fetch_num_rows($this->query($sql)) > 0){
                    
                    $_SESSION['error'] = '<strong>'.$fields['product_name'].'</strong> already added';
                    $this->redirect('edit_product.php?id='.$_POST['id']);

                }else{

                    $sql = "update `products` SET `p_SKU` = '".$fields['sku']."', `p_LOW_ALERT` = '".$fields['low']."', `p_CAT` = '".$fields['category']."', `p_NAME` = '".$fields['product_name']."',`p_MODEL`='".$fields['model']."',`p_YEAR`='".$fields['year']."', `p_AVAILABILITY` = '".$fields['availability']."',`p_PRICE`='".$fields['price']."' WHERE `products`.`p_ID` = '".base64_decode($_POST['id'])."';
                    ";
                    $this->query($sql);
                    $action = 'Product details updated';
                    $this->insert_product_history($action,base64_decode($fields['id']));
                    $_SESSION['success'] = '<strong>'.$fields['product_name'].'</strong> updated successfully';
                    $this->redirect('products.php');
                }

            }
        }

        public function delete_product(){
            if(isset($_GET['id']) && isset($_GET['action'])){
                if(!empty($_GET['id'])){
                    $id = $_GET['id'];
                    $sql = "delete from products where p_ID = '$id'";
                    $this->query($sql);
                    $_SESSION['success'] = '<strong>Product </strong>  successfully';
                    $this->redirect('products.php');
                }
            }
        }

        public function delete_group(){
            if(isset($_GET['id']) && isset($_GET['action'])){
                if(!empty($_GET['id'])){
                    $id = $_GET['id'];
                    $sql = "select * from groups where gr_id = '$id'";
                    $p_group_name = $this->fetch_rows($this->query($sql))[0]['group_name'];
                    $sql =  "select * from users where user_type = '$p_group_name'";
                    if($this->fetch_num_rows($this->query($sql)) > 0){
                        $_SESSION['error'] = '<strong>Failed, </strong> Some users poses this group permissions';
                        $this->redirect('groups.php');
                    }else{

                        $sql = "delete from groups where gr_id = '$id'";
                        $this->query($sql);
                        $_SESSION['success'] = '<strong>Group deleted</strong>  successfully';
                        $this->redirect('groups.php');
                    }
                }
            }
        }

        public function insert_product_history($action,$id){
            $date = date('Y-m-d H:i');
            $user_id = $_SESSION['user_id'];
            $sql = "insert INTO `product_statement` (`ps_ID`, `p_ID`, `ps_action`, `user_id`, `date_time`) VALUES (NULL, '$id', '$action', '$user_id', '$date');";
            $this->query($sql);
        }

        public function validate_fields($page){
            unset($_POST['submit']);
            $array_errors = array();
            $keys = array_keys($_POST);
            $fields = array();
            for ($i=0; $i < sizeof($keys) ; $i++) { 
               
                if(empty($_POST[$keys[$i]]) && $keys[$i] != 'password' && $keys[$i] != 'cpassword' && $keys[$i] != 'old_password'){
                    array_push($array_errors,'<strong>'.$keys[$i].'</strong>'.' cannot be empty');
                }


                if(($keys[$i] == 'price' || $keys[$i] == 'qty' || $keys[$i] == 'low')  && !(is_numeric($_POST[$keys[$i]]))){
                    array_push($array_errors,'<strong>'.$keys[$i].'</strong>'.' should be a valid number');
                    continue;
                }

                if(($keys[$i] == 'cateogry')  && is_numeric($_POST[$keys[$i]] )){
                    array_push($array_errors,'<strong>'.$keys[$i].'</strong>'.' cannot be only numbers');
                    continue;
                }
                
                $fields[$keys[$i]] = $this->real_escape($_POST[$keys[$i]]);
            }
            if(sizeof($array_errors) > 0){
                $error_message = implode($array_errors,'<br/>');
                $_SESSION['error'] = $error_message;
                $this->redirect($page);
            }else{
                return $fields;
            }
        }

        public function upload_bulk_products(){
            if(isset($_POST["submit_file"])){
                if(empty($_FILES['file']['name'])){
                    $_SESSION['error'] = "Please choose a file to upload";
                    $this->redirect('products.php');
                    return;
                }
               $file = $_FILES["file"]["tmp_name"];
               $file_name = $_FILES['file']['name'];
               $ext = explode('.',$file_name);
               $ext = $ext[sizeof($ext)-1];
               $exts = array('CSV','csv');
               if(!in_array($ext,$exts)){
                $_SESSION['error'] = "Please upload a csv file type eg. <strong>filename.csv</strong>";
                $this->redirect('products.php');
                return;
               }
                $error_arrays = array();
                $file_open = fopen($file,"r");
                $counter = 1;
                $fields = array('SKU','QTY','LOW ALERT','CATEGORY','PRODUCT NAME','PRICE','AVAILABILITY');
                $insert = false;
                while(($csv = fgetcsv($file_open, 1000, ",")) !== false){
                    if($counter > 1){

                        $error = false;
                        $p_sku = $this->real_escape($csv[0]);
                        $p_qty = $this->real_escape($csv[1]);
                        $p_low = $this->real_escape($csv[2]);
                        $p_cat = $this->real_escape($csv[3]);
                        $p_name = $this->real_escape($csv[4]);
                        $p_price = $this->real_escape($csv[5]);
                        $p_availability = $this->real_escape($csv[6]);
                        $p_model = $this->real_escape($csv[7]);
                        $p_year = $this->real_escape($csv[8]);
                        $columns = array();

                        for ($i=0; $i <sizeof($csv); $i++) { 
                            if(empty($csv[$i])){
                              array_push($columns,'<strong>'.$fields[$i].'</strong> is empty');
                            }
                        }

                        if(sizeof($columns) > 0){
                            $error_message = implode($columns,', ');
                            $error_message = 'Error on row '.$counter.': '.$error_message;
                            array_push($error_arrays,$error_message);
                        }else{

                            $sql = "select * from products where p_NAME = '".$p_name."' and p_CAT = '".$p_cat."' and p_SKU = '".$p_sku."'";
                            if($this->fetch_num_rows($this->query($sql)) > 0){
                                $error_message = 'Error on row '.$counter.': <strong>'.$p_name.'</strong> already exist';
                                array_push($error_arrays,$error_message);
                            }else{
                                $insert = true;
                                $sql = "insert into `products` (`p_ID`, `p_SKU`, `p_QTY`, `p_LOW_ALERT`, `p_CAT`, `p_NAME`, `p_PRICE`, `p_AVAILABILITY`,`p_MODEL`,`p_YEAR`, `p_STATUS`) VALUES (NULL, '".$p_sku."', '".$p_qty."', '".$p_low."', '".$p_cat."', '".$p_name."', '".$p_price."', '".$p_availability."', '".$p_model."', '".$p_year."','active');";
                                $this->query($sql);
                                $action = 'Product inserted';
                                $this->insert_product_history($action,$this->get_insert_id());
                            }
                        }

                        //mysql_query("INSERT INTO employee VALUES ('$name','$age','country')");
                    }
                    $counter++;
                }
                

                if($insert){
                    $_SESSION['success'] = 'Products imported';
                }
                if(sizeof($error_arrays) > 0){
                    $error_message = implode($error_arrays,'<br/>');
                    $_SESSION['error'] = $error_message;
                    $this->redirect('products.php');
                }
            }
        }

        public function update_company_details(){
            if(isset($_POST['submit'])){
                $fields = $this->validate_fields('company.php');
                
                //fetch check if product already exist
                $sql = "update `company_details` SET `company_name` = '".$fields['company_name']."', `vat_charges` = '".$fields['vat']."', `address` = '".$fields['address']."', `phone` = '".$fields['phone']."', `message` = '".$fields['message']."'";
                                ;
                $this->query($sql);
                $_SESSION['success'] = '<strong>Company Details details</strong> updated successfully';
                $this->redirect('company.php');

            }
        }

        public function update_user_details($page){
            if(isset($_POST['submit'])){
                $fields = $this->validate_fields($page);
                
                // if($_SESSION['user_data']['user_type'] == 'admin'){
                //     $fields['user_type'] = 'admin';
                // }
                if($fields['password'] != ''){

                    $old_password = md5($fields['old_password']);
                    $old_old_password  = $_SESSION['user_data']['password'];
                    if($page == 'users.php'){
                        $old_password = $fields['old_password'];
                        $old_old_password = $fields['old_password'];
                    }
                
                    if($old_password != $old_old_password){
                        $_SESSION['error'] = 'Your old password is inccorrect';
                        $this->redirect($page);
                    }else if($_POST['password'] != $_POST['cpassword']){
                        $_SESSION['error'] = 'Your passwords do ot match';
                        if($page == 'users.php'){
                            $page = 'edit_user.php?id='.base64_encode($fields['user_id']);
                        }
                        $this->redirect($page);
                    }else{
                        $sql = "update `users` SET  `password` = '".md5($fields['password'])."', `user_type` = '".($fields['user_type'])."', `first_name` = '".($fields['first_name'])."', `last_name` = '".($fields['last_name'])."', `phone` = '".($fields['phone'])."', `gender` = '".($fields['gender'])."' WHERE `users`.`user_id` = '".($fields['user_id'])."'";
                        $this->query($sql);
                         $_SESSION['success'] = '<strong>User Details</strong> updated successfully';
                    }

                }else{
                    $sql = "update `users` SET  `user_type` = '".($fields['user_type'])."', `first_name` = '".($fields['first_name'])."', `last_name` = '".($fields['last_name'])."', `phone` = '".($fields['phone'])."', `gender` = '".($fields['gender'])."' WHERE `users`.`user_id` = '".($fields['user_id'])."'";
                    $this->query($sql);
                    $_SESSION['success'] = '<strong>User Details</strong> updated successfully';
                   
                }
                $this->redirect($page);
            }
        }
        public function add_user(){
            if(isset($_POST['submit'])){
                $fields = $this->validate_fields('add_users.php');

                if($fields['password'] != ''){
                   
                    if($_POST['password'] != $_POST['cpassword']){
                        $_SESSION['error'] = 'Passwords do ot match';
                        $this->redirect('add_users.php');
                    }else{

                        $sql = "select * from users where user_name like '".$fields['user_name']."'";
                        if($this->fetch_num_rows($this->query($sql)) > 0){
                             $_SESSION['error'] = '<strong>User Name already</strong> exist';
                            $this->redirect('add_users.php');
                        }else{
                            $sql = "insert INTO `users` (`user_id`, `user_name`, `password`, `user_type`, `first_name`, `last_name`, `phone`, `gender`) VALUES (NULL, '".($fields['user_name'])."', '".md5($fields['password'])."', '".($fields['user_type'])."', '".($fields['first_name'])."', '".($fields['last_name'])."', '".($fields['phone'])."', '".($fields['gender'])."');";
                            $this->query($sql);
                             $_SESSION['success'] = '<strong>User Details</strong> added successfully';
                            $this->redirect('users.php');
                        }
                    }

                }
            }
        }
        public function delete_user(){
            if(isset($_GET['id']) && isset($_GET['action'])){
                $id = $_GET['id'];
                $sql = "select * from users where user_id = '$id'";

                $results = $this->fetch_rows($this->query($sql))[0];
                if(!empty($_GET['id']) && $results['user_type'] != 'admin'){
                    $sql = "delete from users where user_id = '$id'";
                    $this->query($sql);
                    $_SESSION['success'] = '<strong>User </strong>  deleted successfully';
                    $this->redirect('users.php');
                }
            }
        }

        public function get_user_permission($path){
            if(isset($_SESSION['user_id']) && isset($_SESSION['user_data']) && !empty($_SESSION['user_id']) && !empty($_SESSION['user_data'])){
                $user_type = $_SESSION['user_data']['user_type'];
                $sql = "select * from groups where group_name = '$user_type'";

                $results = $this->fetch_rows($this->query($sql));
                $permission = json_decode($results[0]['permissions']);
               
                if($path == 'home.php'){
                    $path = 'Dashboard.php';
                }

                if(strpos($path,'user') > -1){
                    $path = 'Users.php';
                }

                if(strpos($path,'group') > -1){
                    $path = 'Groups.php';
                }

                if(strpos($path,'product') > -1 ){
                    $path = 'products.php';
                }

                
                if(strpos($path,'stock') > -1 ){
                    $path = 'stock.php';
                }
                
               
                if(strpos($path,'order') > -1){
                    $path = 'orders.php';
                }

                if(strpos($path,'company') > -1 || strpos($path,'database') > -1){
                    $path = 'company.php';
                }


                $page_permissions = array();

                if($path == 'settings.php' || $path == 'logout.php'){
                    array_push($page_permissions,'view');
                }
                for ($i=0; $i <sizeof($permission) ; $i++) { 
                    if(strtoupper($permission[$i]->module_name) == strtoupper(str_replace('.php','',$path))){
                        $page_permissions = $permission[$i]->permissions;
                        
                        break;
                    }
                }
               
               return $page_permissions;

            }
        }

        public function view_page_permission_access(){
                if(isset($_SESSION['user_id']) && isset($_SESSION['user_data']) && !empty($_SESSION['user_id']) && !empty($_SESSION['user_data'])){
                $path = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
                $permissions = $this->get_user_permission($path);
                $view = false;
                foreach ($permissions as $permission) {
                    if($permission == 'view'){
                        $view = true;
                    }
                }

                    if($path == 'home.php'){
                        $view = true;
                    }

                if($view == false){
                echo "<center><h2>401 You don't have the permission to view this page</h2></center>";
                die();
                }
            }
        }

        public function edit_add_permission_access($permission){
            $path = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
            $permissions = $this->get_user_permission($path);

            if(!in_array($permission,$permissions)){
                echo "<center><h2>401 You don't have the permission to view this page</h2></center>";
                die();
            }
        }
    }


?>