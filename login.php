<?php

//Include Configuration File
include('config.php');

$login_button = '';

//This $_GET["code"] variable value received after user has login into their Google Account redirct to PHP script then this variable value has been received
if(isset($_GET["code"]))
{
  //It will Attempt to exchange a code for an valid authentication token.
  $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);

  //This condition will check there is any error occur during geting authentication token. If there is no any error occur then it will execute if block of code/
  if(!isset($token['error']))
  {
    //Set the access token used for requests
    $google_client->setAccessToken($token['access_token']);

    //Store "access_token" value in $_SESSION variable for future use.
    $_SESSION['access_token'] = $token['access_token'];

    //Create Object of Google Service OAuth 2 class
    $google_service = new Google_Service_Oauth2($google_client);

    //Get user profile data from google
    $data = $google_service->userinfo->get();

    if(!empty($data['email']))
    {
      $_SESSION['user_email_address'] = $data['email'];
    }
  }
}

if(!isset($_SESSION['access_token']))
{
 $login_button = '<a href="'.$google_client->createAuthUrl().'"><img src="assets/unika_signin_button.png" /></a>';
}

?>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>PHP Login using Google Account</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1' name='viewport'/>
   <!--  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" /> -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- <link href="css/styles.css" rel="stylesheet" /> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
   <!--  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script> -->
    <!-- <script type="text/javascript">
      $(window).on('load',function(){
            $('#pengumuman').modal('show');
        });
    </script> -->

  </head>
  <body>
    <div class="container" style="margin-top: 200px;">
      <h2 align="center">Login Sistem Inventory SIEGA</h2>
      <br />
      <div class="panel panel-default">
        <?php
        if($login_button == '')
        {
          echo "<script>
                  alert('Berhasil Login');
                  window.location.href='index.php';
                  </script>";
          echo '<h3><a href="logout.php">Logout</h3></div>';
        }
        else
        {
          echo "<p style='text-align:center;'>Gunakan email @student.unika.ac.id</p>";
          echo '<div align="center">'.$login_button . '</div>';
        }
        ?>
      </div>
    </div>

    <!-- <div class="modal fade" id="pengumuman" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" style="max-width: 80%;">
        <div class="modal-content" id="result" style="background-color: white;">
          <div class="modal-header">
            <h4 class="modal-title">Jadwal Seminar Magang</h4>
            <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body" style="overflow: auto;">
            <div style="overflow: auto;">
            <?php
              include 'conn.php';
              include "fungsi.php";
              $date = date("Y-m-d")." 00:00:00";
              // $sql = "SELECT * FROM t_pendaftaran WHERE progress ='4' AND tanggal_seminar != '2000-01-01 00:00:00'";
              $sql = "SELECT * FROM t_pendaftaran WHERE progress ='4' AND tanggal_seminar > '$date' ORDER BY tanggal_seminar ASC";
              // echo $sql;
              $query = mysqli_query($conn, $sql);
              if(mysqli_num_rows($query)>0)
              {
                echo "<table class='table table-striped'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th>No</th>";
                echo "<th>NIM</th>";
                echo "<th>Nama</th>";
                echo "<th>Judul</th>";
                echo "<th>Tanggal Seminar</th>";
                echo "<th>Lokasi Seminar</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                $i=0;
                while ($row = mysqli_fetch_array($query)) {
					$i++;
					echo "<tr>";
					echo "<td>".$i."</td>";
					echo "<td>".$row['nim']."</td>";
					echo "<td>".NamaMahasiswa2($conn_firebird, $row['nim'])."</td>";
					echo "<td>".$row['judul']."</td>";
					$tanggal = date("Ymd", strtotime($row['tanggal_seminar'])). "T" . date("His", strtotime($row['tanggal_seminar']));
					$tanggal_akhir = date("Ymd", strtotime($row['tanggal_seminar'])). "T" . date("His", strtotime($row['tanggal_seminar'].'+1 hour'));
					$add_to_calendar = "https://calendar.google.com/calendar/u/0/r/eventedit?text=Seminar+Magang+".$row['nim']."+".NamaMahasiswa2($conn_firebird, $row['nim'])."&dates=".$tanggal."/".$tanggal_akhir;

					echo "<td><a href='".$add_to_calendar."' target='_blank'>".date("d M Y H:i", strtotime($row['tanggal_seminar']))."</a></td>";
					$url_seminar = $row['url_seminar'];
					// if (str_contains($url_seminar, "google")) 
					// 	echo "<td><a href='https://".$row['url_seminar']."' target='_blank'>URL Seminar</td>";
					// else
						echo "<td>".$row['url_seminar']."</td>";
					echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
              }
              else
              {
                echo "<p>Tidak ditemukan Data</p>";
              }
            ?>
          </div>
        </div>
      </div>
    </div> -->
  </body>
</html>