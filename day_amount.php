<?php
    //create connection to MySQL database
    $dbc = mysqli_connect('localhost','root','admin','Expense')
        or die('Error connecting to MySQL server.');
        
    $amount = $_POST["amount"];
    $day = $_POST["day"];
    $category = $_POST["category"];
    $month = $_POST["month"];
    $year = $_POST["year"];
    
    $timestamp = mktime(0, 0, 0, $month, $day, $year);
    $date = date("Y-m-d", $timestamp);
    
    echo "The amount is =" . $amount . "<br>" .
         "The date is = " . $date;
    
    $sql = "insert into Expense (date, amount, type) values ('$date',$amount,'$category')";
    echo $sql;
    
    if (mysqli_query($dbc, $sql)) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($dbc);
}

mysqli_close($dbc);
    
?>


