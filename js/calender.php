<?php include("../config.php");?>
<?php
$nmonth = cnum($_GET["month"]);
$str="";

            $today=date('Y-m-d',strtotime(date('Y-m-d').$nmonth.' month'));
            $nmonth2 = $nmonth+1;
            $nowday =date('Y-m-d',strtotime(date('Y-m-d').$nmonth2.' day'));
	       
            $tmonth = date('Y-m',strtotime($today));
            
            $nextmonth = date("Y-m-01",strtotime($today."1 month"));
            $lastday = date("t",strtotime($today));
            $firstweek = date("w",strtotime($tmonth."-01")); 
        
        ?>
        
       <?php include("../include/calender.php");?>   
        <?php

			   $loop1=($lastday+$firstweek) / 7;
			   
			   $amari=($lastday+$firstweek) % 7;
			   if ($amari>0){
			   $loop1++;
			   }
			   
            $str="<p>".str_replace("-","年",$tmonth)."月</p>"; 
            $str .= '<table summary="予約カレンダー" class="atten">';
            $str .= '<thead>';
            $str .= '<tr>';
            $str .= '<th abbr="日" class="first">日</th>';
            $str .= '<th abbr="月">月</th>';
            $str .= '<th abbr="火">火</th>';
            $str .= '<th abbr="水">水</th>';
            $str .= '<th abbr="木">木</th>';
            $str .= '<th abbr="金">金</th>';
            $str .= '<th abbr="土" class="last">土</th>';
            $str .= '</tr>';
            $str .= '</thead>';
                      
            $str .= '<tbody>';
             
				   $c=$lastday+$firstweek;
				   $cnt=0;
				   for ($a=1;$a<=$loop1;$a++){
				   
			
             $str .= '<tr style="border:1px solid;">';
                   
				   $cnt1=0;
				   for ($b=1;$b<=$c;$b++){
				   $echk=0;
				   $cnt1++;
				   if ($cnt1<=7){
				   $classname="";
				   if ($cnt1 == 1) {
						$classname = " class='first'";
					}

					if ($cnt1 == 7) {
						$classname = " class='last'";
					}
				   	$dateToCheck = date('Y-m-d',strtotime(date('Y-m',strtotime($tmonth)).'-'.$cnt));
                   
					if (strtotime($dateToCheck) < strtotime($nowday)) {
						$classname = " class='endday'";
					}
              $str .= '<td'. $classname .'>';
                 
							if ($b>$firstweek || $cnt>0){
							$cnt++;
                            if ($cnt<=$lastday){
               $str .= $cnt;
               $dchk=0;
               if (is_array($darray)) {
    
            if (count($darray) > 0) {
                for ($d = 0; $d < count($darray); $d++) {
                    if (!empty($darray[$d])) {
                        // 対象日（tmonth の年・月と cnt を組み合わせて日付を作成）
                        
                        $targetDate = date('Y-m-d',strtotime($tmonth.'-'.$cnt));
                        if (strtotime($targetDate) === strtotime($darray[$d])) {
                                    if (strpos($sarray[$d], '休日 ') !== false) {
                                   $str .= '<span class="red">' . ' 振替休日' . '</span>';
                                    }else{
                                   $str .= '<span class="red">' . $sarray[$d] . '</span>';
                                   }
                                   $dchk=1;
                                       }
                                    }
                                }
                            }
                        }
               $date = date('Y-m-d',strtotime(date('Y-m',strtotime($tmonth)).'-'.$cnt));         
               $week = date("w",strtotime($date)); 
               //祝日を定休日にしない場合は「or dchk=1」を追加
               $rkyu = 0;
               if (strpos(',' . $r . ',', ',' . $cnt . ',') !== false && $week !== 1 && $week !== 5) {
                $rkyu = 1;
                $str .= '<span class="red"> 臨時休業</span>';
               }
               $edate =  date('Y-m-d',strtotime(date('Y-m',strtotime($tmonth)).'-'.$cnt));
               $sql="SELECT * from t_temporary_sales Where edate=:edate and cancel=0";
                $d = $dbh->prepare($sql);
                $d -> bindValue(":edate",$edate,PDO::PARAM_STR);
                $d -> execute();
                $rse = $d->fetch(PDO::FETCH_ASSOC);
                if(!empty($rse)){
                $dchk=1;
                }
                $targetDate = date('Y-m-d',strtotime($tmonth.'-'.$cnt));
                if (strtotime($targetDate) > strtotime($nowday) && $week != 1 && $week != 5 && $rkyu == 0) {

               $str .= "<br>";
               $str .= '<p class="centering">';
                    $str .= '<button type="button" class="yoyakubtn" id="yoyaku_'.date('Y',strtotime($tmonth)).'_'.date('m',strtotime($tmonth)).'_'.$cnt.'">予約</button><br></p>';
                }
                if (($week==1 || $week==5) && $echk==0){

                $str .= '<p class="red centering small">定休日</p>';

                }elseif (($week==1 || $week==5) && $echk==1){
           
                $str .= "<br>";
                $str .= '<p class="centering">';
                    $str .= '<button type="button" class="yoyakubtn" id="yoyaku_'.date('Y',strtotime($tmonth)).'_'.date('m',strtotime($tmonth)).'_'.$cnt.'">予約</button><br></p>';
                }
                                }
					   		}
				       
                            
               $str .= '</td>';
                           
               
				   if ($cnt1==7){break;}
                        } //endif
                    } //next
				         
               $str .= '</tr>';
               
			} //next
				 
           
                $str .= '</tbody>';
             $str .= '</table>';
            echo $str;
?>
             