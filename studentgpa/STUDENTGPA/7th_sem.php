<?php

    session_start();

    if(isset($_SESSION['Student_ID']) =="") {
        header("Location: login.php");
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .wrapper{
            width: 900px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 120px;
        }
    </style>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Student Result</h2>
                    </div>
                    <?php
                    echo "<h5>Name: " .  $_SESSION['Student_Name'] . "</h5>";
                    echo "<h5>Student ID: " .  $_SESSION['Student_ID'] . "</h5>";
                    echo "<h5>Course: " .  $_SESSION['Student_Course'] . "</h5>";
                    ?>
                    <br>
                    <tr>
                        <a style="background-color:royalblue; color:white" href="index.php" class="btn">1st Sem</a>
                        <a style="background-color:royalblue; color:white" href="2nd_sem.php" class="btn">2nd Sem</a>
                        <a style="background-color:royalblue; color:white" href="3rd_sem.php" class="btn">3rd Sem</a>
                        <a style="background-color:gray; color:white" href="4th_sem.php" class="btn">4th Sem</a>
                        <a style="background-color:gray; color:white" href="5th_sem.php" class="btn">5th Sem</a>
                        <a style="background-color:gray; color:white" href="6th_sem.php" class="btn">6th Sem</a>
                        <a style="background-color:silver; color:white" href="7th_sem.php" class="btn">7th Sem</a>
                        <a style="background-color:gray; color:white" href="8th_sem.php" class="btn">8th Sem</a>
                        <a style="background-color:gray; color:white" href="9th_sem.php" class="btn">9th Sem</a>
                    </tr>
                    <br>
                    <br>
                    <?php
                    // Include config file
                    require_once "config.php";
                    
                    // Attempt select query execution
                    $sql = "SELECT * FROM result WHERE Student_ID = '" .$_SESSION['Student_ID']. "' and Result_Sem = 7";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>Module Code</th>";
                                        echo "<th>Module Name</th>";
                                        echo "<th>Credit Value</th>";
                                        echo "<th>Module Sem</th>";
                                        echo "<th>Module Grade</th>";
                                        echo "<th>Grade Point</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                $GPA = 0;
                                $TOTAL_C = 0;
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        $module = "SELECT * FROM modules WHERE Module_Code = '". $row['Module_Code'] ."'";
                                        $in = mysqli_query($link, $module);
                                        $dat = mysqli_fetch_array($in);
                                        echo "<td>" . $row['Module_Code'] . "</td>";
                                        echo "<td>" . $dat['Module_Name'] . "</td>";
                                        echo "<td>" . $dat['Credit_Value'] . "</td>";
                                        echo "<td>" . $row['Result_Sem'] . "</td>";
                                        echo "<td>" . $row['Result_Grade'] . "</td>";
                                        if ($row['Result_Grade'] == 'A+' || $row['Result_Grade'] == 'A'){
                                            $gp = 4.00;
                                            echo "<td>", number_format($gp, 2), "</td>";
                                        }
                                        elseif ($row['Result_Grade'] == 'A-'){
                                            $gp = 3.67;
                                            echo "<td>", number_format($gp, 2), "</td>";
                                        }
                                        elseif ($row['Result_Grade'] == 'B+'){
                                            $gp = 3.33;
                                            echo "<td>", number_format($gp, 2), "</td>";
                                        }
                                        elseif ($row['Result_Grade'] == 'B'){
                                            $gp = 3.00;
                                            echo "<td>", number_format($gp, 2), "</td>";
                                        }
                                        elseif ($row['Result_Grade'] == 'B-'){
                                            $gp = 2.67;
                                            echo "<td>", number_format($gp, 2), "</td>";
                                        }
                                        elseif ($row['Result_Grade'] == 'C+'){
                                            $gp = 2.33;
                                            echo "<td>", number_format($gp, 2), "</td>";
                                        }
                                        elseif ($row['Result_Grade'] == 'C'){
                                            $gp = 2.00;
                                            echo "<td>", number_format($gp, 2), "</td>";
                                        }
                                        elseif ($row['Result_Grade'] == 'F'){
                                            $gp = 0.00;
                                            echo "<td>", number_format($gp, 2), "</td>";
                                        }
                                        else{
                                            $gp = 0.00;
                                            echo "<td></td>";
                                        }
                                    echo "</tr>";
                                    $GPA = $GPA + ($gp * $dat['Credit_Value']);
                                    $TOTAL_C = $TOTAL_C + $dat['Credit_Value'];
                                }
                                echo "</tbody>";                            
                                echo "<tr>";
                                echo "<td></td>";
                                echo "<td></td>";
                                echo "<td></td>";
                                echo "<td></td>";
                                echo "<td>GPA</td>";
                                echo "<td>", number_format($GPA/$TOTAL_C, 2), "</td>";
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
 
                    // Close connection
                    mysqli_close($link);
                    ?>
                    <a href="logout.php" class="btn btn-danger">Logout</a>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>