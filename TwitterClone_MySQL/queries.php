<?php
/* Function that are use at user profile  */

include 'connectDB.php';


//Function to get the Users Followers list (the ones that follow the user account) that stared following the user after his first tweet
function getFollowersforUser($userid) {
  global $connDB;
  $start=microtime(TRUE);
  $sql=" SELECT * FROM Users
        JOIN Follow ON Users.userId=Follow.userId1
         WHERE userId2=".$userid."
         AND followingDate > (SELECT MIN(postedDate) from Tweets JOIN Users ON Users.userId= Tweets.userId AND Users.userId=".$userid.")
        ORDER BY followingDate DESC";
  $result=$connDB->query($sql);
  $end=microtime(TRUE);
  $timeNeeded=$end-$start;

  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
    echo  $row["firstName"] . " " . $row["lastName"] . "<br />" ;
    }
    }
return round($timeNeeded,7);
}

// Find tweets including a word that are posted from 2003 to 2010 by users who joined twitter in 2000
function findSpecificTweets($searchWord) {
  global $connDB;
  $start=microtime(TRUE);
  $sql=" SELECT tweetText FROM tweets
         JOIN users on tweets.userId = users.userId
  WHERE tweetText LIKE '%".$searchWord."%'
  AND (tweets.postedDate BETWEEN '2003-01-01 00:00:00' AND '2010-12-31 23:59:59')
  AND (Users.signupDate  BETWEEN '2000-01-01 00:00:00' AND '2000-12-31 23:59:59')";

  $result=$connDB->query($sql);
  $end=microtime(TRUE);
  $timeNeeded=$end-$start;

  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
    echo  $row["tweetText"]  . "<br />" ;
    }
    }
return round($timeNeeded,7);
}



//Update the male users' countries to Belgium who has more than 1 followers and 1 followings

function updateCountry($country) {
  global $connDB;
  $start=microtime(TRUE);
  $sql="UPDATE users
  SET users.countryId = (select country.countryId from country
  WHERE country.countryName = '".$country."')
  where users.userId in (
  SELECT DISTINCT u1.userId
  FROM
  (SELECT users.userId  FROM Users
          JOIN Follow ON Users.userId=Follow.userId2
          group by follow.userId1
          having (count(*)>10)
          ) u1
   INNER JOIN (Select Users.userId  FROM Users
          JOIN Follow ON Users.userId=Follow.userId1
         group by follow.userId2
          having (count(*)>10)
          )  u2
  ON  u2.userId)";

  $result=$connDB->query($sql);
  $end=microtime(TRUE);
  $timeNeeded=$end-$start;

return round($timeNeeded,7);
}


//Delete users who has not posted any tweets and also their followings and followers have not posted any tweets : "."<br>";




/*This gives the users that have at leat one folowwing withoout tweets



Select   follow.userId2, users.firstName, users.lastName
FROM Follow
JOIN Users ON Users.userId=Follow.userId1
where follow.userId2 IN  ( Select users.userid from users
                         join Follow ON Users.userId=Follow.userId2
                          LEFT JOIN tweets ON users.userId = tweets.userId
                        where tweets.userId IS NULL
)
*/

?>
