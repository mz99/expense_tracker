<!doctype>
<html>
<head>
<title>Expense tracker</title>
<link rel="stylesheet" type="text/css" href="styles.css" media="screen" />
<script type="text/javascript" src="hello.js"></script>
</head>
<body>
<?php
    //create connection to MySQL database
    $dbc = mysqli_connect('localhost','root','p2jxsb6c')
        or die('Error connecting to MySQL server.');
    mysqli_select_db($dbc, 'Expense');
    

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
    while ($day < $days_in_month){
        echo "    <td id=$day>$day</td>\n";
        $day = $day + 1;
    };
    echo "</tr>\n";       
    
    //create Eating Out category row
    echo "<tr>\n";
    echo "<th>Eating Out</th>\n";
         
    $query_eating = "SELECT id,date,amount FROM Expense where type like 'Eating Out%'";
    $result_eating = mysqli_query($dbc, $query_eating)
        or die("that didn't work");
    
    //left off needing to make comparison between $day and $row['id'] in order to know which days to populate for amount 
    $day = 1;
   
    while ($day < $days_in_month){  

        $query_eating = "SELECT SUM(amount) as total_amount FROM Expense where type like 'Eating Out%' AND date = '" . 
        date("Y-m-d", mktime(0, 0, 0, 5, $day, 2015)). 
        "' GROUP BY date;";
        $result_eating = mysqli_query($dbc, $query_eating) or die("that didn't work" + mysqli_error($dbc));
        $row = mysqli_fetch_array($result_eating);  

        echo "    <td id=$day>" . $row["total_amount"] . "</td>\n"; 
        $day = $day + 1;                                   
    };
    echo "</tr>\n";
    
    //create Hostel category row
    echo "<tr>\n";
    echo "<th>Hostel</th>\n";
    
    $query_hostel = "SELECT id,date,amount FROM Expense where type like 'Hostel'";
    $result_hostel = mysqli_query($dbc, $query_hostel)
        or die("that didn't work");
    
    $day = 0;
    
    while ($day < $days_in_month){
    
    $query_eating = "SELECT SUM(amount) as total_amount FROM Expense where type like 'Hostel' AND date = '" . 
        date("Y-m-d", mktime(0, 0, 0, 5, $day, 2015)). 
        "' GROUP BY date;";
        $result_eating = mysqli_query($dbc, $query_eating) or die("that didn't work" + mysqli_error($dbc));
        $row = mysqli_fetch_array($result_eating);  

        echo "    <td id=$day>" . $row["total_amount"] . "</td>\n"; 
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

