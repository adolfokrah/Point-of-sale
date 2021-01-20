
<?php $title = 'Edit Order'; ?>
<?php 
    include_once 'includes/includes.php';
    $session = new Session();
    $functions = new Functions();
    if($session->isUserLoggedIn() == false){
        $functions->redirect('index.php');
    }
    $functions->edit_add_permission_access('update');
?>
    <link rel="stylesheet" href="lib/vue.js"/>
<style>
    .card{
        width:100% !important;
        border-radius:0px !important;
        /* box-shadow:none !important; */
    }
</style>
</head>
<body>
<?php include 'includes/layout/topBar.php' ?>
<div class="row" style="margin-top:30px">
    <div class="col-md-12 col-lg-2">
        <?php 
        
            include 'includes/layout/sidebar.php';
            
            $id = '';
            if(isset($_GET['order']) && !empty($_GET['order'])){
                $id = $_GET['order'];
            }else if(isset($_POST['order']) && !empty($_POST['order'])){
                $id = $_POST['order'];
            }

            $sql = "select * from orders where order_id = '$id'";
            if($functions->fetch_num_rows($functions->query($sql)) < 1){
                echo "<script>window.open('orders.php','_self')</script>";
                die();
            }
            echo '<input type="hidden" value="'.$id.'" id="order_id"/>';

        ?>
    </div>
    <div class="col-md-12 col-lg-10 main-content"  id="app">
        <div class="ui breadcrumb">
            <a class="section">Home</a>
            <div class="divider"> / </div>
            <a class="section" href="orders.php">Orders</a>
            <div class="divider"> / </div>
            <div class="active section">Add order</div>
        </div>
        <div></div>
        
        <?php
            if(isset($_SESSION['success']) && !empty($_SESSION['success'])){
                echo $functions->message($_SESSION['success'],'green');
                unset($_SESSION['success']);
            }
            if(isset($_SESSION['error']) && !empty($_SESSION['error'])){
                echo $functions->message($_SESSION['error'],'red');
                unset($_SESSION['error']);
            }
        ?>
        <div class="row">
            <div class="col-sm-12 col-md-8" style="margin-top:20px">
            <select class="js-example-basic-single" name="state" style="width:100%" onchange="get_value(event)">
            <option value="">--- Select a product ----</option>
               <?php 

                 $sql = "select * from products where p_STATUS != 'deleted' and p_AVAILABILITY like 'yes' order by p_NAME asc";
                 $results = $functions->fetch_rows($functions->query($sql));
                 foreach ($results as $result) {
                    echo '<option value="'.$result['p_ID'].'">'.$result['p_NAME'].' ('.$result['p_MODEL'].') - '.$result['p_YEAR'].' - '.$result['p_SKU'].'</option>';
                }
               ?>
            </select>

            <div id="cart" style="margin-top:40px">

            <table class="ui celled table">
            <thead>
                <tr><th>Product</th>
                <th>Qty</th>
                <th>Unit Cost</th>
                <th>Amt (Qty * Unit Cost)</th>
                <th></th>
            </tr></thead>
            <tbody>
                <tr  v-for="item in cart">
                    <td data-label="Name">{{item.p_NAME}}</td>
                    <td data-label="Age"> 
                        <div v-if="item.p_STATUS == 'active'">
                            <div class="ui input"> 
                                <input min="1" v-on:input="event => update_qty(event,item.p_ID)" v-bind:value="item.p_QTY"  id="gross_amount" value="1" type="number"/>
                            </div>
                        </div>
                        <div v-else>
                        <div class="ui input"> 
                                <input min="1" style="background-color:#F1F1F1" v-bind:value="item.p_QTY" readonly  id="gross_amount" value="1" type="number"/>
                            </div>
                        </div>

                    </td>
                    <td data-label="Job"><div class="ui input">
                        <input style="background-color:#F1F1F1" v-bind:value="item.p_PRICE" readonly id="gross_amount" type="text"/>
                    </div></td>

                    <td data-label="Job"><div class="ui input">
                        <input style="background-color:#F1F1F1" v-bind:value="item.p_AMOUNT" readonly id="gross_amount" type="text"/>
                    </div></td>
                    <td data-label="Age">
                        <div v-if="item.p_STATUS == 'active'">
                                <div v-if=" item.p_NEW == 'TRUE' ">
                                    <button @click="remove_item_from_cart(item.p_ID)" data-tooltip="Remove product" data-position="top right" class="ui icon button">
                                         <i  class="delete icon"></i>
                                     </button>
                                </div>
                                <div v-else>
                                    <button @click="return_item(item.p_ID)" data-tooltip="Return product" data-position="top right" class="ui icon button">
                                         <i  class="redo icon"></i>
                                     </button>
                                </div>
                            
                        </div>
                        <div v-else>
                            <button  data-tooltip="Product returned" data-position="top right" class="ui icon button">
                                <i style="color:red" class="redo icon"></i>
                            </button>
                        </div>
                    </td>
                </tr>
               
            </tbody>
            </table>
            </div>
            </div>
            <div class="col-sm-12 col-md-4" style="margin-top:20px">
                <div class="ui card">
                <div class="content">
                    <div class="header">ORDER SUMMARY</div>
                </div>
                <div class="content">
                   <div class="row">
                       <div class="col-sm-4">
                           <label>Cutomer name</label>
                       </div>
                       <div class='col-sm-8'>
                        <div class="ui input">
                                <input v-model="customer_name" id="customer_name" type="text"/>
                            </div>
                       </div>
                   </div>

                   <div class="row" style="margin-top:10px">
                       <div class="col-sm-4">
                           <label>Cutomer address</label>
                       </div>
                       <div class='col-sm-8'>
                        <div class="ui input">
                                <input v-model="customer_address" id="customer_address" type="text"/>
                            </div>
                       </div>
                   </div>

                   <div class="row" style="margin-top:10px">
                       <div class="col-sm-4">
                           <label>Cutomer phone number</label>
                       </div>
                       <div class='col-sm-8'>
                        <div class="ui input">
                                <input v-model="customer_phone" id="customer_phone_number" type="text"/>
                            </div>
                       </div>
                   </div>
                   <div class="ui divider"></div>
                   <div class="row" style="margin-top:10px">
                       <div class="col-sm-4">
                           <label>Gross Amount</label>
                       </div>
                       <div class='col-sm-8'>
                        <div class="ui input">
                                <input v-model="gross_amount" style="background-color:#F1F1F1" readonly id="gross_amount" type="text"/>
                            </div>
                       </div>
                   </div>

                   <div class="row" style="margin-top:10px">
                       <div class="col-sm-4">
                           <label>VAT {{vat_percentage}}%</label>
                       </div>
                       <div class='col-sm-8'>
                        <div class="ui input">
                                <input v-model="vat" style="background-color:#F1F1F1" readonly  id="vat" type="text"/>
                            </div>
                       </div>
                   </div>

                   <div class="row" style="margin-top:10px">
                       <div class="col-sm-4">
                           <label>Discount</label>
                       </div>
                       <div class='col-sm-8'>
                        <div class="ui input">
                                <input v-on:input="event => calculate_order_summary()" v-model="discount" id="discount" type="text"/>
                            </div>
                       </div>
                   </div>


                   <div class="row" style="margin-top:10px">
                       <div class="col-sm-4">
                           <label>Net Amount</label>
                       </div>
                       <div class='col-sm-8'>
                        <div class="ui input">
                                <input style="font-weight:bolder; background-color:#F1F1F1" v-model="net_amount" style="background-color:#F1F1F1" readonly id="net_amount" type="text"/>
                            </div>
                       </div>
                   </div>

                   <div class="row" style="margin-top:10px">
                       <div class="col-sm-4">
                           <label>Payment Status</label>
                       </div>
                       <div class='col-sm-8'>
                       <select v-model="payment_status" v-on:change="event => check_payment_status()" class="ui dropdown"  id="payment_status" style="width:100%">
                            <option value="Unpaid">Unpaid</option>
                            <option value="Paid">Paid</option>
                        </select>
                   </div>
                    </div>

                   <div class="row" style="margin-top:10px">
                       <div class="col-sm-4">
                           <label>Amount recieved</label>
                       </div>
                       <div class='col-sm-8'>
                        <div class="ui input">
                                <input v-on:input="event => calculate_order_summary()" v-model="amount_received" id="amount_received" type="text"/>
                            </div>
                       </div>
                   </div>


                   <div class="row" style="margin-top:10px">
                       <div class="col-sm-4">
                           <label>Top up</label>
                       </div>
                       <div class='col-sm-8'>
                        <div class="ui input">
                                <input style="font-weight:bolder; background-color:#F1F1F1" v-model="top_up" style="background-color:#F1F1F1" readonly id="net_amount" type="text"/>
                            </div>
                       </div>
                   </div>

                   <div class="row" style="margin-top:10px">
                       <div class="col-sm-4">
                           <label>Sold by</label>
                       </div>
                       <div class='col-sm-8'>
                        <div class="ui input">
                                <input style="font-weight:bolder; background-color:#F1F1F1" v-model="sold_by" style="background-color:#F1F1F1" readonly id="net_amount" type="text"/>
                            </div>
                       </div>
                   </div>

                   <div class="row" style="margin-top:10px">
                       <div class="col-sm-4">
                           <label>Modified by</label>
                       </div>
                       <div class='col-sm-8'>
                        <div class="ui input">
                                <input style="font-weight:bolder; background-color:#F1F1F1" v-model="modified_by" style="background-color:#F1F1F1" readonly id="net_amount" type="text"/>
                            </div>
                       </div>
                   </div>

                </div>
                <div class="extra content">
                    <button class="ui button green"  @click="update_order('save')" style="width:100%">Save & Continue</button>
                    <br/><br/>
                    <button class="ui button blue"  @click="update_order('print')" style="width:100%">Save & Print</button>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="lib/vue.js"></script>
<script src="lib/axios.js"></script>
<script src="lib/add_order_vue.js"></script>


<?php include_once 'includes/layout/footer.php'?>

<script>
    $(document).ready(function () {
        var orderId = $('#order_id').val();
        app.fetch_order(orderId);
    });
</script>