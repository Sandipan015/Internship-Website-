<?php
// error_reporting(0);
// echo "welcome to php world";
require_once('db/connect.php');

$succes = false;
$error = false;
$errormassage = "";
$successmassage = "";

// Die if connection was not successful
if (!$conn) {
  $image = "assets/img/about-img.jpg";
  echo "<!DOCTYPE HTML><html><head><title>500 Not Found</title></head><body><img src=\"$image\" width=\"200px\" height=\"100px\"/><br>";
  echo "<span style='color:rgba(255,0,0,1);'><b>Oops, something went wrong.</b></span><br><b>500.</b> <span style='color:rgba(0,0,0,0.5);'> That's an internal server error. </span><br><br><br><i>Sorry..!. We cannot proced for internal server error..!.</i><br><span style='color:rgba(255,105,180,1);'>Try to refresh this page or feel free to contact if the problem persists.</span><br>";
  die("<span style='color:rgba(0,0,0,0.5);'> We failed to connect: " . mysqli_connect_error() . " .</span><hr></body></html>");
} else {

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['number']) and isset($_POST['password'])) {

      // get the data
      $logmnumber =  mysqli_real_escape_string($conn, $_POST["number"]);
      $logpass =  mysqli_real_escape_string($conn, $_POST["password"]);

      if ($logmnumber != "" and $logpass != "") {
        # code...
        $filternumber = htmlspecialchars($logmnumber);
        $sql = "SELECT * FROM `db_user_account_reg` WHERE phoneNumber = '$filternumber'";

        $result = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($result);
        if ($num == 1) {
          while ($row = mysqli_fetch_assoc($result)) {
            if (password_verify($logpass, $row['password'])) {
              $login = true;
              session_start();
              $_SESSION['loggedin'] = $login;
              $_SESSION['reg_user_id'] = $row['reg_user_id'];
              $_SESSION['firstname'] = $row['firstname'];
              $_SESSION['lastname'] = $row['lastname'];
              $_SESSION['mobileno'] = $row['phoneNumber'];
              // header("Location: dashboard/dashboard.php");
              $error = false;
              $succes = true;
              $successmassage = "Login Success";
            } else {
              $error = true;
              $errormassage = "Invalid Credentials";
            }
          }
        } else {
          $error = true;
          $errormassage = "Your mobile number not found, Please register first";
        }
      } else {
        # code...
        $error = true;
        $errormassage = "Fillup all the input field..!";
      }
    }
  }
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="Login.css">
</head>

<body>

  <h2>Login Form</h2>
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
  <form action="Login.php" method="post">
    <div class="imgcontainer">
      <img src="assets/img/img_avatar2.png" alt="Avatar" class="avatar">
    </div>

    <div class="container">
      <label for="uname"><b>Mobile number</b></label>
      <input type="text" placeholder="Enter Mobile number" id="number" name="number" required>

      <label for="psw"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" id="password" name="password" required>

      <button type="submit">Login</button>
      <!--label>
        <input type="checkbox" id="rememberMe" checked="checked" name="remember"> Remember me
      </label>
    </div>

    <div class="container" style="background-color:#f1f1f1">
      <button type="button" class="cancelbtn">Cancel</button>
      <span class="psw">Forgot <a href="#">password?</a></span>
    </div-->
  </form>
  <script>
    let rmCheck = document.getElementById("rememberMe"),
      numberInput = document.getElementById("number");

    rmCheck.addEventListener('change', function() {
      if (this.checked) {
        // Checkbox is checked..
        localStorage.username = numberInput.value;
        localStorage.checkbox = rmCheck.value;
      } else {
        // Checkbox is not checked..
        localStorage.username = "";
        localStorage.checkbox = "";
      }
    });


    if (localStorage.checkbox && localStorage.checkbox !== "") {
      rmCheck.setAttribute("checked", "checked");
      numberInput.value = localStorage.username;
    } else {
      rmCheck.removeAttribute("checked");
      numberInput.value = "";
    }
  </script>
</body>

</html>