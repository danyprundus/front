<?php
require "inc/header.php";
require "classes/finance.php";
require "classes/builder.php";

?>

<body xmlns="http://www.w3.org/1999/html">
<?php
$finance= new \finance\finance();
$builder= new \builder\builder();
?>
<div id="wrapper">

    <!-- Navigation -->
    <?php
    require "inc/navbar.php";
    ?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header btn-warning">Clienti</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="alert alert-success alert-dismissable hide">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <div id="alert-dimissable-text"> </div>
                </div>
                <div class="panel panel-default">

                    <!-- /.panel-heading -->
                    <div class="panel-body  client-data">
                        <div class="table-responsive">
                            Cautare <input id="clientSearchInput" value="">
                            <br/>
                            <table class="table table-striped table-bordered table-hover">
                         <?php

                          $builder->outputClientiHeader($finance->financeClientiOptions(),"clienti",array("intrare",'id','consum','pret','iesire'),"btn-primary","Adaug ",true);
                         ?>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-6 -->


        </div>
        <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->

</div>

<!-- /#wrapper -->
<?php
require "inc/footer.php";
?>