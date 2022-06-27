<!DOCTYPE html>
<html lang="en">
    <?php 
        session_start();
        require_once ("internal/common.php");
    ?>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/hole.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/style.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script> 
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="http://code.highcharts.com/highcharts-more.js"></script>
        <script src="https://code.highcharts.com/highcharts-3d.js"></script>
        <script src="https://code.highcharts.com/modules/cylinder.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/modules/export-data.js"></script>
        <script src="https://code.highcharts.com/modules/accessibility.js"></script>
        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
        <!-- daterange picker -->
        <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
        <!-- iCheck for checkboxes and radio inputs -->
        <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
        <!-- Bootstrap Color Picker -->
        <link rel="stylesheet" href="plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
        <!-- Tempusdominus Bootstrap 4 -->
        <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
        <!-- Select2 -->
        <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
        <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
        <!-- Bootstrap4 Duallistbox -->
        <link rel="stylesheet" href="plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
        <!-- BS Stepper -->
        <link rel="stylesheet" href="plugins/bs-stepper/css/bs-stepper.min.css">
        <!-- dropzonejs -->
        <link rel="stylesheet" href="plugins/dropzone/min/dropzone.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="dist/css/adminlte.min.css">
        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="dist/css/adminlte.min.css">
        <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
        <link rel="stylesheet" type="text/css" href="https://code.highcharts.com/css/highcharts.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

        
        <style>
          .sombra {
              box-shadow: 5px 5px 10px #666;
          }

          .sombra2 {
              box-shadow: 5px 5px 10px black;
          }

          .sombra3 {
              box-shadow: 5px 5px 10px white;
          }
          ::-webkit-scrollbar{
            display: none;
            }         
             .layer {
                background-color: rgb(24 8 53 / 20%);
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
            }
            .hideenScroll{
              overflow-y:hidden!important;
            }
        
            input[type="text"], input[type="email"], input[type="password"], input[type="checkbox"], input[type="file"], textarea, select, td, th {
              border: 1px solid #501e99 !important;
              text-align: left;
              padding: 8px;
            }
            .highcharts-figure, .highcharts-data-table table {
              min-width: 310px; 
              max-width: 800px;
              margin: 1em auto;  
            }
            .highcharts-data-table table {
              font-family: Verdana, sans-serif;
              border-collapse: collapse;
              border: 1px solid #EBEBEB;
              margin: 10px auto;
              text-align: center;
              width: 100%;
              max-width: 500px;
            }
            .highcharts-data-table caption {
              padding: 1em 0;
              font-size: 1.2em;
              color: #555;
            }
            .highcharts-data-table th {
              font-weight: 600;
              padding: 0.5em;
            }
            .highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
              padding: 0.5em;
            }
            .highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
              background: #f8f8f8;
            }
            .highcharts-data-table tr:hover {
              background: #f1f7ff;
            }
            .highcharts-background {
              fill: black;
              stroke: black;
              stroke-width: 2px;
            }            
        </style>
<script>
$(function () {
    $('#chart_date_range').daterangepicker({   
        "locale": {
            "format": "YYYY-MM-DD",
            "separator": " - ",
            "applyLabel": "Apply",
            "cancelLabel": "Cancel",
            "fromLabel": "From",
            "toLabel": "To",
            
            "daysOfWeek": [
                "Sun",
                "Mon",
                "Tues",
                "Wed",
                "Thurs",
                "Fri",
                "Sat"
            ],
            "monthNames": [
                "January",
                "February",
                "March",
                "April",
                "May",
                "June",
                "July",
                "August",
                "September",
                "Octubre",
                "November",
                "December"
            ],
            "firstDay": 1
        },
        "startDate": new Date(),
        "endDate": new Date(),
        "opens": "center"
    });   
});
</script>
    </head>
    <body id = "wrapper" class="overflow-auto">
        <center><br>
        <div class="layer">
        <label id="desd"></label>
        <label id="hast"></label>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 sombra2 titulos" style="color: white; background: #501e99;">
            <h3>STATS</h3>
            </div>
        </div>   
        <div class="row"  style="margin-top: 20px;">
        <div class="col-md-12 col-sm-12 col-12">
              <div class="card-body sombra2" style="padding: 20px;">
              <div >
              <div class="row">
                <div class="col">
                 <div class="input-group sombra2">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="far fa-calendar-alt"></i>
                      </span>
                    </div>
                    <input type="text" id="chart_date_range" class="form-control float-right" name="date_range" class="form-control" onchange="chartFilters(1)" >
                  </div>
                </div>
                <!-- Merchant-->
                <div id="AlMerchant" class="col">
                </div>
                <div class="col">
                <select class="form-control sombra2" id="chart_channel" onchange="chartFilters(3)">
                    <!-- channel-->
                  <option value="0" selected> All Channel </option>
                  <option value="1"> Cash </option>
                  <option value="2"> Bank </option>
                  <option value="3"> Card </option>
                  </select>
                </div>
                <div class="col">
                <select class="form-control sombra2" id="chart_transaction" onchange="chartFilters(4)" >
                    <!-- type-->
                  <option value="0" selected> All Type Transaction </option>
                  <option value="1"> IN </option>
                  <option value="2"> OUT </option>
                  </select>
                </div>
                <div class="col">
                <select class="form-control sombra2" id="chart_status" onchange="chartFilters(5)" >
                    <!-- status-->
                  <option value="all_status" selected> All Status </option>
                  <option value="0"> Cancelled </option>
                  <option value="1"> Approved </option>
                  <option value="2"> Declined </option>
                  <option value="3"> Pending </option>
                  <option value="4"> Paid </option>
                  <option value="5"> Unpaid </option>
                  <option value="6"> Approved Vs Decline </option>
                  <option value="7"> Decline / Reason </option>
                  </select>
                </div>
                <div id="currency_code" class="col">
                </div>
                <div id="country_filt" class="col">
                </div>
                <div class="col">
                  <select class="form-control sombra2" id="chart_env" onchange="chartFilters(6)" >
                    <!-- environment-->
                  <option value="1" selected> Production</option>
                  <option value="2"> Sandbox </option>
                  </select>
                </div>
              </div>
              </div>
              </div>
                <div class="card-footer">  
                </div>
            </div>
        </div>
        <div class="row  col-md-12 col-sm-12 col-12 justify-content-center" style="margin-top: 20px;">
        <div id = "tarjetas">        
        <div class="row  col-md-12 col-sm-12 col-12 justify-content-center">     
          <div class="col-md-3 col-sm-6 col-12 ">
            <div class="info-box shadow">
              <span class="info-box-icon bg-info"><i class="fas fa-hand-holding-usd"></i></span>
              <div class="info-box-content" >
                <h3 class="info-box-text">Total Trx Period</h3>
                <h3 id = "toTransac" class="info-box-number">0</h3>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box shadow">
              <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span>

              <div class="info-box-content">
                <h3 id="tit_poc" class="info-box-text">% Appr. Transact.</h3>
                <h3 id="porcent" class="info-box-number">0</h3>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box shadow">
              <span class="info-box-icon bg-warning"><i class="fas fa-university"></i></span>

              <div class="info-box-content">
                <h3  class="info-box-text">Amount</h3>
                <h3 id = "sumAmount" class="info-box-number">0</h3>
              </div>
            </div>
          </div>
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box shadow">
              <span class="info-box-icon bg-danger"><i class="fas fa-chart-line"></i></span>

              <div class="info-box-content">
                <h3  class="info-box-text">Final Customers</h3>
                <h3 id = "finalCus" class="info-box-number">0</h3>
              </div>
            </div>
          </div>
        </div>
        </div>
        <div class="col-md-12 col-sm-12 col-12" style=" margin-top: 10px;">
        <div class="card card-success sombra2">
              <div class="card-header" >
                <span id="tituloChart" class="justify-content-center" style="font-size:18px; color:white;">Visual Data</span>
              </div>
              <div class="card-body" style="background-color: #56d6ab;">
              <div id="boxType" class ="container" style="position: absolute; z-index: 10; margin-top: -18px;">
              <div class="float-left sombra btn-group btn-group-toggle btn-group-lg" data-toggle="buttons"><label id="labelBar" class="btn btn-secondary active focus" style="background: #6658dd;"><input type="radio" name="TypeCh" id="chartTypeBar" value = "Tbar" checked onchange="chartFilters(6)"><i class="fa fa-bar-chart" style="font-size:24px;color:white"></i></label>
              <label id="labelArea" class="btn btn-secondary" style="background: #6658dd;"><input type="radio" name="TypeCh" id="chartTypeArea" value = "Tarea" onchange="chartFilters(7)"><i class="fa fa-area-chart" style="font-size:24px;color:white"></i></label>
              <label class="btn btn-secondary" id="labelLine" style="background: #6658dd;"><input type="radio" name="TypeCh" id="chartTypeLine" value = "Tline" onchange="chartFilters(8)"><i class="fa fa-line-chart" style="font-size:24px;color:white"></i></label>
              </div>
              </div>
              <div id="container2" style="min-width: 310px; height: 400px; margin: 0 auto;"></div>
            </div>
            <div class="card-footer" style="background-color: #56d6ab;">
            </div>
        </div>
        </div>
        </div>    
        </div>           
        </center>
    </body>
<script>
function chartFilters(x){
var chart_date = $("#chart_date_range").val();
var chart_filtMerc = $("#AlMerchant2").val();
var chart_channel = $("#chart_channel").val();
var chart_transaction = $("#chart_transaction").val();
var chart_status = $("#chart_status").val();
var chart_currency = $("#currency_code2").val();
var chart_country = $("#country_filt2").val();
var chart_env = $("#chart_env").val();
var resTypeChart = $('input:radio[name=TypeCh]:checked').val();
if(($("#AlMerchant2").val()==1) || ($("#AlMerchant2").val()==2)){
          $("#chart_status").val("1");
          $("#chart_status").prop('disabled', true);  
          }else {
            $("#chart_status").prop('disabled', false);
          }   
          var chart_status = $("#chart_status").val();
          $.post("internal/response.php", {data_typChart: resTypeChart, data_dateRage: chart_date, data_filt_merch: chart_filtMerc, data_channel: chart_channel, data_transaction: chart_transaction, data_statu: chart_status, data_currency:chart_currency, data_country:chart_country, data_env:chart_env}, function(mensaje){
            const chart = eval(mensaje); 
         //alert(mensaje);
       });
}
$(document).ready(function(){      
$.post("internal/response.php", {ChartMerchantFilter: 1}, function(mensaje2) {$('#AlMerchant').html(mensaje2);});
$.post("internal/response.php", {ChartCurrencyCodeFilter: 1}, function(mensaje3) {$('#currency_code').html(mensaje3);});
$.post("internal/response.php", {ChartCountryFilter: 1}, function(mensaje7) {$('#country_filt').html(mensaje7);});
$.post("internal/response.php", {data_typChart: 'Tbar', data_dateRage: '0', data_filt_merch: '1', data_channel: '0', data_transaction: '0', data_statu: 'all_status', data_currency:'USD', data_country:'0', data_env:"1"}, function(mensaje5){
          const chartinic = eval(mensaje5); 
         //alert(mensaje5);
       });       
});
</script>
</html>