<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Informasi Penumpang</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>
  <body>
      <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <!-- <a class="navbar-brand" href="#"></a> -->
          </div>

          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="navbar">
            <ul class="nav navbar-nav">
              <!-- <li class='button'><a href="#">Peta</a></li> -->
              <li><?php echo anchor('admin/home','Home') ?></li>
              <li><?php echo anchor('admin/relasi','PIS') ?></li>
              <li class='dropdown'><a href='#' class='dropdown-toggle' data-toggle='dropdown'><span class="glyphicon glyphicon-list"></span> Data <b class='caret'></b></a>
                  <ul class='dropdown-menu'>
                      <li><?php echo anchor('admin/armada','Armada') ?></li>
                      <li><?php echo anchor('admin/jalan','Rute Jalan') ?></li>
                      <li><?php echo anchor('admin/halte','Halte') ?></li>
                  </ul>
              </li>
              <li class='dropdown'><a href='#' class='dropdown-toggle' data-toggle='dropdown'><span class="glyphicon glyphicon-map-marker"></span> Koordinat <b class='caret'></b></a>
                  <ul class='dropdown-menu'>
                      <li><?php echo anchor('admin/koordinatarmada','Koordinat Armada') ?></li>
                      <li><?php echo anchor('admin/koordinatjalan','Koordinat Rute Jalan') ?></li>
                      <li><?php echo anchor('admin/koordinathalte','Koordinat Halte') ?></li>
                  </ul>
              </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
              <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>

            </ul>
          </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
      </nav>
      <!--header admin-->
