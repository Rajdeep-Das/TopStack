<?php
/**
 * User: Rajdeep
 * Date: 8/5/2017
 * Time: 4:10 PM
 */
/* TODO:only availabe when user complete his profile */
session_start();
require_once 'class.user.php';
$user = new USER();

if($user->is_logged_in()!="")
{
    $stmt = $user->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
    $stmt->execute(array(":uid"=>$_SESSION['userSession']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);


}else
{
    $user->redirect('login.php');
}
?>
<?php echo $row['user_email']; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>TopStack-Course Enroll</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <div class="row">
        <p></p>
        <p></p>
        <p></p>
        <p></p>
        <?php if(isset($msg)) echo $msg;  ?>
        <div class="panel panel-info">
            <div class="panel-heading">
                <h2>Course Enrollment</h2></div>

            <div class="panel-body">

                <div class="col-md-12">

                    <form role="form" id="userdetils-form" autocomplete="off" method="post">
                        <div class="form-group">
                            <label for="email">Name:</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter Name" name="name" value="<?php echo $row['userName']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" value="<?php echo $row['userEmail']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="pwd">Phone:</label>
                            <input type="phone" class="form-control" id="phone" placeholder="Enter phone" name="phone" value="<?php echo $row['userPhone']; ?>">
                        </div>

                        <div class="form-group">
                            <label for="email">Intitute Name:</label>
                            <input type="text" class="form-control" id="institute_name" placeholder="Enter Institute Name" name="institute_name">
                        </div>
                        <div class="form-group">
                            <label for="email">Qualification:</label>
                            <input type="text" class="form-control" id="qualification" placeholder="Enter qualification" name="qualification">
                        </div>
                        <div class="form-group">
                            <label for="email">Address:</label>
                            <textarea class="form-control" id="address" placeholder="Enter Address" name="address" value=""></textarea>
                        </div>

                        <button type="submit" class="btn btn-success btn-lg" name="btn-signup">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


</body>
</html>

