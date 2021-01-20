
function show_modal(id){
    if (confirm('Are you sure you want to delete this product?')) {
        window.open('products.php?id='+id+'&action=del','_self');
      } else {
        // false
      }
}

function delete_user(id){
    if (confirm('Are you sure you want to delete this user?')) {
        window.open('users.php?id='+id+'&action=del','_self');
      } else {
        // false
      }
}

function delete_group(id){
  if (confirm('Are you sure you want to delete this group?')) {
      window.open('groups.php?id='+id+'&action=del','_self');
    } else {
      // false
    }
}

function add_stock(id){
    var new_qty = $('#stock_p_new_qty_'+id).val();
    if(new_qty != 0){
        $.post('includes/add_stock.php',{new_qty: new_qty,p_id: id},function(data){
            console.log(data);
            $('#stock_p_qty_'+id).html(data);
            $('#stock_p_new_qty_'+id).val('');
        })
    }
    
}

function get_key(event,id){
    if (event.keyCode === 13) {
        // Cancel the default action, if needed
        event.preventDefault();
        // Trigger the button element with a click
        add_stock(id);
      }
}

function get_value(event){
    if(event.target.value == ''){
      return;
    }
    app.add_to_cart(event.target.value);
}



function toggle_permission(module_name,permission){

   var ischecked = $('#'+module_name+'_'+permission).prop('checked');
   if(permission != "view" && ischecked){
      $('#'+module_name+'_view').prop('checked', true);
   }else if(permission == 'view' && !ischecked){
      $('#'+module_name+'_create').prop('checked', false);
      $('#'+module_name+'_delete').prop('checked', false);
      $('#'+module_name+'_update').prop('checked', false);
   }
}

function function_add_group(action){
  var permissions_modules = [];
  var modules = document.getElementsByClassName('modules');
 
  for (let index = 0; index < modules.length; index++) {
    var module_name = modules[index].id;
    var data = {
      'module_name': module_name,
      'permissions': []
    }
    permissions_modules.push(data);
  }

  var permissions  = ['create','view','update','delete'];
  permissions_modules.forEach((permission_module) => {
    permissions.forEach((permission) => {
      var ischecked = $('#'+permission_module['module_name']+'_'+permission).prop('checked');
      //check if permission is checked then add to the permission module
      if(ischecked){
        //but check if permission modules has some modules
        permission_module['permissions'].push(permission);
        // console.log(permission_module['module_name'], permission, ischecked);

      }
    })
  })

  var group_name = $('#group_name').val();
  
  if(group_name == ''){
    alert('Group name needed');
    return;
  }

  var insert = false;
  permissions_modules.forEach((permission_module) => {
    if(permission_module['permissions'].length > 0){
      insert = true;
    }
  });


  if(insert == false){
    alert('Please select some permissions');
    return;
  }

  permissions_modules = JSON.stringify(permissions_modules);

  var url = 'includes/add_group.php';
  var data = {group_name: group_name, permission: permissions_modules};


  if(action == 'update'){
    var url = 'includes/edit_group.php';
    data = {group_name: group_name, permission: permissions_modules,group_id : $('#group_id').val()};
  }
  $.post(url,data,function(data){
     if(data == 'error'){
       alert("Group already added");
     }else{
      window.open('groups.php?','_self')
     }
  })
}


$('#button').on('click',function(){
  $('.side-bar').toggleClass('open');
})