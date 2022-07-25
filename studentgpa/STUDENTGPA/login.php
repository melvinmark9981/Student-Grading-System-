<?php
session_start();

require_once "config.php";

if(isset($_SESSION['Student_ID'])!="") {
    header("Location: index.php");
}

if (isset($_POST['login'])) {
    $ID = mysqli_real_escape_string($link, $_POST['Stu_ID']);

    $result = mysqli_query($link, "SELECT * FROM student WHERE Student_ID = '" . $ID. "'");
   if(!empty($result)){
        if ($row = mysqli_fetch_array($result)) {
            $_SESSION['Student_ID'] = $row['Student_ID'];
            $_SESSION['Student_Name'] = $row['Student_Name'];
            $_SESSION['Student_Course'] = $row['Student_Course'];
            header("Location: index.php");
        } 
    }else {
        echo "Invalid Student ID!!!";
        header("Location: error.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GPA Checking System</title>
     <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-10">
                <div class="page-header">
                    <h2>WELCOME TO GPA CHECKING SYSTEM !</h2>
                </div>
                <p>Please fill your Student ID in the form</p>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                    <div class="form-group ">
                        <label>Student ID</label>
                        <input type="number" name="Stu_ID" class="form-control" value="" maxlength="30" required="">
                        <p>TIPS: Insert ID within 220001 and 220003.</p>
                    </div>
                    
                    <input type="submit" class="btn btn-primary" name="login" value="login">
 
                </form>
            </div>
        </div>     
    </div>
</body>
</html>
