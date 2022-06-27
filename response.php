<?php
	include_once("conf.php");
  // --------------------------------------
  session_start();

  // declaración de funciones ------------- 	

      
    if(isset($_POST['ChartMerchantFilter'])){ 
      if($_SESSION['profileid']<=3) { 
        $filtro_chart="<select id='AlMerchant2' class='form-control sombra2' onchange='chartFilters(2)'>
                   <option value='1' selected> (+) productive </option>
                   <option value='2'> (-) productive </option>";
        $conn = mysqli_connect(DB_HOST,DB_USUARIO,DB_CLAVE,DB_NOMBRE);
        mysqli_set_charset($conn, "utf8");
        $sql_chart_mer="select id_merchant from merchant where id_merchant!='M---------' and status!=0"; 
        $consulta_chart_mer=$conn->query($sql_chart_mer);
        mysqli_close($conn); 
        while($reg_filMer=mysqli_fetch_assoc($consulta_chart_mer)){ 
          $filtro_chart.="<option value='".$reg_filMer['id_merchant']."'> ".$reg_filMer['id_merchant']." </option>";
          }$filtro_chart.="</select>";
      } if($_SESSION['profileid']>=4) { $filtro_chart="<input type='text' id='AlMerchant' class='form-control sombra2' value='".$_SESSION['merchantid']."' disabled> "; } 
      echo $filtro_chart;
    }

    if(isset($_POST['ChartCurrencyCodeFilter'])){ 
        $filtro_currency="<select id='currency_code2' class='form-control sombra2' onchange='chartFilters(6)'>";
        $conn = mysqli_connect(DB_HOST,DB_USUARIO,DB_CLAVE,DB_NOMBRE);
        mysqli_set_charset($conn, "utf8");
        $sql_currency="select distinct currency_code from transaction"; 
        $consulta_currency=$conn->query($sql_currency);
        mysqli_close($conn); 
        while($reg_filcurrency=mysqli_fetch_assoc($consulta_currency)){ 
          $filtro_currency.="<option value='".$reg_filcurrency['currency_code']."'> ".$reg_filcurrency['currency_code']." </option>";
          }$filtro_currency.="</select>";
      echo $filtro_currency;
    }

    if(isset($_POST['ChartCountryFilter'])){ 
      $filtro_country="<select id='country_filt2' class='form-control sombra2' onchange='chartFilters(7)'><option value='0' selected> All countries </option>";
      $conn = mysqli_connect(DB_HOST,DB_USUARIO,DB_CLAVE,DB_NOMBRE);
      mysqli_set_charset($conn, "utf8");
      $sql_country="SELECT * FROM country"; 
      $consulta_country=$conn->query($sql_country);
      mysqli_close($conn); 
      while($reg_filcountry=mysqli_fetch_assoc($consulta_country)){ 
        $filtro_country.="<option value='".$reg_filcountry['id']."'> ".$reg_filcountry['iso3']." </option>";
        }$filtro_country.="</select>";
    echo $filtro_country;
  }    

    if(isset($_POST['data_dateRage'])){
   
          $p_dateRange = $_POST['data_dateRage'];
          $p_merchId = $_POST['data_filt_merch'];
          $p_channel = $_POST['data_channel'];
          $p_transac = $_POST['data_transaction'];
          $p_statu = $_POST['data_statu'];
          $p_currency = $_POST['data_currency'];
          $p_env = $_POST['data_env'];
          $country = $_POST['data_country'];
          $p_tipCh = $_POST['data_typChart'];
          $countryQry="";
          $typeChart="";
          $dateFrom=substr($p_dateRange, 0,10 );
          $dateTo=substr($p_dateRange, 13 );
          if ($_POST['data_dateRage']==='0'){$dateFrom = date("Y-m-d"); $dateTo = date("Y-m-d");}
          $resAmount = array();
          $resUid = array();
          $resIdMerch = array();
          $resClient = array();
          $resStatus = array();
          $Total_transact = array();
          $mer=array();
          $stPie1=array();
          $stPie2=array();
          $stReson1=array();
          $stReson2=array();
          $responsStatus ="";
          $responsUid ="";
          $Tol_transact=0;
          $Tol_amount=0;
          $Tol_final_cust=0;
          $can_xStatus=0;
          $porc_transac_tot=0;
          $text_tit="";
          $tit_poc="";
          $p_statu2 ="";
          $respuesta_Chart="";
          $tituAdmin="";
          $tit_country="All Countries";
          $p_channelX="";
          $orByDes="";
          $orByAsc="";
          $query_date = "date BETWEEN '".$dateFrom."' AND '".$dateTo."'";
          if($country=='0'){$countryQry="";}else if($country!=='0'){$countryQry="country= $country AND";}
          switch (true) {
            case ($p_channel==0)&&($p_transac==0):
              $p_channelX = "AND (uid LIKE 'CAS%' OR uid LIKE 'BAN%' OR uid LIKE 'CAR%' OR uid LIKE 'PAY%' OR uid LIKE 'REF%' )";
              $responsUid =" (IN) & (OUT)";
              break;
            case ($p_channel==0)&&($p_transac==1):
              $p_channelX = "AND (uid LIKE 'CAS%' OR uid LIKE 'BAN%' OR uid LIKE 'CAR%')";
              $responsUid =" (IN)";
              break;
            case ($p_channel==0)&&($p_transac==2):
              $p_channelX = "AND (uid LIKE 'PAY%' OR uid LIKE 'REF%')";
              $responsUid =" (OUT)";
            break;
            case ($p_channel==1)&&($p_transac==0):
              $p_channelX = "AND (uid LIKE 'CAS%')";
              $responsUid =" CASH (IN)";
              break;
            case ($p_channel==1)&&($p_transac==1):
              $p_channelX = "AND (uid LIKE 'CAS%')";
              $responsUid =" CASH (IN)";
              break;
            case ($p_channel==1)&&($p_transac==2):
              $p_channelX = "AND (uid LIKE 'CSO%')";
              $responsUid =" (OUT)";
              break;
            case ($p_channel==2)&&($p_transac==0):
              $p_channelX = "AND (uid LIKE 'BAN%' OR uid LIKE 'PAY%')";
              $responsUid =" BANK (IN) & (OUT)";
              break;
            case ($p_channel==2)&&($p_transac==1):
              $p_channelX = "AND (uid LIKE 'BAN%')";
              $responsUid =" BANK (IN)";
               break;
            case ($p_channel==2)&&($p_transac==2):
            $p_channelX = "AND (uid LIKE 'PAY%')";
            $responsUid =" BANK (OUT)";
            break;     
            case ($p_channel==3)&&($p_transac==0):
              $p_channelX = "AND (uid LIKE 'CAR%' OR uid LIKE 'REF%')";
              $responsUid =" CARD (IN) & (OUT)";
            break;
            case ($p_channel==3)&&($p_transac==1):
              $p_channelX = "AND (uid LIKE 'CAR%')";
              $responsUid =" CARD (IN)";
            break;
            case ($p_channel==3)&&($p_transac==2):
              $p_channelX = "AND (uid LIKE 'REF%')";
              $responsUid =" CARD (OUT)";
            break;  
          }    
           switch ($p_statu) {
            case "all_status":
              $p_statu = "AND ".$query_date." GROUP BY SUBSTRING(uid, 1,3), fech";
              $p_statu2 = "AND ".$query_date."GROUP BY id_merchant";
              $p_statu3 = "AND ".$query_date."GROUP BY final_client";
              $responsStatus =" All Status";
              $tit_poc="%".$responsStatus." Trx";
              break; 
            case 0:
              $p_statu = "AND status = 0 AND ".$query_date." GROUP BY SUBSTRING(uid, 1,3), status, fech";
              $p_statu2 = "AND status = 0 AND ".$query_date."GROUP BY id_merchant";
              $p_statu3 = "AND status = 0 AND ".$query_date."GROUP BY final_client";
              $responsStatus =" Cancelled";
              $tit_poc="%".$responsStatus." Trx";
              break;  
            case 1:
              $p_statu = "AND status = 1 AND ".$query_date." GROUP BY SUBSTRING(uid, 1,3), status, fech";
              $p_statu2 = "AND status = 1 AND ".$query_date."GROUP BY id_merchant";
              $p_statu3 = "AND status = 1 AND ".$query_date."GROUP BY final_client";
              $responsStatus =" Approved";
              $tit_poc="%".$responsStatus." Trx";
              break;
            case 2:
              $p_statu = "AND status = 2 AND ".$query_date." GROUP BY SUBSTRING(uid, 1,3), status, fech";
              $p_statu2 = "AND  status = 2 AND ".$query_date."GROUP BY id_merchant";
              $p_statu3 = "AND  status = 2 AND ".$query_date."GROUP BY final_client";
              $responsStatus =" Declined";
              $tit_poc="%".$responsStatus." Trx";
              break;   
           case 3:
            $p_statu = "AND  status = 3 AND ".$query_date." GROUP BY SUBSTRING(uid, 1,3), status, fech";
            $p_statu2 = "AND  status = 3 AND ".$query_date."GROUP BY id_merchant";
            $p_statu3 = "AND  status = 3 AND ".$query_date."GROUP BY final_client";
            $responsStatus =" Pendding";
            $tit_poc="%".$responsStatus." Trx";
              break;
           case 4:
            $p_statu = "AND  status = 4 AND ".$query_date." GROUP BY SUBSTRING(uid, 1,3), status, fech";
            $p_statu2 = "AND  status = 4 AND ".$query_date."GROUP BY id_merchant";
            $p_statu3 = "AND  status = 4 AND ".$query_date."GROUP BY final_client";
            $responsStatus =" Paid";
            $tit_poc="%".$responsStatus." Trx";
              break;
           case 5:
            $p_statu = "AND  status = 5 AND ".$query_date." GROUP BY SUBSTRING(uid, 1,3), status, fech";
            $p_statu2 = "AND  status = 5 AND ".$query_date."GROUP BY id_merchant";
            $p_statu3 = "AND  status = 5 AND ".$query_date."GROUP BY final_client";
            $responsStatus =" Unpaid";
            $tit_poc="%".$responsStatus." Trx";
              break;
          case 6:
            $responsStatus =" Approved Vs Decline";
              break;
          case 7:
            $responsStatus =" Decline / Reason";
              break;
            }
      $conn = mysqli_connect(DB_HOST,DB_USUARIO,DB_CLAVE,DB_NOMBRE);
      mysqli_set_charset($conn, "utf8");   
      if($_SESSION['profileid']>=4) { 
          $startSql ="SELECT SUBSTRING(date, 6,10) as fech, SUBSTRING(uid, 1,3) as cateNombre, SUBSTRING(status, 1,1) as stat , SUM(amount) AS amount_sum FROM transaction WHERE $countryQry env = ".$p_env." AND currency_code = '".$p_currency."' AND id_merchant = '".$_SESSION['merchantid']."'";
          $startSql2 ="SELECT SUBSTRING(date, 6,10) as fech, SUBSTRING(uid, 1,3) as cateNombre, SUM(amount) AS amount_sum FROM transaction WHERE $countryQry env = ".$p_env." AND currency_code = '".$p_currency."' AND id_merchant = '".$_SESSION['merchantid']."'";
          if($p_statu!=6 || $p_statu!=7){
          if ($p_channelX != "" AND ($p_statu==0 || $p_statu==1 || $p_statu==2 || $p_statu==3 || $p_statu==4 || $p_statu==5)) {$sql = $startSql." ".$p_channelX." ".$p_statu;}
          if ($p_channelX != "" AND $p_statu=='all_status') {$sql = $startSql2." ".$p_channelX." ".$p_statu;}
          $sql_cal_transac = "SELECT DISTINCT COUNT(uid) as total_transac FROM transaction  WHERE $countryQry env = ".$p_env." AND currency_code = '".$p_currency."' AND id_merchant = '".$_SESSION['merchantid']."' AND ".$query_date;
          $sql_cantStatus = "SELECT COUNT(status) as total_thisStatus FROM transaction  WHERE $countryQry env = ".$p_env." AND currency_code = '".$p_currency."' AND id_merchant = '".$_SESSION['merchantid']."' ".$p_channelX." ".$p_statu2;
          $sql_cal_client = "SELECT DISTINCT final_client, COUNT(final_client) as final_cust FROM transaction  WHERE $countryQry env = ".$p_env." AND currency_code = '".$p_currency."' AND id_merchant = '".$_SESSION['merchantid']."' ".$p_channelX." ".$p_statu3;
          $sql_cantStatus = "SELECT COUNT(status) as total_thisStatus FROM transaction  WHERE $countryQry env = ".$p_env." AND currency_code = '".$p_currency."' AND id_merchant = '".$_SESSION['merchantid']."' AND status =1 AND ".$query_date;
          if($p_tipCh=="Tbar"){$typeChart="column";}}
          if ($p_channelX != "" AND $p_statu==6) {$sql_st1 ="SELECT COUNT(status) as sta FROM transaction WHERE $countryQry env = ".$p_env." AND currency_code = '".$p_currency."' AND id_merchant = '".$_SESSION['merchantid']."' ".$p_channelX." AND status = 1 AND ".$query_date; $sql_st2 ="SELECT COUNT(status) as sta FROM transaction WHERE $countryQry env = ".$p_env." AND currency_code = '".$p_currency."' AND id_merchant = '".$_SESSION['merchantid']."' ".$p_channelX." AND status = 2 AND ".$query_date;
              $consultaSt1=$conn->query($sql_st1); $consultaSt2=$conn->query($sql_st2);
              while($regS=mysqli_fetch_assoc($consultaSt1)){ $stPie1[]=$regS["sta"];} while($regS2=mysqli_fetch_assoc($consultaSt2)){ $stPie2[]=$regS2["sta"];}}
          if ($p_channelX != "" AND $p_statu==7) {$sql_st1 ="SELECT COUNT(status) as sta, response FROM transaction WHERE $countryQry env = ".$p_env." AND currency_code = '".$p_currency."' AND id_merchant = '".$_SESSION['merchantid']."' ".$p_channelX." AND status = 2 AND ".$query_date." GROUP BY response";
            $consultaSt1=$conn->query($sql_st1); while($regS=mysqli_fetch_assoc($consultaSt1)){ $stReson1[]=$regS["sta"]; $stReson2[]=$regS["response"];}}       
        }  
      if($_SESSION['profileid']<=3) { 
          $startSql_admin = "SELECT  SUBSTRING(date, 6,10) as fech, SUBSTRING(id_merchant, 1,10) as cateNombreMarch, SUM(amount) AS amount_sum, (SELECT DISTINCT COUNT(uid) as total_transac FROM transaction WHERE $countryQry id_merchant=cateNombreMarch AND env = ".$p_env." AND currency_code = '".$p_currency."' AND status=1 AND ".$query_date.") as cant_transac FROM transaction WHERE $countryQry env = ".$p_env." AND currency_code = '".$p_currency."' AND status=1";
          $startSql_admin2 = "SELECT  SUBSTRING(date, 6,10) as fech, SUBSTRING(uid, 1,3) AS cateNombre, SUBSTRING(id_merchant, 1,10) as cateNombreMarch, SUM(amount) AS amount_sum, (SELECT DISTINCT COUNT(uid) as total_transac FROM transaction WHERE $countryQry cateNombre=SUBSTRING(uid, 1,3) AND id_merchant= cateNombreMarch AND env = ".$p_env." AND currency_code = '".$p_currency."' AND status=1 AND ".$query_date.") as cant_transac FROM transaction WHERE $countryQry env = ".$p_env." AND currency_code = '".$p_currency."' AND status=1";
          $startSql ="SELECT SUBSTRING(date, 6,10) as fech, SUBSTRING(uid, 1,3) as cateNombre, SUBSTRING(status, 1,1) as stat , SUM(amount) AS amount_sum FROM transaction WHERE $countryQry env = ".$p_env." AND currency_code = '".$p_currency."' AND id_merchant = '".$p_merchId."'";
          $startSql2 ="SELECT SUBSTRING(date, 6,10) as fech, SUBSTRING(uid, 1,3) as cateNombre, SUM(amount) AS amount_sum FROM transaction WHERE $countryQry env = ".$p_env." AND currency_code = '".$p_currency."' AND id_merchant = '".$p_merchId."'";
          $orByDes="ORDER BY amount_sum DESC LIMIT 10";
          $orByAsc="ORDER BY amount_sum ASC LIMIT 10";
          $end_sql_admin1 = "  GROUP BY id_merchant, fech ".$orByDes;
          $end_sql_admin2 = "  GROUP BY id_merchant, fech ".$orByAsc;
          $end_sql_admin12 = "  GROUP BY SUBSTRING(uid, 1,3), id_merchant, fech ".$orByDes;
          $end_sql_admin22 = "  GROUP BY SUBSTRING(uid, 1,3), id_merchant, fech ".$orByAsc;
          if(($p_merchId!='1' || $p_merchId!='2' )){
          if ($p_channelX != "" AND $p_statu!=='all_status') {$sql = $startSql." ".$p_channelX." ".$p_statu;}
          if ($p_channelX != "" AND $p_statu=='all_status') {$sql = $startSql2." ".$p_channelX." ".$p_statu;}
          $sql_cal_transac = "SELECT DISTINCT COUNT(uid) as total_transac FROM transaction  WHERE $countryQry env = ".$p_env." AND currency_code = '".$p_currency."' AND id_merchant = '".$p_merchId."' AND ".$query_date;
          $sql_cantStatus = "SELECT COUNT(status) as total_thisStatus FROM transaction  WHERE $countryQry env = ".$p_env." AND currency_code = '".$p_currency."' AND id_merchant = '".$p_merchId."' ".$p_channelX." ".$p_statu2;
          $sql_cal_client = "SELECT DISTINCT final_client, COUNT(final_client) as final_cust FROM transaction  WHERE $countryQry env = ".$p_env." AND currency_code = '".$p_currency."' AND id_merchant = '".$p_merchId."' ".$p_channelX." ".$p_statu3;
          if($p_tipCh=="Tbar"){$typeChart="column";}
          $tituAdmin=" / ".$p_merchId;
          if ($p_channelX != "" AND $p_statu==6) {$sql_st1 ="SELECT COUNT(status) as sta FROM transaction WHERE $countryQry env = ".$p_env." AND currency_code = '".$p_currency."' AND id_merchant = '".$p_merchId."' ".$p_channelX." AND status = 1 AND ".$query_date; $sql_st2 ="SELECT COUNT(status) as sta FROM transaction WHERE $countryQry env = ".$p_env." AND currency_code = '".$p_currency."' AND id_merchant = '".$p_merchId."' ".$p_channelX." AND status = 2 AND ".$query_date;
            $consultaSt1=$conn->query($sql_st1); $consultaSt2=$conn->query($sql_st2);
            while($regS=mysqli_fetch_assoc($consultaSt1)){ $stPie1[]=$regS["sta"];} while($regS2=mysqli_fetch_assoc($consultaSt2)){ $stPie2[]=$regS2["sta"];}}
          if ($p_channelX != "" AND $p_statu==7) {$sql_st1 ="SELECT COUNT(status) as sta, response FROM transaction WHERE $countryQry env = ".$p_env." AND currency_code = '".$p_currency."' AND id_merchant = '".$p_merchId."' ".$p_channelX." AND status = 2 AND ".$query_date." GROUP BY response";
            $consultaSt1=$conn->query($sql_st1); while($regS=mysqli_fetch_assoc($consultaSt1)){ $stReson1[]=$regS["sta"]; $stReson2[]=$regS["response"];}} 
        } 

        if ($p_merchId=='1' || $p_merchId=='2') { 
          $startSql_admin12 = "SELECT  SUBSTRING(date, 6,10) as fech, SUBSTRING(id_merchant, 1,10) as cateNombreMarch, round(SUM((amount + (amount * fee_percent) + (amount * spread_percent))),2) AS amount_sum, (SELECT DISTINCT COUNT(uid) as total_transac FROM transaction WHERE $countryQry id_merchant=cateNombreMarch AND env = ".$p_env." AND currency_code = '".$p_currency."' AND status=1 AND ".$query_date.") as cant_transac FROM transaction WHERE $countryQry env = ".$p_env." AND currency_code = '".$p_currency."' AND status=1";
          $startSql_admin22 = "SELECT  SUBSTRING(date, 6,10) as fech, SUBSTRING(uid, 1,3) AS cateNombre, SUBSTRING(id_merchant, 1,10) as cateNombreMarch, round(SUM((amount + (amount * fee_percent) + (amount * spread_percent))),2) AS amount_sum, (SELECT DISTINCT COUNT(uid) as total_transac FROM transaction WHERE $countryQry cateNombre=SUBSTRING(uid, 1,3) AND id_merchant= cateNombreMarch AND env = ".$p_env." AND currency_code = '".$p_currency."' AND status=1 AND ".$query_date.") as cant_transac FROM transaction WHERE $countryQry env = ".$p_env." AND currency_code = '".$p_currency."' AND status=1";
          $start_sqlAmount="SELECT DISTINCT final_client, COUNT(final_client) as final_cust FROM transaction  WHERE $countryQry env = ".$p_env." AND";
          $end_sqlAmountDes="GROUP BY final_client DESC LIMIT 10";
          $end_sqlAmountAsc="GROUP BY final_client ASC LIMIT 10";
        if($p_merchId=='1' && $p_channel==0 && $p_transac==0){$sql_admin1 = $startSql_admin12." AND ".$query_date. " ".$end_sql_admin1; $sql_cal_client = $start_sqlAmount." currency_code = '".$p_currency."' AND status =1 AND ".$query_date." ".$end_sqlAmountDes; $tituAdmin=" / The 10 Most Productive "; $consul_menMas=$conn->query($sql_admin1);}else
        if($p_merchId=='2' && $p_channel==0 && $p_transac==0){$sql_admin2 = $startSql_admin12." AND ".$query_date. " ".$end_sql_admin2; $sql_cal_client = $start_sqlAmount." currency_code = '".$p_currency."' AND status =1 AND ".$query_date." ".$end_sqlAmountAsc; $tituAdmin=" / The 10 Least Productive "; $consul_menMas=$conn->query($sql_admin2);}else
        if($p_merchId=='1' && $p_channel && $p_transac){$sql_admin1 = $startSql_admin22." ".$p_channelX." AND ".$query_date. " ".$end_sql_admin12; $sql_cal_client = $start_sqlAmount." currency_code = '".$p_currency."' ".$p_channelX." AND status =1 AND ".$query_date." ".$end_sqlAmountDes; $tituAdmin=" / The 10 Most Productive "; $consul_menMas=$conn->query($sql_admin1);}else
        if($p_merchId=='1' && $p_channel==0 && $p_transac==1){$sql_admin1 = $startSql_admin22." ".$p_channelX." AND ".$query_date. " ".$end_sql_admin12; $sql_cal_client = $start_sqlAmount." currency_code = '".$p_currency."' ".$p_channelX." AND status =1 AND ".$query_date." ".$end_sqlAmountDes; $tituAdmin=" / The 10 Most Productive "; $consul_menMas=$conn->query($sql_admin1);}else
        if($p_merchId=='1' && $p_channel==0 && $p_transac==2){$sql_admin1 = $startSql_admin22." ".$p_channelX." AND ".$query_date. " ".$end_sql_admin12; $sql_cal_client = $start_sqlAmount." currency_code = '".$p_currency."' ".$p_channelX." AND status =1 AND ".$query_date." ".$end_sqlAmountDes; $tituAdmin=" / The 10 Most Productive "; $consul_menMas=$conn->query($sql_admin1);}else
        if($p_merchId=='1' && $p_channel==1 && $p_transac==0){$sql_admin1 = $startSql_admin22." ".$p_channelX." AND ".$query_date. " ".$end_sql_admin12; $sql_cal_client = $start_sqlAmount." currency_code = '".$p_currency."' ".$p_channelX." AND status =1 AND ".$query_date." ".$end_sqlAmountDes; $tituAdmin=" / The 10 Most Productive "; $consul_menMas=$conn->query($sql_admin1);}else
        if($p_merchId=='1' && $p_channel==2 && $p_transac==0){$sql_admin1 = $startSql_admin22." ".$p_channelX." AND ".$query_date. " ".$end_sql_admin12; $sql_cal_client = $start_sqlAmount." currency_code = '".$p_currency."' ".$p_channelX." AND status =1 AND ".$query_date." ".$end_sqlAmountDes; $tituAdmin=" / The 10 Most Productive "; $consul_menMas=$conn->query($sql_admin1);}else
        if($p_merchId=='1' && $p_channel==3 && $p_transac==0){$sql_admin1 = $startSql_admin22." ".$p_channelX." AND ".$query_date. " ".$end_sql_admin12; $sql_cal_client = $start_sqlAmount." currency_code = '".$p_currency."' ".$p_channelX." AND status =1 AND ".$query_date." ".$end_sqlAmountDes; $tituAdmin=" / The 10 Most Productive "; $consul_menMas=$conn->query($sql_admin1);}    
        if($p_merchId=='2' && $p_channel==0 && $p_transac==1){$sql_admin2 = $startSql_admin22." ".$p_channelX." AND ".$query_date. " ".$end_sql_admin22; $sql_cal_client = $start_sqlAmount." currency_code = '".$p_currency."' ".$p_channelX." AND status =1 AND ".$query_date." ".$end_sqlAmountAsc; $tituAdmin=" / The 10 Least Productive "; $consul_menMas=$conn->query($sql_admin2);}else
        if($p_merchId=='2' && $p_channel==0 && $p_transac==2){$sql_admin2 = $startSql_admin22." ".$p_channelX." AND ".$query_date. " ".$end_sql_admin22; $sql_cal_client = $start_sqlAmount." currency_code = '".$p_currency."' ".$p_channelX." AND status =1 AND ".$query_date." ".$end_sqlAmountAsc; $tituAdmin=" / The 10 Least Productive "; $consul_menMas=$conn->query($sql_admin2);}else
        if($p_merchId=='2' && $p_channel && $p_transac){$sql_admin2 = $startSql_admin22." ".$p_channelX." AND ".$query_date. " ".$end_sql_admin22; $sql_cal_client = $start_sqlAmount." currency_code = '".$p_currency."' ".$p_channelX." AND status =1 AND ".$query_date." ".$end_sqlAmountAsc; $tituAdmin=" / The 10 Least Productive "; $consul_menMas=$conn->query($sql_admin2);}else
        if($p_merchId=='2' && $p_channel==1 && $p_transac==0){$sql_admin2 = $startSql_admin22." ".$p_channelX." AND ".$query_date. " ".$end_sql_admin22; $sql_cal_client = $start_sqlAmount." currency_code = '".$p_currency."' ".$p_channelX." AND status =1 AND ".$query_date." ".$end_sqlAmountAsc; $tituAdmin=" / The 10 Least Productive "; $consul_menMas=$conn->query($sql_admin2);}else
        if($p_merchId=='2' && $p_channel==2 && $p_transac==0){$sql_admin2 = $startSql_admin22." ".$p_channelX." AND ".$query_date. " ".$end_sql_admin22; $sql_cal_client = $start_sqlAmount." currency_code = '".$p_currency."' ".$p_channelX." AND status =1 AND ".$query_date." ".$end_sqlAmountAsc; $tituAdmin=" / The 10 Least Productive "; $consul_menMas=$conn->query($sql_admin2);}else
        if($p_merchId=='2' && $p_channel==3 && $p_transac==0){$sql_admin2 = $startSql_admin22." ".$p_channelX." AND ".$query_date. " ".$end_sql_admin22; $sql_cal_client = $start_sqlAmount." currency_code = '".$p_currency."' ".$p_channelX." AND status =1 AND ".$query_date." ".$end_sqlAmountAsc; $tituAdmin=" / The 10 Least Productive "; $consul_menMas=$conn->query($sql_admin2);}  
        while($reg_admin1=mysqli_fetch_assoc($consul_menMas)){ $resUid[]=$reg_admin1["cateNombre"]." - ".$reg_admin1["cateNombreMarch"]." - ".$reg_admin1["fech"]; $resAmount[]=$reg_admin1["amount_sum"]; $Total_transact[]=$reg_admin1["cant_transac"]."-".$reg_admin1["cateNombreMarch"]; $mer[]=$reg_admin1["cateNombreMarch"];}
        $sql_cal_transac = "SELECT DISTINCT COUNT(uid) as total_transac FROM transaction  WHERE $countryQry env = ".$p_env." AND currency_code = '".$p_currency."' AND ".$query_date;
        $sql_cantStatus = "SELECT COUNT(status) as total_thisStatus FROM transaction  WHERE $countryQry env = ".$p_env." AND currency_code = '".$p_currency."' AND status =1 AND ".$query_date;
        $Tol_amount= array_sum($resAmount);
        $unicos = array_unique($Total_transact);
        $Tol_transact= array_sum($unicos);  
        if($p_tipCh=="Tbar"){$typeChart="bar";}
        
        if ($p_channelX != "" AND $p_statu==6) {$sql_st1 ="SELECT COUNT(status) as sta FROM transaction WHERE $countryQry env = ".$p_env." AND currency_code = '".$p_currency."' ".$p_channelX." AND status = 1 AND ".$query_date; $sql_st2 ="SELECT COUNT(status) as sta FROM transaction WHERE $countryQry env = ".$p_env." AND currency_code = '".$p_currency."' AND id_merchant = '".$p_merchId."' ".$p_channelX." AND status = 2 AND ".$query_date;
          $consultaSt1=$conn->query($sql_st1); $consultaSt2=$conn->query($sql_st2);
          while($regS=mysqli_fetch_assoc($consultaSt1)){ $stPie1[]=$regS["sta"];} while($regS2=mysqli_fetch_assoc($consultaSt2)){ $stPie2[]=$regS2["sta"];}}
        if ($p_channelX != "" AND $p_statu==7) {$sql_st1 ="SELECT COUNT(status) as sta, response FROM transaction WHERE $countryQry env = ".$p_env." AND currency_code = '".$p_currency."'  ".$p_channelX." AND status = 2 AND ".$query_date." GROUP BY response";
          $consultaSt1=$conn->query($sql_st1); while($regS=mysqli_fetch_assoc($consultaSt1)){ $stReson1[]=$regS["sta"]; $stReson2[]=$regS["response"];}}
      }
    }
    $consulta=$conn->query($sql);
    $consulta_cal_transac=$conn->query($sql_cal_transac);
    $consulta_cal_cli=$conn->query($sql_cal_client);
    $Tol_final_cust=mysqli_num_rows($consulta_cal_cli);
    if($country!=='0'){$sql_country2="SELECT * FROM country WHERE id=".$country; $consul_country=$conn->query($sql_country2);
      while($reg_nameCountry=mysqli_fetch_assoc($consul_country)){ 
        $tit_country=$reg_nameCountry['iso3'];
        }
    }
    $consulta_cal_porc=$conn->query($sql_cantStatus);
    while($reg=mysqli_fetch_assoc($consulta)){$resUid[]=$reg["cateNombre"]."<br>".$reg["fech"]; $resAmount[]=$reg["amount_sum"];$resStatus[]=$reg["status"];$Tol_amount= array_sum($resAmount);}
    while($reg_cal=mysqli_fetch_assoc($consulta_cal_transac)){ $Tol_transact=$reg_cal["total_transac"];} 
    while($reg_cal_ap=mysqli_fetch_assoc($consulta_cal_porc)){ $can_xStatus = $reg_cal_ap["total_thisStatus"];}
    $exceptions = array(
      "CAS"  => "CASH (In)", 
      "CAR" => "CARD (In)",
      "BAN" => "BANK (In)",
      "PAY" => "BANK (Out)",
      "REF" => "CARD (Out)");
    $uid_conver = str_replace(array_keys($exceptions), $exceptions, $resUid); 
    $porc_transac_tot = round((100 * $can_xStatus)/$Tol_transact).'%';
    if(empty($resAmount)){$text_tit = "Ooooops... nothing to see here ....";}else{$text_tit ="Trx".$responsStatus." /".$responsUid.$tituAdmin." / ".$p_currency." / ".$tit_country;} 
      $respuesta_Chart="new Highcharts.Chart({
        chart: {
        renderTo: 'container2',
        type: '".$typeChart."',
        options3d: {
        enabled: true,
        alpha: 15,
        beta: 15,
        depth: 50,
        viewDistance: 25,  
      }
      },
      title: {
        text: '".$text_tit."',
        style: {
          color: 'black'
          }        
      },
      credits: {
        enabled: false
    },
      plotOptions: {
        series: {
          depth: 25,
          colorByPoint: true
        }
      },
      xAxis: {
        categories: ".json_encode($uid_conver)."
      },
      series: [{
        data: ".json_encode($resAmount, JSON_NUMERIC_CHECK ).",
        name: 'Transaction',
        showInLegend: false
      }]
    });
    var respPorcTot=".json_encode($porc_transac_tot, JSON_NUMERIC_CHECK ).";
    if(respPorcTot == 'NAN%'){respPorcTot='0%';} 
    if(respPorcTot == 'INF%'){respPorcTot='0%';} 
    $('#toTransac').html(".json_encode($Tol_transact, JSON_NUMERIC_CHECK ).");
    $('#sumAmount').html(".json_encode("USD ".$Tol_amount, JSON_NUMERIC_CHECK ).");
    $('#finalCus').html(".json_encode($Tol_final_cust, JSON_NUMERIC_CHECK ).");
    $('#porcent').html(respPorcTot);
    $('#tituloChart').html('".$text_tit."');
    $('#tit_poc').html('".$tit_poc."');
    $('#tarjetas').css('display', 'block');
    $('#boxType').css('display', 'block');";
    
    $respuesta_Chart2="new Highcharts.Chart({
      chart: {
      renderTo: 'container2',
      type: 'areaspline'
        },
        title: {
            text: '".$text_tit."',
            style: {
              color: 'black'
              } 
        },
        xAxis: {
            categories: ".json_encode($uid_conver).",
            plotBands: [{ 
                from: 4.5,
                to: 6.5,
                color: 'rgba(68, 170, 213, .2)'
            }]
        },
        yAxis: {
            title: {
                text: 'Amount'         
            }
        },
        tooltip: {
            shared: true,
            valueSuffix: ' units'
        },
        credits: {
            enabled: false
        },
        plotOptions: {
            areaspline: {
                fillOpacity: 0.5
            }
        },
        series: [{
          name:'Transaction',
          color: 'rgb(255, 242, 99)',
          data: ".json_encode($resAmount, JSON_NUMERIC_CHECK )."
        }]
    });
    var respPorcTot=".json_encode($porc_transac_tot, JSON_NUMERIC_CHECK ).";
    if(respPorcTot == 'NAN%'){respPorcTot='0%';} 
    $('#toTransac').html(".json_encode($Tol_transact, JSON_NUMERIC_CHECK ).");
    $('#sumAmount').html(".json_encode("USD ".$Tol_amount, JSON_NUMERIC_CHECK ).");
    $('#finalCus').html(".json_encode($Tol_final_cust, JSON_NUMERIC_CHECK ).");
    $('#porcent').html(respPorcTot);
    $('#tituloChart').html('".$text_tit."');
    $('#tarjetas').css('display', 'block');
    $('#boxType').css('display', 'block');";
    
    $respuesta_Chart3="new Highcharts.Chart({
      chart: {
      renderTo: 'container2',
      zoomType: 'xy'
        },
        title: {
            text: '".$text_tit."',
            style: {
              color: 'black'
              } 
        },
        xAxis: [{
            categories: ".json_encode($uid_conver).",  
        }],
        yAxis: [{ // Primary yAxis
            labels: {
                format: '',
            },
            title: {
                text: 'Amount',   
            }
        }, { // Secondary yAxis
            title: {
                text: '',   
            },
            labels: {
                format: '', 
            },
            opposite: true
        }],
        tooltip: {
            shared: true
        },
        credits: {
          enabled: false
      },
        series: [{
            name: '',
            type: 'column',
            data: ".json_encode($resAmount, JSON_NUMERIC_CHECK ).",
            color: 'rgb(106, 249, 196)',     
        }, {
            name: 'Transaction',
            type: 'spline',
            color: 'rgb(237, 86, 27)',
            data: ".json_encode($resAmount, JSON_NUMERIC_CHECK )."  
        }]
    });
    var respPorcTot=".json_encode($porc_transac_tot, JSON_NUMERIC_CHECK ).";
    if(respPorcTot == 'NAN%'){respPorcTot='0%';} 
    $('#toTransac').html(".json_encode($Tol_transact, JSON_NUMERIC_CHECK ).");
    $('#sumAmount').html(".json_encode("USD ".$Tol_amount, JSON_NUMERIC_CHECK ).");
    $('#finalCus').html(".json_encode($Tol_final_cust, JSON_NUMERIC_CHECK ).");
    $('#porcent').html(respPorcTot);
    $('#tituloChart').html('".$text_tit."');
    $('#tarjetas').css('display', 'block');
    $('#boxType').css('display', 'block');";

    $respuesta_pie1="var pieColors = (function () {
      var colors = [],
        base = Highcharts.getOptions().colors[0],
        i;
    
      for (i = 0; i < 10; i += 1) {
        colors.push(Highcharts.color(base).brighten((i - 3) / 7).get());
      }
      return colors;
    }());

    new Highcharts.Chart({
      chart: {
      renderTo: 'container2',
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
      },
      title: {
        text: 'Transactions".$responsStatus." /".$responsUid.$tituAdmin." ".$p_currency."',
        style: {
          color: 'black'
          } 
      },
      tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
      },
      accessibility: {
        point: {
          valueSuffix: '%'
        }
      },
      credits: {
        enabled: false
     },
      plotOptions: {
        pie: {
          allowPointSelect: true,
          cursor: 'pointer',
          colors: pieColors,
          dataLabels: {
            enabled: true,
            format: '<b>{point.name}</b><br>{point.percentage:.1f} %',
            distance: -50,
            filter: {
              property: 'percentage',
              operator: '>',
              value: 4
            }
          }
        }
      },
      series: [{
        name: 'Status',
        data: ["; 
        for ($i=0; $i<count($stReson1) AND $i<count($stReson2); $i++) { 
          $respuesta_pie1.=  "{name: '".$stReson2[$i]."', y:".$stReson1[$i]."},";}
          $respuesta_pie1.="] }]}); $('#tituloChart').html('Transactions".$responsStatus." /".$responsUid.$tituAdmin." ".$p_currency."'); $('#tarjetas').css('display', 'none'); $('#boxType').css('display', 'none');";

     $respuesta_pie2=" var pieColors = (function () {
      var colors = [],
        base = Highcharts.getOptions().colors[0],
        i;
    
      for (i = 0; i < 10; i += 1) {
        colors.push(Highcharts.color(base).brighten((i - 3) / 7).get());
      }
      return colors;
    }());

    new Highcharts.Chart({
      chart: {
      renderTo: 'container2',
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
      },
      title: {
        text: 'Transactions".$responsStatus." /".$responsUid.$tituAdmin." ".$p_currency."',
        style: {
          color: 'black'
          } 
      },
      tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
      },
      accessibility: {
        point: {
          valueSuffix: '%'
        }
      },
      credits: {
        enabled: false
     },
      plotOptions: {
        pie: {
          allowPointSelect: true,
          cursor: 'pointer',
          colors: pieColors,
          dataLabels: {
            enabled: true,
            format: '<b>{point.name}</b><br>{point.percentage:.1f} %',
            distance: -50,
            filter: {
              property: 'percentage',
              operator: '>',
              value: 4
            }
          }
        }
      },
      series: [{
        name: 'Status',
        data: [
          { name: 'Approved', y:".json_encode($stPie1[0], JSON_NUMERIC_CHECK )."},
          { name: 'Declined', y:".json_encode($stPie2[0], JSON_NUMERIC_CHECK )."},
        ]
      }]
    }); $('#tituloChart').html('Transactions".$responsStatus." /".$responsUid.$tituAdmin." ".$p_currency."'); $('#tarjetas').css('display', 'none'); $('#boxType').css('display', 'none');";
    if($p_statu!=6 || $p_statu!=7){
    if($p_tipCh=="Tbar"){echo $respuesta_Chart;}if($p_tipCh=="Tarea"){echo $respuesta_Chart2;}if($p_tipCh=="Tline"){echo $respuesta_Chart3;}
    } if($p_statu==6){echo $respuesta_pie2;} if($p_statu==7){echo $respuesta_pie1;}
    
    mysqli_close($conn);
    }

    if(isset($_POST['QkMerchantFilter'])){ 
      if($_SESSION['profileid']<=3) { 
        $filtro_Qkr="<select id='AllMerchantQk2' class='form-control sombra2' onchange='QkFilters(2)'>
                   <option value='0' selected> All Merchants </option>";
        $conn = mysqli_connect(DB_HOST,DB_USUARIO,DB_CLAVE,DB_NOMBRE);
        mysqli_set_charset($conn, "utf8");
        $sql_chart_mer="select id_merchant from merchant where id_merchant!='M---------' and status!=0"; 
        $consulta_chart_mer=$conn->query($sql_chart_mer);
        mysqli_close($conn); 
        while($reg_filMer=mysqli_fetch_assoc($consulta_chart_mer)){ 
          $filtro_Qkr.="<option value='".$reg_filMer['id_merchant']."'> ".$reg_filMer['id_merchant']." </option>";
          }$filtro_Qkr.="</select>";
      } if($_SESSION['profileid']>=4) { $filtro_Qkr="<input type='text' id='AllMerchantQk2' class='form-control sombra2' value='".$_SESSION['merchantid']."' disabled> "; } 
      echo $filtro_Qkr;
    }

    if(isset($_POST['data_dateRageQk'])){
      $tab_Cash=$tab_Bank=$tab_card="";
      $tot_CasCso1=$tot_CasCso2=$total_max=$total_agv=$total_proc=$tot_Caspay1=$tot_Caspay2=$total_max_bank=$total_agv_bank=$total_proc_bank=$tot_Casref1=$tot_Casref2=$total_max_card=$total_agv_card=$total_proc_card=0.00;
      $Qk_dateRange = $_POST['data_dateRageQk'];
      $Qk_merchId = $_POST['data_filt_merchQK'];
      $Qk_env = $_POST['data_env'];
      $dateFrom=substr($Qk_dateRange, 0,10 );
      $dateTo=substr($Qk_dateRange, 13 );
      $query_date = "date BETWEEN '".$dateFrom."' AND '".$dateTo."'";
      $conn = mysqli_connect(DB_HOST,DB_USUARIO,DB_CLAVE,DB_NOMBRE);
      mysqli_set_charset($conn, "utf8");    
      if($_SESSION['profileid']>=4) { if($Qk_merchId=='0'){$QueryQk_merchId=""; $QueryQk_merchId2="";}else{$QueryQk_merchId="id_merchant='".$_SESSION['merchantid']."' and "; $QueryQk_merchId2="trx.id_merchant='".$_SESSION['merchantid']."' and ";}}     
      if($_SESSION['profileid']<=3) { if($Qk_merchId=='0'){$QueryQk_merchId=""; $QueryQk_merchId2="";}else{$QueryQk_merchId="id_merchant='".$Qk_merchId."' and "; $QueryQk_merchId2="trx.id_merchant='".$Qk_merchId."' and ";}}
        $qryQK_cantTrx="SELECT IFNULL(COUNT(uid),0) as cant_trx FROM transaction WHERE ".$QueryQk_merchId." ".$query_date." and env=".$Qk_env;
        $qrQk_cash="SELECT IFNULL(COUNT(uid),0) as cant_trx_cash FROM transaction WHERE (uid LIKE 'CAS%') and ".$QueryQk_merchId." ".$query_date." and env=".$Qk_env." and chb=0";
        $qrQk_cashApp="SELECT IFNULL(COUNT(uid),0) as cant_trx_cashApp FROM transaction WHERE (uid LIKE 'CAS%') and ".$QueryQk_merchId." ".$query_date." and env=".$Qk_env." and status=1 or status=4 and chb=0";
        $qrQk_cashCalc="SELECT IFNULL(ROUND(SUM(amount),2),0) as total_cash_process, IFNULL(ROUND(AVG(amount),2),0) as peromedio_cash_amount, IFNULL(ROUND(MAX(amount),2),0) as max_cash_amount FROM transaction WHERE (uid LIKE 'CAS%') and ".$QueryQk_merchId." ".$query_date." and env=".$Qk_env." and `status`=1 or `status`=4 and chb=0;";
        $qrQk_cso="SELECT IFNULL(COUNT(uid),0) as cant_trx_cso FROM transaction WHERE (uid LIKE 'CSO%') and ".$QueryQk_merchId." ".$query_date." and env=".$Qk_env." and chb=0";
        $qrQk_csoApp="SELECT IFNULL(COUNT(uid),0) as cant_trx_csoApp FROM transaction WHERE (uid LIKE 'CSO%') and ".$QueryQk_merchId." ".$query_date." and env=".$Qk_env." and status=1 or status=4 and chb=0";
        $qrQk_csoCalc="SELECT IFNULL(ROUND(SUM(amount),2),0) as total_cso_process, IFNULL(ROUND(AVG(amount),2),0) as peromedio_cso_amount, IFNULL(ROUND(MAX(amount),2),0) as max_cso_amount FROM transaction WHERE (uid LIKE 'CSO%') and ".$QueryQk_merchId." ".$query_date." and env=".$Qk_env." and `status`=1 or `status`=4 and chb=0;";
        $consulta_cantTrx=$conn->query($qryQK_cantTrx);
        $consulta_cantcash=$conn->query($qrQk_cash);
        $consulta_cantcashApp=$conn->query($qrQk_cashApp);
        $consulta_TotalcashProc=$conn->query($qrQk_cashCalc);
        $consulta_cantcso=$conn->query($qrQk_cso);
        $consulta_cantcsoApp=$conn->query($qrQk_csoApp);
        $consulta_TotalcsoProc=$conn->query($qrQk_csoCalc);
          while($regCanTrx=mysqli_fetch_assoc($consulta_cantTrx)){$CantTrxAll=$regCanTrx['cant_trx'];}
          while($regCanCash=mysqli_fetch_assoc($consulta_cantcash)){while($regCanCashApp=mysqli_fetch_assoc($consulta_cantcashApp)){
            while($regCanCso=mysqli_fetch_assoc($consulta_cantcso)){
            while($regCsoApp=mysqli_fetch_assoc($consulta_cantcsoApp)){
             $tot_CasCso1=$regCanCash['cant_trx_cash']+$regCanCso['cant_trx_cso'];
             $tot_CasCso2=$regCanCashApp['cant_trx_cashApp']+$regCsoApp['cant_trx_csoApp'];
             $tab_Cash.="<table class='sombra2' id='qkCasTable'><thead><h3>CASH</h3></thead><tbody><tr><td style='text-align: center'>IN</td><td></td><td style='text-align: center'>OUT</td><td></td><td style='background-color: #501e99; color:white; border: 1px solid #858585 !important; text-align: left; padding: 8px;'>TOTAL CASH</td></tr><tr><td style='background-color: #501e99; color:white; border: 1px solid #858585 !important; text-align: left; padding: 8px;'>CASH IN VS APPROVED</td><td>".$regCanCash['cant_trx_cash']." / ".$regCanCashApp['cant_trx_cashApp']."</td><td style='background-color: #501e99; color:white; border: 1px solid #858585 !important; text-align: left; padding: 8px;'>CASH OUT VS APPROVED</td><td>".$regCanCso['cant_trx_cso']." / ".$regCsoApp['cant_trx_csoApp']."</td><td>".$tot_CasCso1." / ".$tot_CasCso2."</td></tr>";}}}}           
          while($regCanTrxProc=mysqli_fetch_assoc($consulta_TotalcashProc)){while($regCanTrxProc2=mysqli_fetch_assoc($consulta_TotalcsoProc)){
            $total_max=$regCanTrxProc['max_cash_amount']+$regCanTrxProc2['max_cso_amount'];
            $total_agv=$regCanTrxProc['peromedio_cash_amount']+$regCanTrxProc2['peromedio_cso_amount'];
            $total_proc=$regCanTrxProc['total_cash_process']+$regCanTrxProc2['total_cso_process'];
            $tab_Cash.="<tr><td style='background-color: #501e99; color:white; border: 1px solid #858585 !important; text-align: left; padding: 8px;'>MAX CASH IN AMOUNT USD</td><td>".$regCanTrxProc['max_cash_amount']."</td><td style='background-color: #501e99; color:white; border: 1px solid #858585 !important; text-align: left; padding: 8px;'>MAX CASH OUT AMOUNT USD</td><td>".$regCanTrxProc2['max_cso_amount']."</td><td>".number_format($total_max,2, '.', '')."</td></tr>";
            $tab_Cash.="<tr><td style='background-color: #501e99; color:white; border: 1px solid #858585 !important; text-align: left; padding: 8px;'>AVERAGE CASH IN AMOUNT USD</td><td>".$regCanTrxProc['peromedio_cash_amount']."</td><td style='background-color: #501e99; color:white; border: 1px solid #858585 !important; text-align: left; padding: 8px;'>AVERAGE CASH OUT AMOUNT USD</td><td>".$regCanTrxProc2['peromedio_cso_amount']."</td><td>".number_format($total_agv,2, '.', '')."</td></tr>";
            $tab_Cash.="<tr><td style='background-color: #501e99; color:white; border: 1px solid #858585 !important; text-align: left; padding: 8px;'>CASH IN AMOUNT PROCESSED</td><td>".$regCanTrxProc['total_cash_process']."</td><td style='background-color: #501e99; color:white; border: 1px solid #858585 !important; text-align: left; padding: 8px;'>CASH OUT AMOUNT PROCESSED</td><td>".$regCanTrxProc2['total_cso_process']."</td><td>".number_format($total_proc,2, '.', '')."</td></tr>";}}
        $qrQk_bank="SELECT (SELECT IFNULL(COUNT(uid),0) as cant_trx_bank2 FROM transaction WHERE (uid LIKE 'BAN%') and ".$QueryQk_merchId." ".$query_date." and env=".$Qk_env." and chb=0)+(SELECT IFNULL(COUNT(trx.uid),0) as cant_trx2 FROM transaction as trx INNER JOIN chargeback as charg ON trx.chb = charg.id WHERE (trx.uid LIKE 'BAN%') and ".$QueryQk_merchId2." trx.".$query_date." and trx.env=1 and trx.chb !=0 and charg.status=0) as cant_trx_bank";
        $qrQk_bankApp="SELECT (SELECT IFNULL(COUNT(uid),0) as cant_trx_bankApp2 FROM transaction WHERE (uid LIKE 'BAN%') and ".$QueryQk_merchId." ".$query_date." and env=".$Qk_env." and status=1 and chb=0)+(SELECT IFNULL(COUNT(trx.uid),0) as bankApp3 FROM transaction as trx INNER JOIN chargeback as charg ON trx.chb = charg.id WHERE (trx.uid LIKE 'BAN%') and ".$QueryQk_merchId2." trx.".$query_date." and trx.status=1 and trx.env=1 and trx.chb !=0 and charg.status=0) as cant_trx_bankApp";
        $qrQk_bankCalc="SELECT (SELECT IFNULL(ROUND(MAX(amount),2),0) as max_bank_amount2 FROM transaction WHERE (uid LIKE 'BAN%') and ".$QueryQk_merchId." ".$query_date." and env=".$Qk_env." and `status`=1 and chb=0)+(SELECT IFNULL(ROUND(MAX(amount),2),0) as max_bank_amount3 FROM transaction as trx INNER JOIN chargeback as charg ON trx.chb = charg.id WHERE (trx.uid LIKE 'BAN%') and ".$QueryQk_merchId2." trx.".$query_date." and trx.status=1 and trx.env=1 and trx.chb !=0 and charg.status=0) as max_bank_amount";
        $qrQk_bankAvg="SELECT (SELECT IFNULL(ROUND(AVG(amount),2),0) as peromedio_bank_amount2 FROM transaction WHERE (uid LIKE 'BAN%') and ".$QueryQk_merchId." ".$query_date." and env=".$Qk_env." and `status`=1 and chb=0)+(SELECT IFNULL(ROUND(AVG(amount),2),0) as peromedio_bank_amount3 FROM transaction as trx INNER JOIN chargeback as charg ON trx.chb = charg.id WHERE (trx.uid LIKE 'BAN%') and ".$QueryQk_merchId2." trx.".$query_date." and trx.status=1 and trx.env=1 and trx.chb !=0 and charg.status=0) as peromedio_bank_amount";
        $qrQk_bankProc="SELECT (SELECT IFNULL(ROUND(SUM(amount),2),0) as total_bank_process2 FROM transaction WHERE (uid LIKE 'BAN%') and ".$QueryQk_merchId." ".$query_date." and env=".$Qk_env." and `status`=1 and chb=0)+(SELECT IFNULL(ROUND(SUM(amount),2),0) as total_bank_process3 FROM transaction as trx INNER JOIN chargeback as charg ON trx.chb = charg.id WHERE (trx.uid LIKE 'BAN%') and ".$QueryQk_merchId2." trx.".$query_date." and trx.status=1 and trx.env=1 and trx.chb !=0 and charg.status=0) as total_bank_process";
        $qrQk_pay="SELECT (SELECT IFNULL(COUNT(uid),0) as cant_trx_pay2 FROM transaction WHERE (uid LIKE 'PAY%') and ".$QueryQk_merchId." ".$query_date." and env=".$Qk_env." and chb=0)+(SELECT IFNULL(COUNT(uid),2) as cant_trx_pay3 FROM transaction as trx INNER JOIN chargeback as charg ON trx.chb = charg.id WHERE (trx.uid LIKE 'PAY%') and ".$QueryQk_merchId2." trx.".$query_date." and trx.env=1 and trx.chb !=0 and charg.status=0) as cant_trx_pay";
        $qrQk_payApp="SELECT (SELECT IFNULL(COUNT(uid),0) as cant_trx_payApp2 FROM transaction WHERE (uid LIKE 'PAY%') and ".$QueryQk_merchId." ".$query_date." and env=".$Qk_env." and status=1 or status=4 and chb=0)+(SELECT IFNULL(COUNT(uid),0) as cant_trx_payApp3 FROM transaction as trx INNER JOIN chargeback as charg ON trx.chb = charg.id WHERE (trx.uid LIKE 'PAY%') and ".$QueryQk_merchId2." trx.".$query_date." and trx.status=1 and trx.env=1 and trx.chb !=0 and charg.status=0) as cant_trx_payApp";
        $qrQk_payCalc="SELECT (SELECT IFNULL(ROUND(MAX(amount),2),0) as max_pay_amount2 FROM transaction WHERE (uid LIKE 'PAY%') and ".$QueryQk_merchId." ".$query_date." and env=".$Qk_env." and `status`=1 and chb=0)+(SELECT IFNULL(ROUND(MAX(amount),2),0) as max_pay_amount3 FROM transaction as trx INNER JOIN chargeback as charg ON trx.chb = charg.id WHERE (trx.uid LIKE 'PAY%') and ".$QueryQk_merchId2." trx.".$query_date." and trx.status=1 and trx.env=1 and trx.chb !=0 and charg.status=0) as max_pay_amount";
        $qrQk_payAvg="SELECT (SELECT IFNULL(ROUND(AVG(amount),2),0) as peromedio_pay_amount2 FROM transaction WHERE (uid LIKE 'PAY%') and ".$QueryQk_merchId." ".$query_date." and env=".$Qk_env." and `status`=1 and chb=0)+(SELECT IFNULL(ROUND(AVG(amount),2),0) as peromedio_pay_amount3 FROM transaction as trx INNER JOIN chargeback as charg ON trx.chb = charg.id WHERE (trx.uid LIKE 'PAY%') and ".$QueryQk_merchId2." trx.".$query_date." and trx.status=1 and trx.env=1 and trx.chb !=0 and charg.status=0) as peromedio_pay_amount";
        $qrQk_payProc="SELECT (SELECT IFNULL(ROUND(SUM(amount),2),0) as total_pay_process2 FROM transaction WHERE (uid LIKE 'PAY%') and ".$QueryQk_merchId." ".$query_date." and env=".$Qk_env." and `status`=1 and chb=0)+(SELECT IFNULL(ROUND(SUM(amount),2),0) as total_pay_process3 FROM transaction as trx INNER JOIN chargeback as charg ON trx.chb = charg.id WHERE (trx.uid LIKE 'PAY%') and ".$QueryQk_merchId2." trx.".$query_date." and trx.status=1 and trx.env=1 and trx.chb !=0 and charg.status=0) as total_pay_process";
        $consulta_cantbank=$conn->query($qrQk_bank);
        $consulta_cantbankApp=$conn->query($qrQk_bankApp);
        $consulta_TotalbankProc=$conn->query($qrQk_bankCalc);
        $consulta_TotalbankAvg=$conn->query($qrQk_bankAvg);
        $consulta_TotalpayAvg=$conn->query($qrQk_payAvg);
        $consulta_TotalbankProc2=$conn->query($qrQk_bankProc);
        $consulta_TotalpayProc2=$conn->query($qrQk_payProc);
        $consulta_cantpay=$conn->query($qrQk_pay);
        $consulta_cantpayApp=$conn->query($qrQk_payApp);
        $consulta_TotalpayProc=$conn->query($qrQk_payCalc);
          while($regCanbank=mysqli_fetch_assoc($consulta_cantbank)){while($regCanbankApp=mysqli_fetch_assoc($consulta_cantbankApp)){while($regCanpay=mysqli_fetch_assoc($consulta_cantpay)){while($regpayApp=mysqli_fetch_assoc($consulta_cantpayApp)){
             $tot_Caspay1=$regCanbank['cant_trx_bank']+$regCanpay['cant_trx_pay'];
             $tot_Caspay2=$regCanbankApp['cant_trx_bankApp']+$regpayApp['cant_trx_payApp'];
             $tab_Bank.="<table class='sombra2' id='qkBankTable'><thead><h3>BANK</h3></thead><tbody><tr><td style='text-align: center'>IN</td><td></td><td style='text-align: center'>OUT</td><td></td><td style='background-color: #501e99; color:white; border: 1px solid #858585 !important; text-align: left; padding: 8px;'>TOTAL BANK</td></tr><tr><td style='background-color: #501e99; color:white; border: 1px solid #858585 !important; text-align: left; padding: 8px;'>BANK VS APPROVED</td><td>".$regCanbank['cant_trx_bank']." / ".$regCanbankApp['cant_trx_bankApp']."</td><td style='background-color: #501e99; color:white; border: 1px solid #858585 !important; text-align: left; padding: 8px;'>PAY OUT VS APPROVED</td><td>".$regCanpay['cant_trx_pay']." / ".$regpayApp['cant_trx_payApp']."</td><td>".$tot_Caspay1." / ".$tot_Caspay2."</td></tr>";}}}}           
          while($regCanTrxProcBan=mysqli_fetch_assoc($consulta_TotalbankProc)){while($regCanTrxProcBan2=mysqli_fetch_assoc($consulta_TotalpayProc)){
            $total_max_bank=$regCanTrxProcBan['max_bank_amount'] + $regCanTrxProcBan2['max_pay_amount'];
            $tab_Bank.="<tr><td style='background-color: #501e99; color:white; border: 1px solid #858585 !important; text-align: left; padding: 8px;'>MAX BANK AMOUNT USD</td><td>".$regCanTrxProcBan['max_bank_amount']."</td><td style='background-color: #501e99; color:white; border: 1px solid #858585 !important; text-align: left; padding: 8px;'>MAX PAY OUT AMOUNT USD</td><td>".$regCanTrxProcBan2['max_pay_amount']."</td><td>".number_format($total_max_bank,2, '.', '')."</td></tr>";}}
          while($regbankAvg=mysqli_fetch_assoc($consulta_TotalbankAvg)){while($regpayAvg=mysqli_fetch_assoc($consulta_TotalpayAvg)){
            $total_agv_bank=$regbankAvg['peromedio_bank_amount']+$regpayAvg['peromedio_pay_amount'];
            $tab_Bank.="<tr><td style='background-color: #501e99; color:white; border: 1px solid #858585 !important; text-align: left; padding: 8px;'>AVERAGE BANK AMOUNT USD</td><td>".$regbankAvg['peromedio_bank_amount']."</td><td style='background-color: #501e99; color:white; border: 1px solid #858585 !important; text-align: left; padding: 8px;'>AVERAGE PAY OUT AMOUNT USD</td><td>".$regpayAvg['peromedio_pay_amount']."</td><td>".number_format($total_agv_bank,2, '.', '')."</td></tr>";}}
          while($regbankProc=mysqli_fetch_assoc($consulta_TotalbankProc2)){while($regpayProc=mysqli_fetch_assoc($consulta_TotalpayProc2)){
            $total_proc_bank=$regbankProc['total_bank_process']+$regpayProc['total_pay_process'];            
            $tab_Bank.="<tr><td style='background-color: #501e99; color:white; border: 1px solid #858585 !important; text-align: left; padding: 8px;'>BANK AMOUNT PROCESSED</td><td>".$regbankProc['total_bank_process']."</td><td style='background-color: #501e99; color:white; border: 1px solid #858585 !important; text-align: left; padding: 8px;'>PAY OUT AMOUNT PROCESSED</td><td>".$regpayProc['total_pay_process']."</td><td>".number_format($total_proc_bank,2, '.', '')."</td></tr>"; }}
           $qrQk_card="SELECT (SELECT IFNULL(COUNT(uid),0) as cant_trx_card2 FROM transaction WHERE (uid LIKE 'CAR%') and ".$QueryQk_merchId." ".$query_date." and env=".$Qk_env." and chb=0)+(SELECT IFNULL(COUNT(trx.uid),0) as cant_trx2 FROM transaction as trx INNER JOIN chargeback as charg ON trx.chb = charg.id WHERE (trx.uid LIKE 'CAR%') and ".$QueryQk_merchId2." trx.".$query_date." and trx.env=1 and trx.chb !=0 and charg.status=0) as cant_trx_card";
           $qrQk_cardApp="SELECT (SELECT IFNULL(COUNT(uid),0) as cant_trx_cardApp2 FROM transaction WHERE (uid LIKE 'CAR%') and ".$QueryQk_merchId." ".$query_date." and env=".$Qk_env." and status=1 and chb=0)+(SELECT IFNULL(COUNT(trx.uid),0) as cardApp3 FROM transaction as trx INNER JOIN chargeback as charg ON trx.chb = charg.id WHERE (trx.uid LIKE 'CAR%') and ".$QueryQk_merchId2." trx.".$query_date." and trx.status=1 and trx.env=1 and trx.chb !=0 and charg.status=0) as cant_trx_cardApp";
           $qrQk_cardCalc="SELECT (SELECT IFNULL(ROUND(MAX(amount),2),0) as max_card_amount2 FROM transaction WHERE (uid LIKE 'CAR%') and ".$QueryQk_merchId." ".$query_date." and env=".$Qk_env." and `status`=1 and chb=0)+(SELECT IFNULL(ROUND(MAX(amount),2),0) as max_card_amount3 FROM transaction as trx INNER JOIN chargeback as charg ON trx.chb = charg.id WHERE (trx.uid LIKE 'CAR%') and ".$QueryQk_merchId2." trx.".$query_date." and trx.status=1 and trx.env=1 and trx.chb !=0 and charg.status=0) as max_card_amount";
           $qrQk_cardAvg="SELECT (SELECT IFNULL(ROUND(AVG(amount),2),0) as peromedio_card_amount2 FROM transaction WHERE (uid LIKE 'CAR%') and ".$QueryQk_merchId." ".$query_date." and env=".$Qk_env." and `status`=1 and chb=0)+(SELECT IFNULL(ROUND(AVG(amount),2),0) as peromedio_card_amount3 FROM transaction as trx INNER JOIN chargeback as charg ON trx.chb = charg.id WHERE (trx.uid LIKE 'CAR%') and ".$QueryQk_merchId2." trx.".$query_date." and trx.status=1 and trx.env=1 and trx.chb !=0 and charg.status=0) as peromedio_card_amount";
           $qrQk_cardProc="SELECT (SELECT IFNULL(ROUND(SUM(amount),2),0) as total_card_process2 FROM transaction WHERE (uid LIKE 'CAR%') and ".$QueryQk_merchId." ".$query_date." and env=".$Qk_env." and `status`=1 and chb=0)+(SELECT IFNULL(ROUND(SUM(amount),2),0) as total_card_process3 FROM transaction as trx INNER JOIN chargeback as charg ON trx.chb = charg.id WHERE (trx.uid LIKE 'CAR%') and ".$QueryQk_merchId2." trx.".$query_date." and trx.status=1 and trx.env=1 and trx.chb !=0 and charg.status=0) as total_card_process";
           $qrQk_ref="SELECT (SELECT IFNULL(COUNT(uid),0) as cant_trx_ref2 FROM transaction WHERE (uid LIKE 'REF%') and ".$QueryQk_merchId." ".$query_date." and env=".$Qk_env." and chb=0)+(SELECT IFNULL(COUNT(uid),0) as cant_trx_ref3 FROM transaction as trx INNER JOIN chargeback as charg ON trx.chb = charg.id WHERE (trx.uid LIKE 'REF%') and ".$QueryQk_merchId2." trx.".$query_date." and trx.env=1 and trx.chb !=0 and charg.status=0) as cant_trx_ref";
           $qrQk_refApp="SELECT (SELECT IFNULL(COUNT(uid),0) as cant_trx_refApp2 FROM transaction WHERE (uid LIKE 'REF%') and ".$QueryQk_merchId." ".$query_date." and env=".$Qk_env." and status=1 or status=4 and chb=0)+(SELECT IFNULL(COUNT(uid),0) as cant_trx_refApp3 FROM transaction as trx INNER JOIN chargeback as charg ON trx.chb = charg.id WHERE (trx.uid LIKE 'REF%') and ".$QueryQk_merchId2." trx.".$query_date." and trx.status=1 and trx.env=1 and trx.chb !=0 and charg.status=0) as cant_trx_refApp";
           $qrQk_refCalc="SELECT (SELECT IFNULL(ROUND(MAX(amount),2),0) as max_ref_amount2 FROM transaction WHERE (uid LIKE 'REF%') and ".$QueryQk_merchId." ".$query_date." and env=".$Qk_env." and `status`=1 and chb=0)+(SELECT IFNULL(ROUND(MAX(amount),2),0) as max_ref_amount3 FROM transaction as trx INNER JOIN chargeback as charg ON trx.chb = charg.id WHERE (trx.uid LIKE 'REF%') and ".$QueryQk_merchId2." trx.".$query_date." and trx.status=1 and trx.env=1 and trx.chb !=0 and charg.status=0) as max_ref_amount";
           $qrQk_refAvg="SELECT (SELECT IFNULL(ROUND(AVG(amount),2),0) as peromedio_ref_amount2 FROM transaction WHERE (uid LIKE 'REF%') and ".$QueryQk_merchId." ".$query_date." and env=".$Qk_env." and `status`=1 and chb=0)+(SELECT IFNULL(ROUND(AVG(amount),2),0) as peromedio_ref_amount3 FROM transaction as trx INNER JOIN chargeback as charg ON trx.chb = charg.id WHERE (trx.uid LIKE 'REF%') and ".$QueryQk_merchId2." trx.".$query_date." and trx.status=1 and trx.env=1 and trx.chb !=0 and charg.status=0) as peromedio_ref_amount";
           $qrQk_refProc="SELECT (SELECT IFNULL(ROUND(SUM(amount),2),0) as total_ref_process2 FROM transaction WHERE (uid LIKE 'REF%') and ".$QueryQk_merchId." ".$query_date." and env=".$Qk_env." and `status`=1 and chb=0)+(SELECT IFNULL(ROUND(SUM(amount),2),0) as total_ref_process3 FROM transaction as trx INNER JOIN chargeback as charg ON trx.chb = charg.id WHERE (trx.uid LIKE 'REF%') and ".$QueryQk_merchId2." trx.".$query_date." and trx.status=1 and trx.env=1 and trx.chb !=0 and charg.status=0) as total_ref_process";
           $consulta_cantcard=$conn->query($qrQk_card);
           $consulta_cantcardApp=$conn->query($qrQk_cardApp);
           $consulta_TotalcardProc=$conn->query($qrQk_cardCalc);
           $consulta_TotalcardAvg=$conn->query($qrQk_cardAvg);
           $consulta_TotalrefAvg=$conn->query($qrQk_refAvg);
           $consulta_TotalcardProc2=$conn->query($qrQk_cardProc);
           $consulta_TotalrefProc2=$conn->query($qrQk_refProc);
           $consulta_cantref=$conn->query($qrQk_ref);
           $consulta_cantrefApp=$conn->query($qrQk_refApp);
           $consulta_TotalrefProc=$conn->query($qrQk_refCalc);
             while($regCancard=mysqli_fetch_assoc($consulta_cantcard)){while($regCancardApp=mysqli_fetch_assoc($consulta_cantcardApp)){while($regCanref=mysqli_fetch_assoc($consulta_cantref)){while($regrefApp=mysqli_fetch_assoc($consulta_cantrefApp)){
                $tot_Casref1=$regCancard['cant_trx_card']+$regCanref['cant_trx_ref'];
                $tot_Casref2=$regCancardApp['cant_trx_cardApp']+$regrefApp['cant_trx_refApp'];
                $tab_card.="<table class='sombra2' id='qkCardTable'><thead><h3>CARD</h3></thead><tbody><tr><td style='text-align: center'>IN</td><td></td><td style='text-align: center'>OUT</td><td></td><td style='background-color: #501e99; color:white; border: 1px solid #858585 !important; text-align: left; padding: 8px;'>TOTAL CARD</td></tr><tr><td style='background-color: #501e99; color:white; border: 1px solid #858585 !important; text-align: left; padding: 8px;'>CARD VS APPROVED</td><td>".$regCancard['cant_trx_card']." / ".$regCancardApp['cant_trx_cardApp']."</td><td style='background-color: #501e99; color:white; border: 1px solid #858585 !important; text-align: left; padding: 8px;'>REFUND VS APPROVED</td><td>".$regCanref['cant_trx_ref']." / ".$regrefApp['cant_trx_refApp']."</td><td>".$tot_Casref1." / ".$tot_Casref2."</td></tr>";}}}}           
             while($regCanTrxProcBan=mysqli_fetch_assoc($consulta_TotalcardProc)){while($regCanTrxProcBan2=mysqli_fetch_assoc($consulta_TotalrefProc)){
               $total_max_card=$regCanTrxProcBan['max_card_amount'] + $regCanTrxProcBan2['max_ref_amount'];
               $tab_card.="<tr><td style='background-color: #501e99; color:white; border: 1px solid #858585 !important; text-align: left; padding: 8px;'>MAX CARD AMOUNT USD</td><td>".$regCanTrxProcBan['max_card_amount']."</td><td style='background-color: #501e99; color:white; border: 1px solid #858585 !important; text-align: left; padding: 8px;'>MAX REFUND AMOUNT USD</td><td>".$regCanTrxProcBan2['max_ref_amount']."</td><td>".number_format($total_max_card,2, '.', '')."</td></tr>";}}
             while($regcardAvg=mysqli_fetch_assoc($consulta_TotalcardAvg)){while($regrefAvg=mysqli_fetch_assoc($consulta_TotalrefAvg)){
               $total_agv_card=$regcardAvg['peromedio_card_amount']+$regrefAvg['peromedio_ref_amount'];
               $tab_card.="<tr><td style='background-color: #501e99; color:white; border: 1px solid #858585 !important; text-align: left; padding: 8px;'>AVERAGE CARD AMOUNT USD</td><td>".$regcardAvg['peromedio_card_amount']."</td><td style='background-color: #501e99; color:white; border: 1px solid #858585 !important; text-align: left; padding: 8px;'>AVERAGE REFUND AMOUNT USD</td><td>".$regrefAvg['peromedio_ref_amount']."</td><td>".number_format($total_agv_card,2, '.', '')."</td></tr>";}}
             while($regcardProc=mysqli_fetch_assoc($consulta_TotalcardProc2)){while($regrefProc=mysqli_fetch_assoc($consulta_TotalrefProc2)){
               $total_proc_card=$regcardProc['total_card_process']+$regrefProc['total_ref_process'];            
               $tab_card.="<tr><td style='background-color: #501e99; color:white; border: 1px solid #858585 !important; text-align: left; padding: 8px;'>CARD AMOUNT PROCESSED</td><td>".$regcardProc['total_card_process']."</td><td style='background-color: #501e99; color:white; border: 1px solid #858585 !important; text-align: left; padding: 8px;'>REFUND AMOUNT PROCESSED</td><td>".$regrefProc['total_ref_process']."</td><td>".number_format($total_proc_card,2, '.', '')."</td></tr>"; }}
          $tab_Cash.="</tbody></table>";
          $tab_Bank.="</tbody></table>";
          $tab_card.="</tbody></table>";
          $response_report="<div style='display: inline-flex; margin-top: 20px;'><h4 class='sombra2' style='background-color: #501e99; color:white; padding: 5px;'>TOTAL TRX: &nbsp</h4><h4 class='sombra2' id='total_trx' style='background-color: #501e99; color:white; padding: 5px'>".$CantTrxAll."</h4></div>
          <div class='row justify-content-center' style='margin-top: 10px;'>
              <div class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12'>
                  <div class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12'>"
                  .$tab_Cash."<br>".$tab_Bank."<br>".$tab_card."
                  </div>
              </div>
          </div>";
          echo $response_report;
    }
 
?>