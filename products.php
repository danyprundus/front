<?php
require "inc/header.php";
require "classes/finance.php";
require "classes/builder.php";
$command=$_GET['command'];

$finance = new \finance\finance();
$builder = new \builder\builder();
?>
    <div id="wrapper">

        <!-- Navigation -->
        <?php
        require "inc/navbar.php";
        ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><?=$command=='add'?  "Intrari":"Iesiri"?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <td class="row">
                <td class="col-lg-12">
                    <div class="alert alert-success alert-dismissable hide">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <div id="alert-dimissable-text"></div>
                    </div>
                    <td class="panel panel-default">

                        <!-- /.panel-heading -->
                        <td class="panel-body product-data">
                            <td class="table-responsive col-lg-8">
                                <table class="table table-striped table-bordered table-hover">
                                    <?php
                                    $tmp=$finance->financeProductAddOptions();
                              if($command=='sell') unset($tmp['qty']);

                                    $builder->outputClientiHeader($tmp, ($command=='add'? "productAdd":"productRemove"),array(),"btn-danger",($command=='add'? "Adaug":"Cumparat"));
                                    ?>

                                </table>
                                <div id="extraData"></div>
                                <p class="bg-primary"><?=($command=='add'? "Stocuri":"Situatie Vanzare")?> </p>
                            Cautare <input id="inventorySearchInput" value="">

                <table class="table table-bordered table-hover table-responsive">
                                    <tr>

                                        <th>Nume</th>
                                        <th>Cantitate <?=($command=='add'? "in stoc":"vanduta")?> </th>
                                        <th>Pret per bucata</th>
                                        <th>Total</th>
                                        <th>Cod de bare</th>
                                    </tr>

                                <?

                                $data=json_decode(file_get_contents(API_URL."finance/inventory/totalsForProducts/".Playground.($command=='add'? "":"/vanzari")));
                                $data=json_decode($data->data);
                                 $grandTotal=0;
                                foreach ($data as $val):
                                    $grandTotal+=abs($val->totalPrice);
                                    ?>
                                    <tr >

                                        <td><?=$val->name?></td>
                                        <td class="<?=($val->qty>0? "bg-primary":"bg-danger")?>" ><strong><?=abs($val->qty)?> </strong> bucati</td>
                                        <td><strong><?=$val->price?> </strong>  lei</td>
                                        <td><strong><?=abs($val->totalPrice)?> </strong> lei</td>
                                        <td><?=$val->barcodeID?>  </td>
                                    </tr>


                                    <?
                                endforeach;
                                ?>

                                    <tr>

                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><strong><?=$grandTotal?> </strong> lei</td>
                                        <td> </td>
                                    </tr>
                                </table>
                            </div>


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
//test git
require "inc/footer.php";
?>

