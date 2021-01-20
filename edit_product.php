
<?php $title = 'Update product'; ?>
<?php 
    include_once 'includes/includes.php';
    $session = new Session();
    $functions = new Functions();
    if($session->isUserLoggedIn() == false){
        $functions->redirect('index.php');
    }
    $functions->edit_add_permission_access('update');
?>
<style>
    .card{
        width:100% !important;
    }
</style>
</head>
<body>
<?php include 'includes/layout/topBar.php' ?>
<div class="row" style="margin-top:30px">
        <div class="col-md-12 col-lg-2">
        <?php include 'includes/layout/sidebar.php' ?>
    </div>
    <div class="col-md-10 main-content">
        <div class="ui breadcrumb">
            <a class="section">Home</a>
            <div class="divider"> / </div>
            <a class="section"  href="products.php">Products</a>
            <div class="divider"> / </div>
            <div class="active section">Edit Single product</div>
        </div>
        <?php
            $id = '';
            if(isset($_GET['id']) && !empty($_GET['id'])){
                $id = $_GET['id'];
            }else if(isset($_POST['id']) && !empty($_POST['id'])){
                $id = $_POST['id'];
            }

           if(!empty($id)){
                $id = base64_decode($id);
                $id = $functions->real_escape($id);
                $sql = "select * from products where p_ID = '$id'";
                $results = $functions->fetch_rows($functions->query($sql));
                if(sizeof($results) < 1){
                    $functions->redirect('products.php');
                    die();
                }
                $results = $results[0];
           }else{
               $functions->redirect('products.php');
           }

           $functions->update_product();
        ?>
        <div class="html ui top attached segment">
            <div class="ui top attached label">Add product</div>
            <div class="content">
               <form action="?" method="post">
               <div class="form-group">
                    <label>Product Name</label>
                    <div class="ui input">
                        <input type="text" name="product_name" value="<?php echo $results['p_NAME']?>" placeholder="Product Name" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>SKU / CODE</label>
                    <div class="ui input">
                        <input type="text" name="sku" value="<?php echo $results['p_SKU']?>" placeholder="SKU" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Model</label>
                    <div class="ui input">
                        <input type="text" value="<?php echo $results['p_MODEL']?>" name="model" placeholder="model" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Year</label>
                    <div class="ui input">
                        <input type="text" value="<?php echo $results['p_YEAR']?>" name="year" placeholder="year" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Price</label>
                    <div class="ui input">
                        <input type="text" name="price" placeholder="Price" value="<?php echo $results['p_PRICE']?>" required>
                    </div>
                </div>


                <div class="form-group">
                    <label>Low Alert</label>
                    <div class="ui input">
                        <input type="number" name="low" placeholder="Low Alert" value="<?php echo $results['p_LOW_ALERT']?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Category</label>
                    <div class="ui input">
                        <input type="text" name="category" placeholder="Category" value="<?php echo $results['p_CAT']?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Availability</label>
                    <div>
                    <select class="ui dropdown"  name="availability" required >
                        <option value="">--Select---</option>
                        <option value="YES" <?php echo (strtoupper($results['p_AVAILABILITY'])) == 'YES' ?  "selected" : "";?>>Yes</option>
                        <option value="NO" <?php echo (strtoupper($results['p_AVAILABILITY'])) == 'NO' ?  "selected" : "";?>>No</option>
                    </select>
                    </div>
                </div>

                <input type="hidden" name="id" value="<?php echo base64_encode($id)?>"/>


                <button name="submit" type="submit" class="ui  small primary labeled icon button">
                    <i class="add icon"></i> Save Changes
                </button>
               </form>

            </div>
        </div>

    </div>
</div>

<?php include_once 'includes/layout/footer.php'?>