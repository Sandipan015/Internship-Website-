<?php
// echo "welcome to php world";
// error_reporting(0);
require_once('db/connect.php');

$succes = false;
$error = false;
$errormassage = "";
$successmassage = "";
$unique_user_id;
// Die if connection was not successful
if (!$conn) {
    echo "<!DOCTYPE HTML><html><head><title>500 Not Found</title></head><body>";
    echo "<span style='color:rgba(255,0,0,1);'><b>Oops, something went wrong.</b></span><br><b>500.</b> <span style='color:rgba(0,0,0,0.5);'> That's an internal server error. </span><br><br><br><i>Sorry..!. We cannot proced for internal server error..!.</i><br><span style='color:rgba(255,105,180,1);'>Try to refresh this page or feel free to contact if the problem persists.</span><br>";
    die("<span style='color:rgba(0,0,0,0.5);'> We failed to connect: " . mysqli_connect_error() . " .</span><hr></body></html>");
} else {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['firstname']) and isset($_POST['lastname']) and isset($_POST["dob"]) and isset($_POST["email"]) and isset($_POST["address"]) and isset($_POST["city"]) and isset($_POST["state"]) and isset($_POST["pin"]) and isset($_POST["phoneNumber"]) and isset($_POST["password"]) and isset($_POST["repassword"])) {
            // get the data
            echo "kgjsrgjon";
            global $errormassage, $error, $successmassage, $succes, $unique_user_id, $conn;
            $firstname =  mysqli_real_escape_string($conn, $_POST["firstname"]);
            $lastname =  mysqli_real_escape_string($conn, $_POST["lastname"]);
            $dob =  mysqli_real_escape_string($conn, $_POST["dob"]);
            $email =  mysqli_real_escape_string($conn, $_POST["email"]);
            $address =  mysqli_real_escape_string($conn, $_POST["address"]);
            $city =  mysqli_real_escape_string($conn, $_POST["city"]);
            $state =  mysqli_real_escape_string($conn, $_POST["state"]);
            $pin =  mysqli_real_escape_string($conn, $_POST["pin"]);
            $phoneNumber =  mysqli_real_escape_string($conn, $_POST["phoneNumber"]);
            $password =  mysqli_real_escape_string($conn, $_POST["password"]);
            $repassword =  mysqli_real_escape_string($conn, $_POST["repassword"]);

            if (!validCheck($firstname, $lastname, $dob, $email, $address, $city, $state, $pin, $phoneNumber, $password, $repassword)) {
                # code...
                $sandDeta = storedata($firstname, $lastname, $dob, $email, $address, $city, $state, $pin, $phoneNumber, $password, $repassword);
            }
        }
    }
}



function storedata($firstname, $lastname, $dob, $email, $address, $city, $state, $pin, $phoneNumber, $password, $conn)
{
    // Check whether this username exists

    global $errormassage, $error, $successmassage, $succes, $unique_user_id, $conn;
    $filterfirstname = htmlspecialchars($firstname);
    $filterlastname = htmlspecialchars($lastname);
    $filteraddress = htmlspecialchars($address);
    $filtercity = htmlspecialchars($city);
    $filterstate = htmlspecialchars($state);

    $existSql = "SELECT * FROM `db_user_account_reg` WHERE phoneNumber='$phoneNumber'";
    $exiresult = mysqli_query($conn, $existSql);
    $numExistRows = mysqli_num_rows($exiresult);
    if ($numExistRows > 0) {
        $error = true;
        $errormassage = "Your mobile number already exist in our system...";
        return $error;
    } else {
        if (filter_var($phoneNumber, FILTER_VALIDATE_INT)) {
            do {
                $dup_check = 0;
                $unique_user_id = rand(100000, 999999);
                while ($row = mysqli_fetch_assoc($exiresult)) {
                    if ($row['reg_user_id'] == $unique_user_id) {
                        # code...
                        $dup_check = 1;
                        break;
                    } else {
                        # code...
                        $dup_check = 0;
                    }
                }
            } while ($dup_check == 1);

            $hashpass = password_hash($password, PASSWORD_DEFAULT);
            // Sql query to be executed
            $sql = "INSERT INTO `db_user_account_reg` (`reg_user_id`, `firstname`, `lastname`, `dob`, `email`, `address`, `city`, `state`, `pin`, `phoneNumber`, `password`, `time`) VALUES ('$unique_user_id', '$filterfirstname', '$filterlastname', '$dob', '$email', '$filteraddress', '$filtercity', '$filterstate', '$pin', '$phoneNumber', '$hashpass', current_timestamp())";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $succes = true;
                $error = false;
                $successmassage = "Your Information submitted successfully.";
                return $error;
            } else {
                $error = true;
                $errormassage = "Sorry we have facing some technical issues.";
                return $error;
            }
        } else {
            $error = true;
            $errormassage = "Enter a valid mobile number!.";
            return $error;
        }
    }
}

function validCheck($firstname, $lastname, $dob, $email, $address, $city, $state, $pin, $phoneNumber, $password, $repassword)
{

    global $errormassage, $error, $successmassage, $succes;
    echo "gopi";
    //check the data is valid or not
    if ($firstname == "" or preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $firstname)) {
        # code...
        $error = true;
        if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $firstname)) {
            $errormassage = "Incorrect, Frist Name only contain character";
        } else {
            $errormassage = "Incorrect, Enter your Frist name";
        }
        return $error;
    } elseif ($lastname == "" or preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $lastname)) {
        # code...
        $error = true;
        if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $lastname)) {
            $errormassage = "Incorrect, Last Name only contain character";
        } else {
            $errormassage = "Incorrect, Enter your last name";
        }
        return $error;
    } elseif ($dob == "" or $dob > date("Y-m-d")) {
        # code...
        $error = true;
        if ($dob > date("Y-m-d")) {
            $errormassage = "Incorrect, Enter Your valid dateofbirth";
        } else {
            $errormassage = "Incorrect, Enter your Present address";
        }
        return $error;
    } elseif ($email == "" or !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        # code...
        $error = true;
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errormassage = "Incorrect, Enter Your valid email";
        } else {
            $errormassage = "Incorrect, Enter your email";
        }
        return $error;
    } elseif ($address == "") {
        # code...
        $error = true;
        $errormassage = "Incorrect, Enter your Present address";
        return $error;
    } elseif ($city == "") {
        # code...
        $error = true;
        $errormassage = "Incorrect, Enter Your city";
        return $error;
    } elseif ($state == "") {
        # code...
        $error = true;
        $errormassage = "Incorrect, Enter Your state";
        return $error;
    } elseif ($pin == "" or strlen($pin) < 5 or strlen($pin) > 7) {
        # code...
        $error = true;
        if (strlen($pin) < 5) {
            $errormassage = "Incorrect, Enter your correct pin number";
        } elseif (strlen($pin) > 7) {
            $errormassage = "Incorrect, Enter your correct pin number";
        } else {
            $errormassage = "Incorrect, Enter your pin number";
        }
        return $error;
    } elseif ($phoneNumber == "" or strlen($phoneNumber) < 9 or strlen($phoneNumber) > 11) {
        # code...
        $error = true;
        if (strlen($phoneNumber) < 9) {
            $errormassage = "Incorrect, Enter your correct number";
        } elseif (strlen($phoneNumber) > 11) {
            $errormassage = "Incorrect, Enter your correct number";
        } else {
            $errormassage = "Incorrect, Enter your number";
        }
        return $error;
    } elseif ($password == "") {
        $error = true;
        $errormassage = "Incorrect, Please Enter your password";
    } elseif ($password != "") {
        # code...

        if ($password <= '7') {
            $error = true;
            $errormassage = "Incorrect, Your Password Must Contain At Least 8 Digits !";
        } elseif (!preg_match("#[0-9]+#", $password)) {
            $error = true;
            $errormassage = "Incorrect, Your Password Must Contain At Least 1 Number !";
        } elseif (!preg_match("#[A-Z]+#", $password)) {
            $error = true;
            $errormassage = "Incorrect, Your Password Must Contain At Least 1 Capital Letter !";
        } elseif (!preg_match("#[a-z]+#", $password)) {
            $error = true;
            $errormassage = "Incorrect, Your Password Must Contain At Least 1 Lowercase Letter !";
        } elseif (!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $password)) {
            $error = true;
            $errormassage = "Incorrect, Your Password Must Contain At Least 1 Special Character !";
        }
        return $error;
    } elseif ($repassword == "" or $password == $repassword) {
        # code...
        $error = true;
        $errormassage = "Incorrect, Retype Password not match";
    } else {
        $error = false;
    }
    
    return $error;
}
?>


<head>
    <link rel="stylesheet" href="Registration.css">
</head>

<body>
    <h1>Registaration Form</h1>
    <div class="container">
        <div class="row">
            <div style="width: 60%;margin: 20px auto;text-align: center;">
                <?php
                if ($succes) { ?>
                    <div style="width: 100%;border: 2px solid green;background-color: rgb(161, 255, 161);color: green;font-weight: bold;padding: 10px;font-size: 18px;border-radius: 10px;"><?php echo $successmassage; ?></div>
                    <?php
                }
                if ($error) { ?>
                    <div style="width: 100%;border: 2px solid red;background-color: rgb(248, 145, 145);color: red;font-weight: bold;padding: 10px;font-size: 18px;border-radius: 10px;"><?php echo $errormassage; ?></div>
                <?php
                } ?>
            </div>
        </div>
        <form action="Rgistration.php" method="POst" enctype="multipart/form-data">
            <div class="row">
                <div class="col-10">
                    <label for="fname">First Name:</label>
                </div>
                <div class="col-90">
                    <input type="text" id="fristname" name="firstname" placeholder="Enter your first name" >
                </div>
            </div>
            <div class="row">
                <div class="col-10">
                    <label for="lname">Last Name:</label>
                </div>
                <div class="col-90">
                    <input type="text" id="lastname" name="lastname" placeholder="Enter your last name">
                </div>
            </div>
            <div class="row">
                <div class="col-10">
                    <label for="dob">Date Of Birth:</label>
                </div>
                <div class="col-90">
                    <input type="Date" id="dob" name="dob">
                </div>
            </div>
            <div class="row">
                <div class="col-10">
                    <label for="email">Email:</label>
                </div>
                <div class="col-90">
                    <input type="email" id="email" name="email" placeholder="it should contain @,.">
                </div>
            </div>
            <div class="row">
                <div class="col-10">
                    <label for="address">Address:</label>
                </div>
                <div class="col-90">
                    <textarea name="address" id="address" cols="30" rows="5"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-10">
                    <label for="city">City:</label>
                </div>
                <div class="col-90">
                    <input type="text" id="city" name="city">
                </div>
            </div>
            <div class="row">
                <div class="col-10">
                    <label for="state">State:</label>
                </div>
                <div class="col-90">
                    <input type="text" id="state" name="state">
                </div>
            </div>
            <div class="row">
                <div class="col-10">
                    <label for="pincode">Area PIN:</label>
                </div>
                <div class="col-90">
                    <input type="number" id="pin" name="pin" maxlength="6">
                </div>
            </div>
            <div class="row">
                <div class="col-10">
                    <label for="phoneNumber">Phone Number:</label>
                </div>
                <div class="col-90">
                    <input type="tel" id="phoneNumber" name="phoneNumber" placeholder="only 10 digits are allowed">
                </div>
            </div>
            <div class="row">
                <div class="col-10">
                    <label for="Password">Password:</label>
                </div>
                <div class="col-90">
                    <input type="text" id="Password" name="password">
                </div>
            </div>
            <div class="row">
                <div class="col-10">
                    <label for="Password">Retype Password:</label>
                </div>
                <div class="col-90">
                    <input type="text" id="repassword" name="repassword">
                </div>
            </div>
            <div class="row">
                <p>
                    <input type="submit" value="Register Now">
                </p>

            </div>
        </form>
    </div>
</body>

</html>