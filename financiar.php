<?php
require "inc/header.php";
require "classes/finance.php";
require "classes/builder.php";

?>

<body>
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
                <h1 class="page-header">Operatii financiare</h1>
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

                <div class="row">
                    <div class="col-lg-6">
                        <form role="form" id="financiarForm">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label>Alege Operatiunea</label>
                                        <select  class="form-control operatiuneFinanciara">
                                            <option value="#">Alege</option>
                                           <?php
                                              $builder->outputOptions($finance->financeOptions());
                                           ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-primary seara hide operatiune">
                                <div class="panel-heading">
                                    Numerar seara
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <?php
                                        $builder->outputMonetar($finance->financeMonetarOptions(),"seara");
                                        ?>

                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-primary dimineata  operatiune hide">
                                <div class="panel-heading">
                                    Numerar dimineata
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <?php
                                        $builder->outputMonetar($finance->financeMonetarOptions(),"dimineata");
                                        ?>

                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-primary bon hide  operatiune">
                                <div class="panel-heading">
                                    PLati Bon
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <?php
                                        $builder->outputMonetar($finance->financeBonOptions(),"bon");
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-primary factura hide  operatiune">
                                <div class="panel-heading">
                                  Facturi
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <?php
                                        $builder->outputMonetar($finance->financeFacturaOptions(),"factura");
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-primary zet hide  operatiune">
                                <div class="panel-heading">
                                  Facturi
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <?php
                                        $builder->outputMonetar($finance->financeZetOptions(),"zet");
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-primary retragere hide  operatiune">
                                <div class="panel-heading">
                                  Facturi
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <?php
                                        $builder->outputMonetar($finance->financeZetOptions(),"retragere");
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-primary financeFacturaOption hide  operatiune">
                                <div class="panel-heading">
                                  Facturi
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <?php
                                        $builder->outputMonetar($finance->financeZetOptions(),"financeFacturaOption");
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <!-- /.panel -->

                            <!-- /.panel-body -->
                            <button type="submit" class="btn btn-default">Salveaza</button>
                        </form>
                    </div>
                    <!-- /.col-lg-6 (nested) -->

                    <!-- /.col-lg-6 (nested) -->
                </div>
                <!-- /.row (nested) -->


            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->

</div>

<!-- /#wrapper -->
<?php
require "inc/footer.php";
?>