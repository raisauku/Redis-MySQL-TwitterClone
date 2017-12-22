<?php
/* Function that are use at user profile  */

include 'connectDB.php';

// Function to get the user name and surname

function getUserName($userid) {
  global $connDB;
  /*$sql = "SELECT * FROM Users
          WHERE userId=".$userid;
  $result = $connDB->query($sql);

  if ($result->num_rows > 0) {
     $row = $result->fetch_assoc();
     $firstname = $row["firstName"];
     $lastname = $row["lastName"];

     return array($firstname,$lastname);
   }*/

   //**Fatemeh**
   $firstname = $connDB->hget("user:".$userid,"firstName");
   $lastname = $connDB->hget("user:".$userid,"lastName");
   //echo $firstname." ".$lastname;
   return array($firstname,$lastname);
   //**Fatemeh**
 }

//-----------------------------------------------------------------------------------------------
//Function to get the tweet of the user and the tweets of the users that they follow
function getTweets($userid) {
global $connDB;
$start=microtime(TRUE);
//**Fatemeh**
$allTweets = $connDB-> ZREVRANGEBYSCORE("home:".$userid,"+inf","-inf");
foreach ($allTweets as $tweet)
 {
   $tweetText = $connDB->hget("tweet:".$tweet,"tweetText");
   $tweetUserId = $connDB->hget("tweet:".$tweet,"userId");
   $firstname = $connDB->hget("user:".$tweetUserId,"firstName");
   $lastname = $connDB->hget("user:".$tweetUserId,"lastName");
   $tweetPostedDate = $connDB->hget("tweet:".$tweet,"postedDate");

   echo '<span style="font-size:16px;margin-left:20px">';
   echo '<a class="userTweet" href="userProfile.php?id='.$userid.'">'.$firstname.' '.$lastname.'</a>';
   echo '<div style=" text-align:right;margin-right:10px;font-weight:bold"> '.$tweetPostedDate;

   echo '</div>';
   echo '</span>';
   echo '<span style="font-size:16px;margin-left:20px;color:black">';
   echo $tweetText. "<br />";
   echo '</span>';
   echo '<hr />';
 }
//**Fatemeh**
 $end=microtime(TRUE);
 $timeNeeded=$end-$start;
 echo "Time for the query:".  round($timeNeeded,7). " microseconds";
/* $sql = "SELECT * FROM Tweets
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
 }*/
}
//-----------------------------------------------------------------------------------------------
//Function to get the Followers list (the ones that follow the user account)
function getFollowers($userid) {
  global $connDB;
  $start=microtime(TRUE);
  //**Fatemeh**
  $allfollowers = $connDB-> ZREVRANGEBYSCORE("followers:".$userid,"+inf","-inf");
  foreach ($allfollowers as $follower)
   {
     //search in user hash to get each following info
     $firstNameFollower = $connDB->hget("user:".$follower,"firstName");
     $lastNameFollower = $connDB->hget("user:".$follower,"lastName");
     echo '<a class="userTweet" href="userProfile.php?id=' . $follower . '">' . $firstNameFollower . " " . $lastNameFollower . '</a><br/><br/>';
   }
   //**Fatemeh**
   $end=microtime(TRUE);
  $timeNeeded=$end-$start;
  echo "Time for the query:".  round($timeNeeded,7). " microseconds";
  /*$sql="SELECT * FROM Users
        JOIN Follow ON Users.userId=Follow.userId1
        WHERE userId2=" . $userid."
        ORDER BY followingDate DESC";
  $result=$connDB->query($sql);
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
    echo '<a class="userTweet" href="userProfile.php?id=' . $row["userId1"] . '">' . $row["firstName"] . " " . $row["lastName"] . '</a><br/><br/>';
    }
  }*/
}
//-----------------------------------------------------------------------------------------------
//Function to get the number of the Followers (the ones that  follow the user account)
function getFollowersNum($userid) {
  global $connDB;
  //**Fatemeh**
  $followerNum = $connDB->hget("user:".$userid,"follower");
  //echo $followerNum;
  return $followerNum;
  //**Fatemeh**


  /*$sql="SELECT * FROM Follow
        WHERE userId2=" . $userid;
  $result=$connDB->query($sql);
  return $result->num_rows;*/
}
//-----------------------------------------------------------------------------------------------
//Function to get the Following list (the ones that the user is following)
function getFollowing($userid) {
global $connDB;
$start=microtime(TRUE);
//**Fatemeh**
$allfollowings = $connDB-> ZREVRANGEBYSCORE("followings:".$userid,"+inf","-inf");
foreach ($allfollowings as $following)
 {
   //search in user hash to get each following info
   $firstNameFollowing = $connDB->hget("user:".$following,"firstName");
   $lastNameFollowing = $connDB->hget("user:".$following,"lastName");
   echo '<a class="userTweet" href="userProfile.php?id=' . $following . '">' . $firstNameFollowing . " " . $lastNameFollowing . '</a><br/><br/>';
 }
 //**Fatemeh**
 $end=microtime(TRUE);
     $timeNeeded=$end-$start;
     echo "Time for the query:".  round($timeNeeded,7). " microseconds<br \>";
  /*$sql="SELECT * FROM Users
        JOIN Follow ON Users.userId=Follow.userId2
        WHERE userId1=" . $userid."
        ORDER BY followingDate DESC";
  $result=$connDB->query($sql);
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
    echo '<a class="userTweet" href="userProfile.php?id=' . $row["userId2"] . '">' . $row["firstName"] . " " . $row["lastName"] . '</a><br/><br/>';
    }
  }*/
}
//-----------------------------------------------------------------------------------------------
//Function to get the number of the Following (the ones that the user is following)
function getFollowingNum($userid) {
  global $connDB;

  //**Fatemeh**
  $followingNum = $connDB->hget("user:".$userid,"following");
  //echo $followingNum;
  return $followingNum;
  //**Fatemeh**

  /*$sql="SELECT * FROM Follow
        WHERE userId1=" . $userid;
        $result=$connDB->query($sql);
        return $result->num_rows;*/
}
//-----------------------------------------------------------------------------------------------
//Function to get the total number of users
function getUsersNum($userid) {
  global $connDB;
 $allusers = $connDB-> Hget("num:","user");
 return ($allusers-1);
  /*$sql="SELECT * FROM Users
          WHERE userId<>" . $userid . " AND userId<>" . $_SESSION["userId"] ;

        $result=$connDB->query($sql);
        return $result->num_rows;*/
}

//-----------------------------------------------------------------------------------------------
//Function to get the total number of tweets
function getTweetNum($userid) {
  global $connDB;

  $allTweets = $connDB-> Zcard("home:".$userid);
  return $allTweets;
   }

   /*$sql = "SELECT * FROM Tweets
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
     return $result->num_rows;*/
//-----------------------------------------------------------------------------------------------
//Button that is use to follow another users
function followButton($userid) {
  global $connDB;
  $flag=false;
  if($_SESSION["userId"] != $userid) {
    //**Fatemeh**
    $allfollowings = $connDB-> ZREVRANGEBYSCORE("followings:". $_SESSION["userId"],"+inf","-inf");
    foreach ($allfollowings as $following)
    {
       //search in user hash to get each following info
       if ($following == $userid )
       {
         echo ' <input type="submit" name="unfollow" value="Unfollow">';
         $flag=true;
         break;
       }
    }
    if (!$flag)
      echo '<input type="submit" name="follow" value="Follow">';
   //**Fatemeh**

    /*$sql="SELECT * FROM Follow
          WHERE userId1=" . $_SESSION["userId"] . " AND userId2=" . $userid;

    $result=$connDB->query($sql);
    //If he is following the user he can unfollow
    if($result->num_rows) {
      echo ' <input type="submit" name="unfollow" value="Unfollow">';
    } else {
      echo '<input type="submit" name="follow" value="Follow">';
    }*/
  }
}
//-----------------------------------------------------------------------------------------------
//Get the list of other users (different from the user that is logged in and the one we choose)
function getOtherUsers($userid) {
  global $connDB;
  $start=microtime(TRUE);
  //**Fatemeh**
  $numOfUsers=$connDB->hget("num","user");
  //echo $numOfUsers;
  for ($i=1; $i <+ $numOfUsers ; $i++)
   {
     //in orser not to show the logined user info
     if($i!=$userid)
     {
       $firstName = $connDB->hget( "user:".$i,"firstName");
       $lastName = $connDB->hget( "user:".$i,"lastName");
       echo '<a class="followList" href="userProfile.php?id=' . $i . '">' . $firstName . " " . $lastName . '</a><br/>';
     }

   }
   //**Fatemeh**
   $end=microtime(TRUE);
   $timeNeeded=$end-$start;
   echo "Time for the query:".  round($timeNeeded,7). " microseconds";

/*  $sql = "SELECT * FROM Users
          WHERE userId<>" . $userid . " AND userId<>" . $_SESSION["userId"] ."
          ORDER BY signupDate DESC";
  $result = $connDB->query($sql);

  if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
      echo '<a class="followList" href="userProfile.php?id=' . $row["userId"] . '">' . $row["firstName"] . " " . $row["lastName"] . '</a><br/>';
    }
  }*/
}

//Function to search the tweets
function searchTweets($userid, $tweetSrc) {
global $connDB;
$start=microtime(TRUE);

$wordKey = "word:".$tweetSrc;
$allTweetId = $connDB->smembers($wordKey);
foreach ($allTweetId as $tweetId)
{
  $tweetText = $connDB->hget("tweet:".$tweetId,"tweetText");
  $tweetUserId = $connDB->hget("tweet:".$tweetId,"userId");
  $firstname = $connDB->hget("user:".$tweetUserId,"firstName");
  $lastname = $connDB->hget("user:".$tweetUserId,"lastName");
  $tweetPostedDate = $connDB->hget("tweet:".$tweetId,"postedDate");

  echo '<span style="font-size:16px;margin-left:20px">';
  echo '<a class="userTweet" href="userProfile.php?id='.$tweetUserId.'">'.$firstname.' '.$lastname.'</a>';
  echo '<div style=" text-align:right;margin-right:10px;font-weight:bold"> '.date("d M y / H:i:s", strtotime($tweetPostedDate));

  echo '</div>';
  echo '</span>';
  echo '<span style="font-size:16px;margin-left:20px;color:black">';
  echo $tweetText. "<br />";
  echo '</span>';
  echo '<hr />';
}

$end=microtime(TRUE);
$timeNeeded=$end-$start;
echo "Time for the query:".  round($timeNeeded,7). " microseconds";
}
//--------------------------------------------------------------------------------------

//Function to search for the users by name or last name
function searchUsers($userid,$userSrc)
{
  global $connDB;
  $start=microtime(TRUE);
  $userIdArr=array();

  $allUserIds = $connDB-> ZREVRANGEBYSCORE("firstName:".$userSrc,"+inf","-inf");
  foreach ($allUserIds as $userId)
  {
     //search in user hash to get each following info
     $userIdArr[]=$userId["lastName"];
     $firstname = $userSrc;
     $lastname = $userId["lastName"];
    echo '<a class="followList" href="userProfile.php?id=' . $userId . '">' . $firstname  . " " . $lastname . '</a><br/>';
   }
   $allUserIds = $connDB-> ZREVRANGEBYSCORE("lastName:".$userSrc,"+inf","-inf");
   foreach ($allUserIds as $userId)
   {
      //search in user hash to get each following infoif()
      if(!(in_array($userId, $userIdArr)))
      {
        $firstname = $connDB->hget("user:".$userId,"firstName");
        $lastname = $connDB->hget("user:".$userId,"lastName");
        $signupDate = $connDB->hget("user:".$userId,"signupDate");
        echo '<a class="followList" href="userProfile.php?id=' . $userId . '">' . $firstname  . " " . $lastname . '</a><br/>';
      }

    }
//---------------------------------------------------------------------
  $end=microtime(TRUE);
  $timeNeeded=$end-$start;
  echo "Time for the query:".  round($timeNeeded,7). " microseconds";
}



?>
