<?php

require_once 'dbconfig.php';

class USER
{
    private $conn;
 
    public function __construct()
    {
        $database = new Database();
        $db = $database->dbConnection();
        $this->conn = $db;
    }
 
    public function runQuery($sql)
    {
        $stmt = $this->conn->prepare($sql);
        return $stmt;
    }
 
    public function lasdID()
    {
        $stmt = $this->conn->lastInsertId();
        return $stmt;
    }
 
    public function register($uname, $email,$phone,$gender,$type, $upass, $code)
    {
        try {
            $password = md5($upass);
            $stmt = $this->conn->prepare("INSERT INTO tbl_users(userName,userEmail,userPass,tokenCode,userPhone,userGender,userType) 
                                                VALUES(:user_name, :user_mail, :user_pass, :active_code,:user_phone,:user_gender,:user_type)");
            $stmt->bindparam(":user_name", $uname);
            $stmt->bindparam(":user_mail", $email);
            $stmt->bindparam(":user_pass", $password);
            $stmt->bindparam(":active_code", $code);
            $stmt->bindparam(":user_phone",$phone);
            $stmt->bindparam(":user_gender",$gender);
            $stmt->bindparam(":user_type",$type);
            /**********************************/
            /*
            $stmt->bindparam(":cgpa",$cgpa);
            $stmt->bindparam(":qualification",$qualification);
            $stmt->bindparam(":address",$address);
            $stmt->bindparam(":institute_name",$institute_name);
            */
             

            $stmt->execute();
            return $stmt;
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
    /*Myadded Extended Funtions tbl_userdetils */
    public function update_details_std($name,$number,$address,$cgpa,$institute_name,$qualification,$dob,$userid)
    {
         try
         {  $query="UPDATE  tbl_users  SET  userName=:std_Name,
                                            userPhone=:std_number,
                                            address=:std_address,
                                            cgpa=:std_cgpa,
                                            institute_name=:std_institutename,
                                            qualification=:std_qualification,
                                            DOB=:DOB WHERE  userID = :std_userid";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindparam(":std_Name", $name);
            //$stmt->bindparam(":std_Email", $email);
            $stmt->bindparam(":std_number", $number);
            $stmt->bindparam(":std_address", $address);

            $stmt->bindparam(":std_userid",$userid);
           
            $stmt->bindparam(":std_cgpa", $cgpa);
            $stmt->bindparam(":std_institutename", $institute_name);
            $stmt->bindparam(":std_qualification",$qualification);
            $stmt->bindparam(":DOB",$dob);
        
            $stmt->execute();
            return $stmt;
         }catch(PDOException $ex)
         {
             echo $ex->getMessage();
         }
    }
    /* Method for uploading profile picture */

    public function update_profile_picture($dp_url,$userid)
    {
        try{
            $query ="UPDATE tbl_users SET  dp_url=:dp_url WHERE userID =:std_userid";
            $stmt = $this->conn->prepare($query);

            $stmt->bindparam(":std_userid",$userid);
            $stmt->bindparam(":dp_url",$dp_url);

            $stmt->execute();
            return $stmt;

        }catch(PDOException $ex)
        {
            echo $ex->getMessage();
        }
    }

 
    public function login($email, $upass)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM tbl_users WHERE userEmail=:email_id");
            $stmt->execute(array(":email_id"=>$email));
            $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
   
            if ($stmt->rowCount() == 1) {
                if ($userRow['userStatus']=="Y") {
                    if ($userRow['userPass']==md5($upass)) {
                        $_SESSION['userSession'] = $userRow['userID'];
                        return true;
                    } else {
                        header("Location: login.php?error");
                        exit;
                    }
                } else {
                    header("Location: login.php?inactive");
                    exit;
                }
            } else {
                header("Location: login.php?error");
                exit;
            }
        } catch (PDOException $ex) {
            echo $ex->getMessage();
        }
    }
 
 
    public function is_logged_in()
    {
        if (isset($_SESSION['userSession'])) {
            return true;
        }
    }
 
    public function redirect($url)
    {
        header("Location: $url");
    }
 
    public function logout()
    {
        session_destroy();
        $_SESSION['userSession'] = false;
    }
 
    function send_mail($email, $message, $subject)
    {
        require_once('PHPMailer_5.2.4/class.phpmailer.php');
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPDebug  = 0;
        $mail->SMTPAuth   = true;
        $mail->SMTPSecure = "ssl";
        $mail->Host       = "smtp.gmail.com";
        $mail->Port       = 465;
        $mail->AddAddress($email);
        $mail->Username="topstackindia@gmail.com";
        $mail->Password="topstack_1234";
        $mail->SetFrom('topstackindia@gmail.com', 'TopStack');
        $mail->AddReplyTo("topstackindia@gmail.com", "TopStack");
        $mail->Subject    = $subject;
        $mail->MsgHTML($message);
        $mail->Send();
    }
}
