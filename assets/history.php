<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Basic Banking System</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style type="text/css">
    /* Internal Style sheet */
      table{
        border-collapse: collapse;
        width: 100%;
        margin-top: 46px;
        color: #fff;
        font-family: monospace;
        font-size: 25px;
        text-align: center;
      }
      td{
          padding-bottom: 15px;
          padding-top: 15px;
      }
      th{
        background-color: #d96459;
        color: white;
        padding: 25px;
      }
      tr:first-child{
        margin-bottom: 10px;
      }
      tr:nth-child(even){
        background-color: #f2f2f2;
        color: black;
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
    <table>
      <thead>
        <tr><th>Sr. No.</th><th>Sender</th><th>Receiver</th><th>Amount</th><th>Date & Time</th></tr>
      </thead>
      <tbody>
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

          //sql query to display all
          $sql = "SELECT * FROM history";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
              echo "<tr><td>".$row["Srno"]."</td><td>".$row["Sender"]."</td><td>".$row["Receiver"]."</td><td>".$row["Amount"]."</td><td>".$row["Datetime"]."</td></tr>";
            }
          } else {
            echo "0 results";
          }
          $conn->close();
        ?>
      </tbody>
    </table>
  </body>
</html>