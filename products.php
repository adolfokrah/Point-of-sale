
<?php $title = 'Manage products'; ?>
<?php 
    include_once 'includes/includes.php';
    $session = new Session();
    $functions = new Functions();
    if($session->isUserLoggedIn() == false){
        $functions->redirect('index.php');
    }
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
            <a class="section">Products</a>
            <div class="divider"> / </div>
            <div class="active section">Manage products</div>
        </div>
        <div></div>
        <?php
              $path = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
               $permissions = $functions->get_user_permission($path);

               if(in_array('create',$permissions)):
        ?>

        <a href="add_product.php">
            <div class="ui  small primary labeled icon button">
            <i class="add icon"></i> Add Single Product
            </div>
        </a>

        
        
        <form action="?" method="post" style="margin-top:20px" enctype="multipart/form-data">
            <input type="file" id="file" name="file"/>
            <button name="submit_file"  class="ui small labeled icon button" style="margin-left:10px">
                <i class="file icon"></i> Add Bulk Products
            </button>
        </form>

        <?php endif?>
        <?php
            if(isset($_SESSION['success']) && !empty($_SESSION['success'])){
                echo $functions->message($_SESSION['success'],'green');
                unset($_SESSION['success']);
            }
            if(isset($_SESSION['error']) && !empty($_SESSION['error'])){
                echo $functions->message($_SESSION['error'],'red');
                unset($_SESSION['error']);
            }

            $functions->delete_product();
            $functions->upload_bulk_products();
        ?>


        <div class="ui card">
        <div class="content">
            <div class="header">Products</div>
        </div>
        <div class="content">
            <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>SKU</th>
                <th>Product Name / Disc</th>
                <th>Model</th>
                <th>Year</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Total Amt (Price * Qty)</th>
                <th>Category</th>
                <th>Availability</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
         <?php
            $sql = "select * from products where products.p_STATUS != 'deleted' order by p_ID desc";
            $results = $functions->fetch_rows($functions->query($sql));
            $total_qty  = 0;
            $total_price = 0;
            foreach ($results as $result) {

                $sql = "select *,sum(cart.cart_p_QTY) as cart_p_QTY from products left join cart on products.p_ID = cart.cart_p_ID where products.p_STATUS != 'deleted' and cart.status = 'active' and products.p_ID = '".$result['p_ID']."'";
                $fetch = $functions->fetch_rows($functions->query($sql));

                $cart_total = $fetch[0]['cart_p_QTY'];
                $result['p_QTY'] = $result['p_QTY'] - $cart_total;

                
                $aval = '<a class="ui green  label">
                 Available
                </a>';

                $low_alert = '';

                if(strtoupper($result['p_AVAILABILITY']) == 'NO'){
                    $aval = '<a class="ui red  label">
                    NotAvailable
                   </a>';
                }else{
                    $total_qty = $total_qty + $result['p_QTY'];
                    $total_price = ($result['p_QTY'] * $result['p_PRICE']) + $total_price;
                }

                if($result['p_QTY'] <= $result['p_LOW_ALERT']){
                    $low_alert = '<a class="ui orange  label">
                     Low !
                   </a>';
                }

                $actions = '';
                if(in_array('update',$permissions)){
                    $actions .= '<a  href="edit_product.php?id='.base64_encode($result['p_ID']).'"><button data-tooltip="Edit product" data-position="top right" class="ui icon button"><i class="edit icon"></i></button></a>';
                }

                if(in_array('delete',$permissions)){
                    $actions .= ' <button data-tooltip="Delete product" data-position="top right" class="ui icon button" onclick="show_modal(\''.$result['p_ID'].'\')"><i class="trash icon"></i></button>';
                }

                echo '<tr>
                <td>'.$result['p_SKU'].'</td>
                <td>'.$result['p_NAME'].'</td>
                <td>'.$result['p_MODEL'].'</td>
                <td>'.$result['p_YEAR'].'</td>
                <td>¢ '.sprintf('%0.2f',$result['p_PRICE']).'</td>
                <td>'.$result['p_QTY'].' '.$low_alert.'</td>
                <td>¢ '.sprintf('%0.2f',($result['p_QTY'] * $result['p_PRICE'])).'</td>
                <td>'.$result['p_CAT'].'</td>
                <td>'.$aval.'</td>
                <td>
                '.$actions.'
                 <a href="view_product_statment.php?id='.base64_encode($result['p_ID']).'"><button data-tooltip="view product statement" data-position="top right" class="ui icon button"><i class="file icon"></i></button></a>
                </td>
            </tr>';
            }
         ?>
            
        </tbody>
    </table>
        </div>
        </div>

        <div class="row">
            <div class="col-sm-12 col-md-7"></div>
            <div class="col-sm-12 col-md-5">
            <table class="ui celled structured table">

                <thead>
                    <tr>
                        <th colspan="2">Summary Report</th>
                    </tr>
                </thead>

                 <thead>
                    <tr>
                        <th>Total Products</th>
                        <th>Total Amount</th>
                    </tr>
                </thead>
               
                <tbody>
                    <th><?php echo $total_qty ?></th>
                    <th><?php echo '¢'.sprintf('%0.2f',$total_price);?></th>
                   
                </tr></tbody>
                </table>
        </div>

    </div>
</div>



<?php include_once 'includes/layout/footer.php'?>