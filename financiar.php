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
$dateComponents = @getdate();

$month = $dateComponents['mon'];
$year = $dateComponents['year'];

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
function build_calendar($month,$year,$dateArray) {

    // Create array containing abbreviations of days of week.
    $daysOfWeek = array('S','M','T','W','T','F','S');
    $currentMonthRel="";
    $key="";
    // What is the first day of the month in question?
    $firstDayOfMonth = @mktime(0,0,0,$month,1,$year);

    // How many days does this month contain?
    $numberDays = @date('t',$firstDayOfMonth);

    // Retrieve some information about the first day of the
    // month in question.
    $dateComponents = @getdate($firstDayOfMonth);

    // What is the name of the month in question?
    $monthName = $dateComponents['month'];

    // What is the index value (0-6) of the first day of the
    // month in question.
    $dayOfWeek = $dateComponents['wday'];

    // Create the table tag opener and day headers
    $data=json_decode(file_get_contents(API_URL. "finance/monetar/getZetForMonth/".Playground."/$year".($month<10?"0".$month:$month)));
    $zetInfo=json_decode(json_encode($data), True);

    $data=json_decode(file_get_contents(API_URL. "finance/monetar/getCountForMonth/".Playground."/$year".($month<10?"0".$month:$month)));
    $moneyCountInfo=json_decode(json_encode($data), True);
    $calendar = "<table class='calendar table table-bordered'>";
    $calendar .= "<caption>$monthName $year</caption>";
    $calendar .= "<tr>";

    // Create the calendar headers

    foreach($daysOfWeek as $day) {
        $calendar .= "<th class='header'>$day</th>";
    }

    // Create the rest of the calendar

    // Initiate the day counter, starting with the 1st.

    $currentDay = 1;

    $calendar .= "</tr><tr>";

    // The variable $dayOfWeek is used to
    // ensure that the calendar
    // display consists of exactly 7 columns.

    if ($dayOfWeek > 0) {
        $calendar .= "<td colspan='$dayOfWeek'>&nbsp;</td>";
    }

    $month = str_pad($month, 2, "0", STR_PAD_LEFT);

    while ($currentDay <= $numberDays) {

        // Seventh column (Saturday) reached. Start a new row.

        if ($dayOfWeek == 7) {

            $dayOfWeek = 0;
            $calendar .= "</tr><tr>";

        }

        $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);

        $date = "$year-$month-$currentDayRel";

        $calendar .= "<td class='day' rel='$date'><a href='financiar.php?viewdate=1&date=$date'>$currentDay</a><br>";

                       $key=$year.$month.$currentDayRel;
                        if($zetInfo[$key]>0) {
                            $calendar .= "<div class='col-lg-12'> <button type=\"button\" class=\"btn btn-success\">Z <span class=\"badge\">";
                            $calendar .= $zetInfo[$key];
                            $calendar .= "</span></button></div>" ;

                        }
                        if($moneyCountInfo[$key]['max']>0) {
                            $calendar .= "<div class='col-lg-12'><button type=\"button\" class=\"btn btn-info\">Numerar max<span class=\"badge\">";
                            $calendar .= $moneyCountInfo[$key]['max'];
                            $calendar .= "</span></button></div>" ;

                        }
                        if($moneyCountInfo[$key]['min']>0&&$moneyCountInfo[$key]['max']<>$moneyCountInfo[$key]['min']) {
                            $calendar .= "<div class='col-lg-12'><button type=\"button\" class=\"btn btn-danger\">Numerar min<span class=\"badge\">";
                            $calendar .= $moneyCountInfo[$key]['min'];
                            $calendar .= "</span></button></div>" ;

                        }
                        $calendar.="</td>";
        // Increment counters

        $currentDay++;
        $dayOfWeek++;

    }



    // Complete the row of the last week in month, if necessary

    if ($dayOfWeek != 7) {

        $remainingDays = 7 - $dayOfWeek;
        $calendar .= "<td colspan='$remainingDays'>&nbsp;</td>";

    }

    $calendar .= "</tr>";

    $calendar .= "</table>";

    return $calendar;

}


require "inc/footer.php";
?>