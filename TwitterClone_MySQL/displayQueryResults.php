<?php
/* User Profile  */
 session_start();

 include ('connectdb.php');
include ('queries.php');
 include ('includes/head.php');


?>

<html>
<head>
<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 80%;
    margin-left:50px;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>
</head>
<body>

<table>
  <col width="100">
 <col width="80">
 <col width="50">
  <tr>
    <th>Query</th>
    <th>Result</th>
    <th>Necessary Time</th>
  </tr>
  <tr>
    <td  style="font-weight: bold;">Find a user's followers who started following the user after his/her (user's) first tweet</td>
    <td><?php  $time= getFollowersforUser(2);;?></td>
    <td>The necessary time for the queri is: <?php echo $time?> microseconds.</td>
  </tr>

  <tr>
    <td  style="font-weight: bold;">Function to get the Users Followers list (the ones that follow the user account) that stared following the user after his first tweet</td>
    <td><?php  $time= findSpecificTweets("what");?></td>
    <td>The necessary time for the queri is: <?php echo $time?> microseconds.</td>
  </tr>


  <tr>
    <td  style="font-weight: bold;">Update the male users' countries to Belgium who has more than 10 followers and 10 followings</td>
    <td><?php  $time= updateCountry("Belgium") ;?></td>
    <td>The necessary time for the queri is: <?php echo $time?> microseconds.</td>
  </tr>
</table>

</body>
</html>




<?php $connDB->close(); ?>
