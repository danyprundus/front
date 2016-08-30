<?php
require "inc/header.php";
require "classes/finance.php";
require "classes/builder.php";
if($_GET['command']=='reset'){
    session_destroy();
    print_r($_SESSION);
}
?>

<body>
<div id="wrapper">

    <!-- Navigation -->
    <?php
    require "inc/navbar.php";
    ?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">It works</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->

        <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->

</div>

<!-- /#wrapper -->
<?php
require "inc/footer.php";
?>