
<?php $title = 'Add Single product'; ?>
<?php 
    include_once 'includes/includes.php';
    $session = new Session();
    $functions = new Functions();
    if($session->isUserLoggedIn() == false){
        $functions->redirect('index.php');
    }
    $functions->edit_add_permission_access('create');
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
            <a class="section"  href="orders.php">Orders</a>
            <div class="divider"> / </div>
            <div class="active section">Add Single product</div>
        </div>
        <?php
            $functions->add_product();
        ?>
        <div class="html ui top attached segment">
            <div class="ui top attached label">Add product</div>
            <div class="content">
               <form action="?" method="post">
               <div class="form-group">
                    <label>Product Name</label>
                    <div class="ui input">
                        <input type="text" name="product_name" placeholder="Product Name" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>SKU / CODE</label>
                    <div class="ui input">
                        <input type="text" name="sku" placeholder="SKU" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Model</label>
                    <div class="ui input">
                        <input type="text" name="model" placeholder="model" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Year</label>
                    <div class="ui input">
                        <input type="text" name="year" placeholder="year" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Price</label>
                    <div class="ui input">
                        <input type="text" name="price" placeholder="Price" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Qty</label>
                    <div class="ui input">
                        <input type="number" name="qty" placeholder="Qty" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Low Alert</label>
                    <div class="ui input">
                        <input type="number" name="low" placeholder="Low Alert" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Category</label>
                    <div class="ui input">
                        <input type="text" name="category" placeholder="Category" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Availability</label>
                    <div>
                    <select class="ui dropdown"  name="availability" required>
                        <option value="">--Select---</option>
                        <option value="YES">Yes</option>
                        <option value="NO">No</option>
                    </select>
                    </div>
                </div>


                <button name="submit" type="submit" class="ui  small primary labeled icon button">
                    <i class="add icon"></i> Save
                </button>
               </form>

            </div>
        </div>

    </div>
</div>

<?php include_once 'includes/layout/footer.php'?>