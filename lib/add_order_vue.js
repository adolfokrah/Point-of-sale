var app = new Vue({
    el: '#app',
    data: {
      message: 'Hello Vue!',
      products:[],
      cart:[],
      gross_amount:0,
      vat:0,
      discount:0,
      net_amount: 0,
      payment_status:'Unpaid',
      amount_received: 0,
      customer_name:'',
      customer_address:"",
      customer_phone:"",
      vat_percentage:0,
      order_id:0,
      returned_items:[],
      top_up:0,
      sold_by:"",
      modified_by:"",
      warant_days:0
    },
    methods: {
        add_to_cart(id){
          var products = this.products;
          var cart = this.cart;
          for(var i = 0; i < products.length; i++){
              if(products[i]['p_ID'] == id){   
                if(cart.length < 1){
                    var item = {
                        'p_NAME': products[i]['p_NAME'] + ' ('+products[i]['p_MODEL']+') - '+products[i]['p_YEAR'],
                        'p_PRICE':' ¢ '+ Number(products[i]['p_PRICE']).toFixed(2),
                        'p_ID': products[i]['p_ID'],
                        'p_AMOUNT':' ¢ '+ Number(products[i]['p_PRICE']).toFixed(2),
                        'p_QTY': 1,
                        'p_STATUS': 'active',
                        'cart_id':0,
                        'p_NEW': 'TRUE'
                    };
                    cart.push(item);
                }else{
                    var insert = true;
                    for (let index = 0; index < cart.length; index++) {
                        if(cart[index]['p_ID'] == id && cart[index]['p_STATUS'] == 'active' ){
                            console.log(cart[index]['p_ID'], id);
                            cart[index]['p_QTY'] = Number(cart[index]['p_QTY']) + 1;
                            var cost = cart[index].p_PRICE.replace(' ¢ ','');
                            var cost = cost * cart[index]['p_QTY'];
                            cart[index].p_AMOUNT = ' ¢ '+ Number(cost).toFixed(2);
                            insert = false;
                        }
                    }

                    if(insert){
                        var item = {
                            'p_NAME': products[i]['p_NAME'] + ' ('+products[i]['p_MODEL']+') - '+products[i]['p_YEAR'],
                            'p_PRICE':' ¢ '+ Number(products[i]['p_PRICE']).toFixed(2),
                            'p_ID': products[i]['p_ID'],
                            'p_AMOUNT':' ¢ '+ Number(products[i]['p_PRICE']).toFixed(2),
                            'p_QTY': 1,
                            'p_STATUS': 'active',
                            'cart_id':0,
                            'p_NEW': 'TRUE'
                        };
                        cart.push(item);
                    }
                }
                  break;
              }
          }

          this.cart = cart;
          this.calculate_order_summary();
          
       },
       remove_item_from_cart(id){
        var cart = this.cart;
        for(var i = 0; i < cart.length; i++){
            if(cart[i]['p_ID'] == id){
                cart.splice(i,1);
                break;
            }
        }
        this.cart = cart;
        this.calculate_order_summary();
       },
       update_qty(event,id){
        
        if(event.target.value < 1){
            return;
        }
        var cart = this.cart;
        for(var i = 0; i < cart.length; i++){
            if(cart[i]['p_ID'] == id){
               cart[i].p_QTY = event.target.value;
               var cost = cart[i].p_PRICE.replace(' ¢ ','');
               cost = cost * event.target.value;
               cart[i].p_AMOUNT = ' ¢ '+ Number(cost).toFixed(2);
               break;
            }
        }
        this.cart = cart;
        this.calculate_order_summary();
       },
       calculate_order_summary(){
           var cart = this.cart;
           var gross_amount = 0;
           cart.forEach((item) => {
                if(item.p_STATUS == 'active'){
                    var cost = item.p_AMOUNT.replace(' ¢ ','');
                    gross_amount = Number(gross_amount) + Number(cost);
                }
           })
           this.vat = Number(this.vat_percentage / 100 * gross_amount).toFixed(2);
           this.gross_amount = ' ¢ '+Number(gross_amount).toFixed(2);
           var net_amount = Number(this.vat)+ Number(this.gross_amount.replace(' ¢ ','')) - Number(this.discount);
           
           //calculate top up
           var top_up =   net_amount - this.amount_received;
           this.top_up = Number(top_up).toFixed(2);
           this.net_amount = ' ¢ '+ Number(net_amount).toFixed(2);

       },
       async save_order(action){
           if(this.payment_status.toUpperCase() == 'PAID' && this.amount_received < this.net_amount.replace(' ¢ ','')){
               alert('We are expecting '+this.net_amount+' from the customer');
               return;
           }

           if(this.amount_received >= Number(this.net_amount.replace(' ¢ ',''))&& this.amount_received > 0){
            this.payment_status = 'Paid';
        }
        
           if(this.cart.length < 1){
            alert('Please add some items to this cart');
            return;
           }
           this.check_payment_status();
           var data = {
                action: action,
                cart : this.cart,
                gross_amount:this.gross_amount.replace(' ¢ ',''),
                vat:this.vat,
                discount:this.discount,
                net_amount: this.net_amount.replace(' ¢ ',''),
                payment_status:this.payment_status,
                amount_received: this.amount_received,
                customer_name:this.customer_name,
                customer_address:this.customer_address,
                customer_phone:this.customer_phone,
                vat_percentage: this.vat_percentage,
                warant_days : this.warant_days
           };
           var url = 'includes/save_order.php';
           var request = await axios.post(url,JSON.stringify(data));
          
           if(action == "print"){
            window.open('includes/testprint.php?order_id='+request.data,'_blank');
           }
           window.open('edit_order.php?order='+request.data,'_self');
           
           
       },
       async fetch_order(order_id){
            var url = 'includes/fetch_order.php';
            var data = {
                'orderId': order_id
            }
            var request = await axios.post(url,JSON.stringify(data));
            var data = request.data;
            this.amount_received = Number(data[0].amount_received).toFixed(2);
            this.customer_address= data[0].customer_address;
            this.customer_name = data[0].customer_name;
            this.customer_phone = data[0].customer_phone;
            this.discount = Number(data[0].discount).toFixed(2);
            this.gross_amount  = ' ¢ '+Number(data[0].gross_amount).toFixed(2);
            this.net_amount= ' ¢ '+Number(data[0].net_amount).toFixed(2);
            this.payment_status= data[0].payment_status;
            this.vat = data[0].vat;
            this.order_id = data[0].order_id;
            this.cart = data[1];
            this.vat_percentage = data[0]['vat_percentage'];
            this.sold_by = data[0]['sold_by'];
            this.modified_by = data[0]['modified_by'];
            this.warant_days = data[0]['warant_days'];

            this.calculate_order_summary();
       },
       return_item(id){
            var cart = this.cart;
            var returned_items = this.returned_items;
            for(var i = 0; i < cart.length; i++){
                if(cart[i]['p_ID'] == id){
                    if(cart[i]['p_NEW'] == 'FALSE'){
                        returned_items.push(cart[i]);
                    }
                    cart.splice(i,1);
                    break;
                }
            }
            this.returned_items = returned_items;
            this.cart = cart;
            this.calculate_order_summary();
       },
       async update_order(action){
            if(this.payment_status.toUpperCase() == 'PAID' && this.amount_received < Number(this.net_amount.replace(' ¢ ',''))){
                alert('We are expecting '+this.net_amount+' from the customer');
                return;
            }

            if(this.amount_received >= Number(this.net_amount.replace(' ¢ ','')) && this.amount_received > 0){
                this.payment_status = 'Paid';
            }

            if(this.cart.length < 1 && this.returned_items.length < 1){
                alert('Please add some items to this cart');
                return;
            }
            this.check_payment_status();

            var cart = this.cart;
            var returned_items = this.returned_items;
            if(returned_items.length > 0){
                returned_items.forEach((item) => {
                    item.p_STATUS = 'returned';
                    cart.push(item);
                })
            }

            var data = {
                action: action,
                cart : this.cart,
                gross_amount:this.gross_amount.replace(' ¢ ',''),
                vat:this.vat,
                discount:this.discount,
                net_amount: this.net_amount.replace(' ¢ ',''),
                payment_status:this.payment_status,
                amount_received: this.amount_received,
                customer_name:this.customer_name,
                customer_address:this.customer_address,
                customer_phone:this.customer_phone,
                order_id: this.order_id,
                vat_percentage: this.vat_percentage,
                warant_days : this.warant_days
           };
           var url = 'includes/update_order.php';
           var request = await axios.post(url,JSON.stringify(data));
          // console.log(request.data); return;
           if(action == "print"){
            window.open('includes/testprint.php?order_id='+request.data,'_blank');
           }
           window.open('edit_order.php?order='+request.data,'_self')
       },
       async fetch_vat(){
        var url = 'includes/fetch_vat.php';
        var request = await axios.get(url);
        this.vat_percentage = request.data;
       },
       check_payment_status(){
           if(this.payment_status == 'Unpaid'){
               this.amount_received = 0;
               this.calculate_order_summary();
           }
       }
    },
    mounted: async function() {
        var url = 'includes/fetch_products.php';
        var request = await axios.get(url);
        this.products = request.data;
    }
})