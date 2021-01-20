<div class="topBar">
    <div style="display:flex; flex-direction:row; align-items:center">

    <button id="button" class="ui icon inverted basic button" style="margin-left:10px">
        <i class="bars icon"></i>
    </button>

    <div style="margin-left:20px">
        <i class="home icon"></i> <?php echo $functions->fetch_rows($functions->query("select * from company_details"))[0]['company_name'] ?>
    </div>

</div>

    <div class="ui topBarProfile"> <i class="user icon"></i> <?php echo $_SESSION['user_data']['user_name']?>, <?php echo $_SESSION['user_data']['user_type']?>
    <div class="drop inverted">
        <div class="row">
            <div class="col-sm-5">
                <img src="images/avatar.png" width="100%"/>
            </div>
            <div class="col-sm-7">
                <div><?php echo $_SESSION['user_data']['user_name']?></div>
                <div><a href="settings.php">Edit profile</a></div>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </div>
    </div>
</div>