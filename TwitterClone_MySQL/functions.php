<?php
/* Function that are use at user profile  */

include 'connectDB.php';

// Function to get the user name and surname

function getUserName($userid) {
  global $connDB;
  $sql = "SELECT * FROM Users
          WHERE userId=".$userid;
  $result = $connDB->query($sql);

  if ($result->num_rows > 0) {
     $row = $result->fetch_assoc();
     $firstname = $row["firstName"];
     $lastname = $row["lastName"];

     return array($firstname,$lastname);
   }
 }


 //Function to get the tweet of the user and the tweets of the users that they follow. Use start_from and limit for paginations
 function getTweets($userid,$start_from,$limit) {
 global $connDB;
 $start=microtime(TRUE);
  $sql = "SELECT * FROM Tweets
          JOIN Users ON Tweets.userId = Users.userId
          WHERE Tweets.userId=".$userid."
          ORDER BY postedDate DESC
          LIMIT $start_from, $limit";

  if($_SESSION["userId"] == $userid) {
    // include comments from followed users only, in the profile of the user that is login
    $sql = "SELECT * FROM Tweets
            JOIN users ON Tweets.userId = Users.userId
            WHERE Tweets.userId=".$userid."
            OR Tweets.userId IN (SELECT userId2 FROM Follow WHERE userId1=".$userid.")
            ORDER BY postedDate DESC
            LIMIT $start_from, $limit";
  }

  $result = $connDB->query($sql);

  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      echo '<span style="font-size:16px;margin-left:20px">';
      echo '<a class="userTweet" href="userProfile.php?id='.$row["userId"].'">'.$row["firstName"].' '.$row["lastName"].'</a>';
      echo '<div style=" text-align:right;margin-right:10px;font-weight:bold"> '.date("d M y / H:i:s", strtotime($row["postedDate"]));

      echo '</div>';
      echo '</span>';
      echo '<span style="font-size:16px;margin-left:20px;color:black">';
      echo $row["tweetText"]. "<br />";
      echo '</span>';
      echo '<hr />';
    }
  }

  $end=microtime(TRUE);
  $timeNeeded=$end-$start;
//  echo "Time for the query:".  round($timeNeeded,7). " microseconds";

 }


//Function to get the Followers list (the ones that follow the user account)
function getFollowers($userid) {
  global $connDB;
  $start=microtime(TRUE);
  $sql="SELECT * FROM Users
        JOIN Follow ON Users.userId=Follow.userId1
        WHERE userId2=" . $userid."
        ORDER BY followingDate DESC";
  $result=$connDB->query($sql);
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
    echo '<a class="userTweet" href="userProfile.php?id=' . $row["userId1"] . '">' . $row["firstName"] . " " . $row["lastName"] . '</a><br/><br/>';
    }
    }
    $end=microtime(TRUE);
    $timeNeeded=$end-$start;
  //  echo "Time for the query:".  round($timeNeeded,7). " microseconds";
}

//Function to get the number of the Followers (the ones that  follow the user account)
function getFollowersNum($userid) {
  global $connDB;
  $sql="SELECT * FROM Follow
        WHERE userId2=" . $userid;
  $result=$connDB->query($sql);
  return $result->num_rows;
}


//Function to get the Following list (the ones that the user is following)
function getFollowing($userid) {
  global $connDB;
  $start=microtime(TRUE);
  $sql="SELECT * FROM Users
        JOIN Follow ON Users.userId=Follow.userId2
        WHERE userId1=" . $userid."
        ORDER BY followingDate DESC";
  $result=$connDB->query($sql);
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
    echo '<a class="userTweet" href="userProfile.php?id=' . $row["userId2"] . '">' . $row["firstName"] . " " . $row["lastName"] . '</a><br/><br/>';
    }
    }
    $end=microtime(TRUE);
    $timeNeeded=$end-$start;
  //  echo "Time for the query:".  round($timeNeeded,7). " microseconds<br \>";
}

//Function to get the number of the Following (the ones that the user is following)
function getFollowingNum($userid) {
  global $connDB;
  $sql="SELECT * FROM Follow
        WHERE userId1=" . $userid;
        $result=$connDB->query($sql);
        return $result->num_rows;
}


//Button that is use to follow another users

function followButton($userid) {
  global $connDB;
  if($_SESSION["userId"] != $userid) {
    $sql="SELECT * FROM Follow
          WHERE userId1=" . $_SESSION["userId"] . " AND userId2=" . $userid;

    $result=$connDB->query($sql);
    //If he is following the user he can unfollow
    if($result->num_rows) {
      echo ' <input type="submit" name="unfollow" value="Unfollow">';
    } else {
      echo '<input type="submit" name="follow" value="Follow">';
    }
  }

}






//Get the list of other users (different from the user that is logged in and the one we choose). Use start_from and limit for Pagination
function getOtherUsers($userid,$start_from,$limit) {
  global $connDB;
  $start=microtime(TRUE);
  $sql = "SELECT * FROM Users
          WHERE userId<>" . $userid . " AND userId<>" . $_SESSION["userId"] ."
          ORDER BY signupDate DESC
          LIMIT $start_from, $limit";
  $result = $connDB->query($sql);

  if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
      echo '<a class="followList" href="userProfile.php?id=' . $row["userId"] . '">' . $row["firstName"] . " " . $row["lastName"] . '</a><br/>';
    }

  }
  $end=microtime(TRUE);
  $timeNeeded=$end-$start;
//  echo "Time for the query:".  round($timeNeeded,7). " microseconds";
}


//Function to search the tweets
function searchTweets($userid, $tweetSrc) {
global $connDB;
$start=microtime(TRUE);
$sql = "SELECT * FROM Tweets
        JOIN users ON Tweets.userId = Users.userId
        WHERE (MATCH (Tweets.tweetText) AGAINST ('".$tweetSrc."' IN NATURAL LANGUAGE MODE))
        AND (Tweets.userId=".$userid."
        OR Tweets.userId IN (SELECT userId2 FROM Follow WHERE userId1=".$userid."))";



$result = $connDB->query($sql);

if ($result->num_rows > 0) {
while($row = $result->fetch_assoc()) {

  echo '<span style="font-size:16px;margin-left:20px">';
  echo '<a class="userTweet" href="userProfile.php?id='.$row["userId"].'">'.$row["firstName"].' '.$row["lastName"].'</a>';
  echo '<div style=" text-align:right;margin-right:10px;font-weight:bold"> '.date("d M y / H:i:s", strtotime($row["postedDate"]));

  echo '</div>';
  echo '</span>';
  echo '<span style="font-size:16px;margin-left:20px;color:black">';
  echo $row["tweetText"]. "<br />";
  echo '</span>';
  echo '<hr />';
}
}
$end=microtime(TRUE);
$timeNeeded=$end-$start;
//echo "Time for the query:".  round($timeNeeded,7). " microseconds";
}


//Function to search for the users by name
function searchUsers($userid,$userSrc) {
  global $connDB;
  $start=microtime(TRUE);
  $sql = "SELECT * FROM Users
            WHERE (MATCH (Users.firstName) AGAINST ('".$userSrc."' IN NATURAL LANGUAGE MODE))
            OR (MATCH (Users.lastName) AGAINST ('".$userSrc."' IN NATURAL LANGUAGE MODE))";


  $result = $connDB->query($sql);

  if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
      echo '<a class="followList" href="userProfile.php?id=' . $row["userId"] . '">' . $row["firstName"] . " " . $row["lastName"] . '</a><br/>';
    }

  }
  $end=microtime(TRUE);
  $timeNeeded=$end-$start;
//  echo "Time for the query:".  round($timeNeeded,7). " microseconds";
}



//-----For Pagination -------


//Function to get the total number of users
function getUsersNum($userid) {
  global $connDB;
  $sql="SELECT * FROM Users
          WHERE userId<>" . $userid . " AND userId<>" . $_SESSION["userId"] ;

        $result=$connDB->query($sql);
        return $result->num_rows;
}


//Function to get the total number of tweets
function getTweetNum($userid) {
  global $connDB;
  global $connDB;
   $sql = "SELECT * FROM Tweets
           JOIN Users ON Tweets.userId = Users.userId
           WHERE Tweets.userId=".$userid."
           ORDER BY postedDate DESC";

   if($_SESSION["userId"] == $userid) {
     // include comments from followed users only in the profile of the user that is login
     $sql = "SELECT * FROM Tweets
             JOIN users ON Tweets.userId = Users.userId
             WHERE Tweets.userId=".$userid."
             OR Tweets.userId IN (SELECT userId2 FROM Follow WHERE userId1=".$userid.")
             ORDER BY postedDate DESC";
   }

   $result = $connDB->query($sql);
     return $result->num_rows;
}


?>
