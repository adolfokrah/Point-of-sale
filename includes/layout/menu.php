<?php
    $side_bar_menu = '[
        {
            "menu_type":"menu",
            "label":"Dashboard",
            "path":"home.php",
             "permissions":["view"]
        },
        {
            "menu_type":"drop",
            "label":"Users",
            "path":"",
            "permissions":["create","view","update","delete"],
            "drop":[
                {
                    "men_type":"menu",
                    "label":"Add user",
                    "path":"add_users.php"
                },
                {
                    "men_type":"menu",
                    "label":"Manage users",
                    "path":"users.php"
                }
            ]
        },
        {
            "menu_type":"drop",
            "label":"Groups",
            "path":"",
            "permissions":["create","view","update","delete"],
            "drop":[
                {
                    "men_type":"menu",
                    "label":"Add group",
                    "path":"add_group.php"
                },
                {
                    "men_type":"menu",
                    "label":"Manage groups",
                    "path":"groups.php"
                }
            ]
        },
        {
            "menu_type":"drop",
            "label":"Products",
            "path":"",
            "permissions":["create","view","update","delete"],
            "drop":[
                {
                    "men_type":"menu",
                    "label":"Add product",
                    "path":"add_product.php"
                },
                {
                    "men_type":"menu",
                    "label":"Manage products",
                    "path":"products.php"
                }
                
            ]
        },
        {
            "menu_type":"menu",
            "label":"Manage stock",
            "path":"stock.php",
            "permissions":["view","update"]
        },
        {
            "menu_type":"drop",
            "label":"Orders",
            "path":"",
            "permissions":["create","view","update"],
            "drop":[
                {
                    "men_type":"menu",
                    "label":"Add order",
                    "path":"add_order.php"
                },
                {
                    "men_type":"menu",
                    "label":"Manage orders",
                    "path":"orders.php"
                }
            ]
        },
        {
            "menu_type":"drop",
            "label":"Elements",
            "path":"",
            "permissions":["create","view","update","delete"],
            "drop":[
                {
                    "men_type":"menu",
                    "label":"Settings",
                    "path":"settings.php"
                }
            ]
        },
        {
            "menu_type":"menu",
            "label":"Company",
            "path":"company.php",
            "permissions":["view"]
        },
        {
            "menu_type":"menu",
            "label":"Logout",
            "path":"logout.php"
        }
    ]';
?>