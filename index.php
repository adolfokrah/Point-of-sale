
<?php $title = 'Login'; ?>
<?php 
    include_once 'includes/includes.php';
    
    if($session->isUserLoggedIn()){
        $functions->redirect('home.php');
    }
?>
<link rel="stylesheet" href="lib/css/login.css"/>
</head>
<body>
 <div id="login_container">
    <div id="login_box">
        <h3>Login</h3>
        <form id="login_form" method="post" action="index.php">
            <h5>Sign in to start your sesssion</h5>
            <?php 
                $functions->login();
            ?>
            <div class="ui icon input">
                <input value="admin" name="username" type="text" placeholder="username" required>
                <i class="user icon"></i>
            </div>
            <br/><br/>
            <div class="ui icon input">
                <input value="admin" name="password" type="password" placeholder="password" required>
                <i class="lock icon"></i>
            </div>
            <br/><br/>
            <button type="submit" class="ui primary button">
              Sign in
            </button>
        </div>
    </div>
</div>
<?php include_once 'includes/layout/footer.php'?>