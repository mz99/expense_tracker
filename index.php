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
    
    //create connection to MySQL database
    $dbc = mysqli_connect('localhost','root','p2jxsb6c','Expense')
        or die('Error connecting to MySQL server.');

    //create variables with mock data to populate table
                
    $day = 1;
    $days_in_month = 31;
    $month = "May";
    $year = "2015";
   
    //create month & days general header
    echo "<h1 id=box1>$month $year expenses</h1>";
    echo "<table> \n";
    echo "  <tr>\n";
    echo "    <th>$month $year</th>\n";
    
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
    
    //left off needing to:
    //1) sum all same day, same category values inside server and display as a rolled up total
    //2) look into how to link day of expense to proper date on calendar
    //3) php date functions, can we populate <td id=$day> to 
?>
</body>
</html>

