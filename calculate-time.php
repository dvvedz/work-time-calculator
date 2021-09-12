<?php
    session_start();
    header("Content-Type: application/json; charset=UTF-8");

    $final_time = "";
    if(isset($_POST['start_time']) && isset($_POST['end_time']) && isset($_POST['lunch_brake'])){
        if(!empty($_POST['start_time']) && !empty($_POST['end_time']) && !empty($_POST['lunch_brake'])) {
            $start_time = new DateTime(htmlspecialchars($_POST['start_time']));
            $end_time = new DateTime(htmlspecialchars($_POST['end_time']));

            $diffe = $end_time->diff($start_time);
        
            $format_time = $diffe->format("%H:%I");
        
            $subt_lunch = strtotime($format_time) - (htmlspecialchars($_POST['lunch_brake'] * 60));
            $final_time = date("H:i", $subt_lunch);


            $stored_json = file_get_contents("./log.json");
            $log_data = json_decode($stored_json, true);

            $log_data[] = array("start_time" => htmlspecialchars($_POST['start_time']), 
                                "end_time" => htmlspecialchars($_POST['end_time']), 
                                "lunch_brake"=> htmlspecialchars($_POST['lunch_brake']), 
                                "final_time" => htmlspecialchars($final_time), 
                                "date" => date("Y-m-d"));
    
            file_put_contents("log.json", json_encode($log_data));
            header("Location: index.php");
        } else {
            $_SESSION['field_error'] = "fill in all the fields...";
            header("Location: index.php");
            exit();
        }
    }
?>