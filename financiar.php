<?php
require "inc/header.php";
require "classes/finance.php";
require "classes/builder.php";

?>

<body>
<?php
$finance= new \finance\finance();
$builder= new \builder\builder();
$dateComponents = @getdate();

if($_POST['month']){

    $month=$_POST['month'];
}
else{
    $month = $dateComponents['mon'];

}

$year = $dateComponents['year'];

?>
<div id="wrapper">

    <!-- Navigation -->
    <?php
    require "inc/navbar.php";
    ?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header btn-danger">Operatii financiare</h1>
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
<?

echo build_calendar($month,$year,$dateArray);
if($_GET['viewdate']){
$data=json_decode(file_get_contents(API_URL. "finance/monetar/getall/".Playground."/".$_GET['date']));
?>
    <table class="table table-bordered table-hover">
        <tr>
            <th>Data si ora</th>
            <th>Total</th>
            <th>Detalii</th>
            <th>Tip Operatiune</th>
        </tr>
    <?
    foreach ($data as $result){
?>
        <tr>
            <th><?=$result->time?></th>
            <th><?=$result->total?></th>
            <th><? echo $finance->financeShowDetails($result->data,$result->operatiune)?></th>
            <th><?=$result->operatiune?></th>
        </tr>


        <?
}
}
?></table>
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
function build_calendar($month,$year){

    // What is the first day of the month in question?
    $firstDayOfMonth = @mktime(0,0,0,$month,1,$year);

    // How many days does this month contain?
    $numberDays = @date('t',$firstDayOfMonth);
    $data=json_decode(file_get_contents(API_URL. "finance/monetar/getMoneyForMonth/".Playground."/$year".($month<10?"0".$month:$month)."/zet"));
    $zetInfo=json_decode(json_encode($data), True);


    $data=json_decode(file_get_contents(API_URL. "finance/monetar/getMoneyForMonth/".Playground."/$year".($month<10?"0".$month:$month)."/factura"));
    $facturaInfo=json_decode(json_encode($data), True);

    $data=json_decode(file_get_contents(API_URL. "finance/monetar/getMoneyForMonth/".Playground."/$year".($month<10?"0".$month:$month)."/bon"));
    $bonInfo=json_decode(json_encode($data), True);

    $data=json_decode(file_get_contents(API_URL. "finance/monetar/getMoneyForMonth/".Playground."/$year".($month<10?"0".$month:$month)."/retragere"));
    $retragereInfo=json_decode(json_encode($data), True);

    $data=json_decode(file_get_contents(API_URL. "finance/monetar/getCountForMonth/".Playground."/$year".($month<10?"0".$month:$month)));
    $moneyCountInfo=json_decode(json_encode($data), True);
    ?>

    <table class="table table-bordered table-responsive table-striped" >
        <tr>
            <td> Schimba Luna
                <form method="post">
                <select name="month" onchange="this.form.submit()">
                    <?for($i=1;$i<=$numberDays;$i++):?>
                        <option value="<?=$i?>" <? if($month==$i) echo ' selected '?>><?=$i?></option>
                    <?endfor;?>

                </select> </form></td>

        </tr>
        <tr>
            <th>Ziua</th>
            <th>Z</th>
            <th>Factura</th>
            <th>Bon</th>
            <th>Retragere</th>
            <th>Monetar Dimineata</th>
            <th>Monetar Seara</th>
        </tr>
        <?php for($i=1;$i<=$numberDays;$i++):
            $currentDayRel = str_pad($i, 2, "0", STR_PAD_LEFT);
            $currentMonthRel= ($month<10?"0".$month:$month);
             $date = "$year-$currentMonthRel-$currentDayRel";
            $key=$year.$currentMonthRel.$i;

            ?>
        <tr>
            <td><a href='financiar.php?viewdate=1&date=<?=$date?>'><?=$i?></a></td>
            <td><?=$zetInfo[$key];?></td>
            <td><?=$facturaInfo[$key];?></td>
            <td><?=$bonInfo[$key];?></td>
            <td><?=$retragereInfo[$key];?></td>
            <td><?=@$moneyCountInfo[$key]['dimineata']['max'];?></td>
            <td><?=@$moneyCountInfo[$key]['seara']['max'];?></td>

        </tr>

        <?endfor;?>
    </table>
    <?

}

require "inc/footer.php";
?>