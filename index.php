<!doctype> 
<html>
<head>
<title>Expense tracker</title>
<link rel="stylesheet" type="text/css" href="styles.css" media="screen" />
<script type="text/javascript" src="hello.js"></script>
</head>
<body>

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
    $dbc = mysqli_connect('localhost','root','p2jxsb6c','Expense')
        or die('Error connecting to MySQL server.');

    //create variables with mock data to populate table    
    $day = 1;
    $days_in_month = date('t',$start_date);
    $beg_date = date("Y-m-d",$start_date);
    $end_date = date("Y",$start_date) . "-" . date("m",$start_date) . "-" . date("t",$start_date);
    
    echo 'show me what mktime does  ' . $start_date;
    echo '<br> show me what date("F Y") does '. $display_date;
    echo '<br> this is the $month variable: ' . $month;
    echo '<br> this is the $year variable: ' . $year; 
    echo '<br> this is how many days in this month date("t",$start_date): ' . $days_in_month;
    echo '<br> this is the beginning date ($beg_date): ' . $beg_date;
    echo '<br> this is the ending date($end_date): ' . $end_date; 
    ?>
    
    <!-- create month & days general header -->
    
    <h1>
        <a href="?month=<?php echo $month - 1; ?>&year=<?php echo $year; ?>"> < </a> 
        <?php echo $display_date; ?>  
        <a href="?month=<?php echo $month + 1; ?>&year=<?php echo $year; ?>"> > </a>  Expenses
    </h1>
    
    <table>    
    <?php
    echo "  <tr>\n";
    echo "    <th> $display_date </th>\n";
    
    //populate days of the month header
    for($day=1; $day<$days_in_month+1;$day++){
        echo "    <td>$day</td>\n";       
    };
    echo "<th>totals</th>";
    echo "</tr>\n";       
    
    //create Eating Out category row
    echo "<tr>\n";
    echo "<th>Eating Out</th>\n";
    
    //create function to query a category    
    function get_expenses_for_day($date, $type) {
        // Do SQL to get expense from database for day :)
        return "";
    }
    
    //Create Eating out category row 
    for($day=1; $day<$days_in_month+1; $day++){  
        $query_eating = "SELECT SUM(amount) as total_amount FROM Expense where type like 'Eating Out%' AND date = '" . 
            date("Y-m-d", mktime(0, 0, 0, $month, $day, $year)). 
            "' GROUP BY date;";
        $result_eating = mysqli_query($dbc, $query_eating) or die("that didn't work" + mysqli_error($dbc));
        $row = mysqli_fetch_array($result_eating);  

        echo "    <td>" . $row["total_amount"] . "</td>\n";                                          
    };
   
    //Create Eating out totals row
    $query_eating_totals = "SELECT SUM(amount) as total_amount FROM Expense where (type like 'Eating Out%') AND (date between '".     $beg_date . "' AND '". $end_date . "')";           
    $result_eating_totals = mysqli_query($dbc, $query_eating_totals) or die("that didn't work" + mysqli_error($dbc));
    $row = mysqli_fetch_array($result_eating_totals);  
    echo "    <th>" . $row["total_amount"] . "</th>\n";
    echo "</tr>\n";
    
      
    //Create Hostel category row
    echo "<tr>\n";
    echo "<th>Hostel</th>\n";
    
    $query_hostel = "SELECT id,date,amount FROM Expense where type like 'Hostel'";
    $result_hostel = mysqli_query($dbc, $query_hostel)
        or die("that didn't work");
        
    for ($day=1; $day<$days_in_month+1; $day++){
        $query_eating = "SELECT SUM(amount) as total_amount FROM Expense where type like 'Hostel' AND date = '" . 
        date("Y-m-d", mktime(0, 0, 0, $month, $day, $year)). 
        "' GROUP BY date;";
        $result_eating = mysqli_query($dbc, $query_eating) or die("that didn't work" + mysqli_error($dbc));
        $row = mysqli_fetch_array($result_eating);  

        echo "    <td>" . $row["total_amount"] . "</td>\n"; 
        $day = $day + 1;  
    
        $row = mysqli_fetch_array($result_hostel);           
    }
    
    echo "</tr>\n";
    echo "</table>";
    mysqli_close($dbc);
?>

<?php
    echo '<form name="update" method="post" action="day_amount.php">';
    echo '  <select name="day">';
    
    for ($day=1; $day<$days_in_month+1; $day++){
        echo "<option value=$day>$day</option><br/>";
    }                    
    echo '</select>';
    echo '<select name="category">';
        echo '<option value="Eating out">Eating Out</option>';
        echo '<option value="Hostel">Hostel</option>';
    echo '</select><br/>';
    echo 'Please enter the amount';
    echo '<br/><input type="text" name="amount">';
    
    
    echo "<br/><input type='text' id='hide' name='month' value=$month>";
    echo "<br/><input type='text' id='hide' name='year' value=$year>";      
    echo '<input id="button" type="submit">';
    echo '</form>';
?>


</body>
</html>
