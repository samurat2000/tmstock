<?php
include_once 'header.php';
include_once 'headerfiles.php';
?>

<body class="skin-blue sidebar-collapse">
    <div class="wrapper">

      <!-- Main Header -->
<?php 
include_once 'navigation.php';
include_once 'sidebar.php';
?>
      <!-- Left side column. contains the logo and sidebar -->
      

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            View Rentals from
            <small>View, Edit, Print or Delete Rentals</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li>Purchases</li>
            <li class="active">Add</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          
          <!-- Your Page Content Here -->
          <div class="row">
              <div class="col-md-12">
                  <div class="box box-primary">
                      <div class="box-header">
                          <h3 class="box-title with-bPurchase">Filter By:</h3>
                      </div>
                      <div class="box-body">
                          <div class="row">
                              <form class="myform" action="viewrentalsfrom.php" method="GET">
                                  <div class="col-md-4">
                                      <div class="form-group col-md-6">
                                        <label>Return Date From:</label>
                                        <div class="input-group">
                                          <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                          </div>
                                          <input name="datefrom" type="text" class="focus form-control mandatory" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask/>
                                        </div><!-- /.input group -->
                                      </div>
                                      <div class="form-group col-md-6">
                                        <label>To</label>
                                        <div class="input-group">
                                          <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                          </div>
                                          <input name="dateto" type="text" class="form-control mandatory" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask/>
                                        </div><!-- /.input group -->
                                      </div>
                                          <div class="col-md-6">
                                              <button class="btn btn-block btn-primary submit"><i class="fa fa-search"></i> Search</button>
                                          </div>
                                  </div>
                              </form>
                              <form class="myform" action="viewrentalsfrom.php" method="GET">
                              <div class="col-md-4">
                                  <div class="form-group">
                                      <label>Supplier Name</label>
                                      <select name="supplierid" class="form-control mandatory">
                                        <option value="">Select</option>
                                        <?php
                                            $query="Select supplierid,name,city from suppliers";
                                            $result=  queryMysql($query);
                                            while($row=mysqli_fetch_array($result))
                                            {
                                                echo "<option value='$row[supplierid]'>$row[name], $row[city]</option>";
                                            }
                                            ?>
                                      </select>
                                  </div>
                                  <div class="col-md-6">
                                      <button class="btn btn-block btn-primary submit"><i class="fa fa-search"></i> Search</button>
                                  </div>
                              </div>
                              </form>
                              <form class="myform" action="viewrentalsfrom.php" method="GET">
                                  <div class="col-md-4">
                                      <div class="form-group">
                                          <label>City</label>
                                          <select name="city" class="form-control mandatory">
                                            <option value="">Select</option>
                                            <option>Bhopal</option>
                                            <option>Indore</option>
                                            <option>Gwalior</option>
                                          </select>
                                      </div>
                                      <div class="col-md-6">
                                          <button class="btn btn-block btn-primary submit"><i class="fa fa-search"></i> Search</button>
                                      </div>
                                  </div>
                              </form>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <div class="row">
              <div class="col-md-12">
                  <div class="box box-primary">
                      <div class="box-body">
                          
                          <table class="table table-bPurchaseed table-striped Purchase-table">
                              <thead>
                                  <tr>
                                      <th>#</th>
                                      <th>Rental Id</th>
                                      <th>Entry Date</th>
                                      <th>Supplier Name</th>
                                      <th>Manager</th>
                                      <th>Rental from</th>
                                      <th>Rental upto</th>
                                      <th>View</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  
                                  <?php
                                  if(isset($_GET['datefrom']))
                                  {
                                      $datefrom=ymdDate(sanitizeString($_GET['datefrom']));
                                      $dateto=ymdDate(sanitizeString($_GET['dateto']));
                                              $query="Select rentalsfrom.*,suppliers.name as suppliername,suppliers.city as suppliercity,managers.name as managername from rentalsfrom join suppliers on rentalsfrom.supplierid=suppliers.supplierid join managers on rentalsfrom.managerid=managers.managerid where rentupto>='$datefrom' and rentupto<='$dateto' order by rentalsfromid desc";
                                      
                                  }
                                  elseif(isset($_GET['supplierid']))
                                  {
                                      $name=sanitizeString($_GET['supplierid']);
                                  $query="Select rentalsfrom.*,suppliers.name as suppliername,suppliers.city as suppliercity,managers.name as managername from rentalsfrom join suppliers on rentalsfrom.supplierid=suppliers.supplierid join managers on rentalsfrom.managerid=managers.managerid where rentalsfrom.supplierid='$supplierid' order by rentalsfromid desc";
                                      
                                  }
                                  elseif(isset($_GET['city']))
                                  {
                              $query="Select rentalsfrom.*,suppliers.name as suppliername,suppliers.city as suppliercity,managers.name as managername from rentalsfrom join suppliers on rentalsfrom.supplierid=suppliers.supplierid join managers on rentalsfrom.managerid=managers.managerid where suppliers.city='$city' order by rentalsfromid desc";
                                      
                                  }
                                  else
                                  {
                                  $query="Select rentalsfrom.*,suppliers.name as suppliername,suppliers.city as suppliercity,managers.name as managername from rentalsfrom join suppliers on rentalsfrom.supplierid=suppliers.supplierid join managers on rentalsfrom.managerid=managers.managerid order by rentalsfromid desc";
                                  }
                                  $result=queryMysql($query);
                                  $count=1;
                                  while($row=mysqli_fetch_array($result))
                                  {
                                      $id=id($row['rentalsfromid']);
                                      $id="RF-".$id;
                                      $rentaldate=dmyDate($row['date']);
                                      $rentfrom=dmyDate($row['rentfrom']);
                                      $rentupto=dmyDate($row['rentupto']);
                                      echo<<<_END
                                  <tr>
                                      <td>$count</td>
                                      <td>$id</td>
                                      <td>$rentaldate</td>
                                      <td>$row[suppliername], $row[suppliercity]</td>
                                      <td>$row[managername]</td>
                                      <td>$rentfrom</td>
                                      <td>$rentupto</td>
                                      <td><a href="rentalfrom.php?rentalsfromid=$row[rentalsfromid]&func=view">View</a></td>
                                      
                                  </tr>
_END;
                                      $count++;
                                  }
                                  ?>
                                  
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
          </div>
          
          
          
          

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

      <!-- Main Footer -->
      <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
          TMStock - The Makers Stock
        </div>
        <!-- Default to the left --> 
        <strong>Copyright &copy; 2015 <a href="http://themakersweb.com">The Makers Web</a>.</strong> All rights reserved.
      </footer>

    </div><!-- ./wrapper -->

    
  </body>
  
</html>