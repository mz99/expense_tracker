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
    //var_dump($_GET);
    
    //default month and year
    $month = date('n');
    $year = date('Y');
    
    
    
    // Override default month and year from url vars if they're present
    if( isset($_GET["month"]) && isset($_GET["year"]) ){
        $month = $_GET["month"];
        $year = $_GET["year"];
    }
    
    //setup timestamp variables
    $start_month = mktime(0, 0, 0, $month, 1, $year);
    $display_date = date("F Y",$start_month);
    //var_dump($display_date);
    
    
    //create connection to MySQL database
    $dbc = mysqli_connect('localhost','root','p2jxsb6c','Expense')
        or die('Error connecting to MySQL server.');

    //create variables with mock data to populate table    
    $day = 1;
    $days_in_month = 31;
  
   
    //create month & days general header
    ?>
    <h1 id=box1>
        <a href="?month=<?php echo $month - 1; ?>&year=2015"> < </a> 
        <?php echo $display_date; ?>  
        <a href="?month=<?php echo $month + 1; ?>&year=2015"> > </a>  expenses
    </h1>
    <table>    
    
    <?php
    echo "  <tr>\n";
    echo "    <th> $display_date </th>\n";
    
    //populate days of the month header
    for($day=1;$day< $days_in_month;$day++){
        echo "    <td>$day</td>\n";       
    };
    echo "<th>totals</th>";
    echo "</tr>\n";       
    
    //create Eating Out category row
    echo "<tr>\n";
    echo "<th>Eating Out</th>\n";
    
    //use this function in the future to lessen code for below     
    function get_expenses_for_day($date, $type) {
        // Do SQL to get expense from database for day :)
        return "";
    }
    
    //Create Eating out category row 
    for($day=1; $day<$days_in_month; $day++){  
        
        // SELECT SUM(amount) as total_amount FROM Expense where type like 'Eating Out%' AND date = "2015-05-25" GROUP BY date
        $query_eating = "SELECT SUM(amount) as total_amount FROM Expense where type like 'Eating Out%' AND date = '" . 
            date("Y-m-d", mktime(0, 0, 0, 5, $day, 2015)). 
            "' GROUP BY date;";
        $result_eating = mysqli_query($dbc, $query_eating) or die("that didn't work" + mysqli_error($dbc));
        $row = mysqli_fetch_array($result_eating);  

        echo "    <td>" . $row["total_amount"] . "</td>\n";                                          
    };
   
    //Create Eating out totals row
        $query_eating_totals = "SELECT SUM(amount) as total_amount FROM Expense where (type like 'Eating Out%') AND (date between '2015-05-01' AND '2015-05-31')";           
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
    
    
    
    for ($day=1; $day<$days_in_month; $day++){
    
    $query_eating = "SELECT SUM(amount) as total_amount FROM Expense where type like 'Hostel' AND date = '" . 
        date("Y-m-d", mktime(0, 0, 0, 5, $day, 2015)). 
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
</body>
</html>

