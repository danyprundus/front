<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php">Casuta Jucariilor</a>
    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right">
        <li class="dropdown">
               <a href="clienti.php" class="btn btn-warning">Copii</a>
        </li>
        <li class="dropdown">
               <a href="financiar.php"  class="btn btn-danger">Bani</a>
        </li>
        <!-- /.dropdown -->
        <li class="dropdown">
            <a class="dropdown-toggle btn btn-info" data-toggle="dropdown" href="#">
                <i class="fa fa-tasks fa-fw"></i>  <i class="fa fa-caret-down"></i> Inventar
            </a>
            <ul class="dropdown-menu dropdown-tasks">
                <li>
                    <a href="products.php?command=sell">Vanzare</a>
                 </li>
                <li>
                    <a href="products.php?command=add">Adauga</a>
                 </li>
                <li class="divider"></li>

            </ul>
            <!-- /.dropdown-tasks -->
        </li>

    </ul>
    <!-- /.navbar-top-links -->

    <?php
    //require "inc/sidebar.php"
    ?>
    <!-- /.navbar-static-side -->
</nav>