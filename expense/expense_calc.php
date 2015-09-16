<?php
    //Display all errors
    error_reporting(E_ALL);        
    
    //Get current month and year
    $month = date('n');
    $year = date('Y');
            
    // Override default month and year from url vars if they're present
    if( isset($_GET["month"]) && isset($_GET["year"]) ){
        $month = $_GET["month"];
        $year = $_GET["year"];
    }
    
    //setup timestamp variables
    $start_date = mktime(0, 0, 0, $month, 1, $year);
    $display_date = date("F Y",$start_date);    
       
    //create connection to MySQL database
    $dbc = mysqli_connect('localhost','root','admin','Expense')
        or die('Error connecting to MySQL server.');

    //create variables with mock data to populate table    
    $day = 1;
    $days_in_month = date('t',$start_date);
    $beg_date = date("Y-m-d",$start_date);
    $end_date = date("Y",$start_date) . "-" . date("m",$start_date) . "-" . date("t",$start_date);
    
    function calendarLink(year=date('Y'), month)
      echo "<a href="?month=<?php echo $month - 1; ?>&year=<?php echo $year; ?>"> < </a> "
    end
    
?>
