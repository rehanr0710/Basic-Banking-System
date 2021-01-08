<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "BankingSystem";
// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST['submit']))
{
    $from = $_POST['from'];
    $to = $_POST['to'];
    $amount = $_POST['amount'];

    $sql = "SELECT * from customers where id=$from";
    $query = mysqli_query($conn,$sql);
    $sql1 = mysqli_fetch_array($query); // returns array or output of user from which the amount is to be transferred.

    $sql = "SELECT * from customers where id=$to";
    $query = mysqli_query($conn,$sql);
    $sql2 = mysqli_fetch_array($query);
    
    // constraint to check input of negative value by user
    if (($amount)<0)
   {
        echo '<script type="text/javascript">';
        echo ' alert("Oops! Negative values cannot be transferred")';  // showing an alert box.
        echo '</script>';
    }

    // constraint to check insufficient balance.
    else if($amount > $sql1['Balance']) 
    {
        echo '<script type="text/javascript">';
        echo ' alert("Bad Luck! Insufficient Balance")';  // showing an alert box.
        echo '</script>';
    }

    // constraint to check zero values
    else if($amount == 0){
         echo "<script type='text/javascript'>";
         echo "alert('Oops! Zero value cannot be transferred')";
         echo "</script>";
     }
    else {
                // deducting amount from sender's account
                $newbalance = $sql1['Balance'] - $amount;
                $sql = "UPDATE customers set Balance=$newbalance where Id=$from";
                mysqli_query($conn,$sql);
             
                // adding amount to reciever's account
                $newbalance = $sql2['Balance'] + $amount;
                $sql = "UPDATE Customers set Balance=$newbalance where Id=$to";
                mysqli_query($conn,$sql);
                
                $sender = $sql1['Username'];
                $receiver = $sql2['Username'];
                $sql = "INSERT INTO history(`Srno`, `Sender`, `Receiver`, `Amount`, `Datetime`) VALUES (NULL,'$sender','$receiver','$amount',current_timestamp())";
                $query=mysqli_query($conn,$sql);

                if($query){
                     echo "<script> alert('Transaction Successful');
                                     window.location='history.php';
                           </script>";                    
                }
                $newbalance= 0;
                $amount =0;
        }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Basic Banking System</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }
      .wrapper{
        margin: auto;
        margin-top: 170px;
        width: 30%;
        height: 400px;
        box-shadow: 0 27px 87px rgba(256, 256, 256, 5);
        padding: 10px;
        background-color: #fff;
        border-radius: 15px;
        font-family: sans-serif;
      }
      .tab {
        display: inline-block;
        margin-left: 40px;
      }
      .para{
        margin-top: 10%;
        margin-left: 40px;
        margin-bottom: 70px;
      }
      .value{
        margin-left: 40px;
      }
      .btn{
        margin-top: 7%;
        margin-left: 190px;
        padding: 12px 20px;
        border-radius: 10px;
        border: none;
        background: linear-gradient(to left, #1c79e2, #f802f5);
        color: #fff;
        font-size: 15px;
        font-family: "Calibri";
        cursor: pointer;
        text-align: center;
        box-shadow: 0 27px 87px rgba(0, 0, 0, 4);
      }
    </style>
  </head>
  <body>
    <!-- Navigation Bar code starts here -->
    <ul>
      <li><a href="../index.html">Home</a></li>
      <li><a href="viewCustomers.php">View All Customers</a></li>
      <li><a href="transfer.php">Transfer Money</a></li>
      <li><a href="history.php">History</a></li>
    </ul>
    <script type="text/javascript">
      const currentLocation = location.href;
      const menuItem = document.querySelectorAll('a');
      const menuLength = menuItem.length;
      for(let i = 0; i < menuLength; i++){
        if(menuItem[i].href === currentLocation){
          menuItem[i].className = "active"
        }
      }
    </script>
    <!-- Navigation Bar code ends here -->
    <div class="wrapper">
      <p>&nbsp</p>
      <p><span class="tab"></span><strong>Transfer Money</strong></p>
      <!-- Transfer code starts here -->
      <div>
        <form method="post" name='tcredit'>
          <p class="para">From -<span class="tab">
            <select name="from" class="form-control" required>
              <option value="" disabled selected>Choose</option>
              <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "BankingSystem";
                // Create connection
                $conn = new mysqli($servername, $username, $password,$dbname);
      
                // Check connection
                if ($conn->connect_error) {
                  die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT * FROM customers";
                $result=mysqli_query($conn,$sql);
                if(!$result)
                {
                    echo "Error ".$sql."<br>".mysqli_error($conn);
                }
                while($rows = mysqli_fetch_assoc($result)) {
              ?>
                <option class="table" value="<?php echo $rows['Id'];?>" >
                        
                        <?php echo $rows['Username'] ;?> (Balance: 
                        <?php echo $rows['Balance'] ;?> ) 
                        
                    </option>
              <?php 
                  }
              ?>
              </option>
            </select>
          </p>
          <p class="para">To -<span class="tab">&nbsp&nbsp&nbsp
            <select name="to" class="form-control" required>
              <option value="" disabled selected>Choose</option>
              <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "BankingSystem";
                // Create connection
                $conn = new mysqli($servername, $username, $password,$dbname);
      
                // Check connection
                if ($conn->connect_error) {
                  die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT * FROM customers";
                $result=mysqli_query($conn,$sql);
                if(!$result)
                {
                    echo "Error ".$sql."<br>".mysqli_error($conn);
                }

                while($rows = mysqli_fetch_assoc($result)) {
              ?>
                <option class="table" value="<?php echo $rows['Id'];?>" >
                        
                        <?php echo $rows['Username'] ;?> 
                        
                    </option>
              <?php 
                  }
              ?>
              </option>
            </select>
          </p>
          <label for="Amount" class="value" >Amount -<span class="tab"></span></label>
          <input type="number" name="amount" required>
          <div class="text-center" >
            <button class="btn" type="submit" name="submit" id="myBtn">Transfer</button>
          </div>
        </form>
      </div>
    </div>
  </body>
</html>