<?php
/* User Profile  */
 session_start();

 include ('connectdb.php');
 include ('functions.php');
 include ('includes/head.php');
 include ('includes/navigation.php');

 //To design pagination foor users-->
/*$limit = 10;
 if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };
 $start_from = ($page-1) * $limit;

 //To design pagination for tweets-->
$limit2 = 5;
 if (isset($_GET["page2"])) { $page2  = $_GET["page2"]; } else { $page2=1; };
 $start_from2= ($page2-1) * $limit2;*/

// User page
 if(isset($_GET["id"])) {
   $userid = $_GET["id"];
 ?>
<!-- The content is organized in three columns-->

<!-- Display User name-->
<div class="col-md-3" style="margin-top:30px" >
<?php
list($fn,$ln) = getUserName($userid);
?>
<h1><?php echo $fn . " " . $ln; ?></h1>

<!--Display the followers and the following-->
<form action="followUser.php" method="post">
    <input type="hidden" name="userId" value="<?php echo $userid ?>" />
    <p>
      <?php
       echo '<a class="followList" href="userProfile.php?id=' . $userid . '&following=true">Followings: </a>';
       echo getFollowingNum($userid); ?> <br/><br/>
      <?php
       //This list all the followings when the user click
       if(isset($_GET["following"])) {
             getFollowing($userid);
       }


       echo '<a class="followList" href="userProfile.php?id=' . $userid . '&follower=true">Followers: </a>';
       echo getFollowersNum($userid); ?> <br/><br/>
      <?php
       //This list all the followers when the user click
       if(isset($_GET["follower"])) {
             getFollowers($userid);
       }
   //Determine to follow or Unfollow the user
   followButton($userid); ?>
    </p>
  </form>

</div>

<!-- User Profile-->
<div class="col-md-5"  style="margin-top:100px">
<div class="row">

  <?php
if(!isset($_GET["search"])) {

  if(isset($_SESSION["userId"]) && $_SESSION["userId"] == $userid) :?>

<!--User can write the tweet here and post it-->
    <form action="postTweet.php" method="post">
      <input type="hidden" name="userId" value="<?php echo $userid ?>" />
      <div style="font-size:18px;padding:10px;font-weight:bold; text-align:center">
      Write your Tweet
      </div>
      <textarea name="tweet"></textarea>
      <br />
      <input type="submit" value="Submit" />
      <br />
      <br />
    </form>
  <?php endif; ?>
  <!--Display the timeline-->
    <div style="font-size:18px;padding-top:30px;font-weight:bold; text-align:center">
    Timeline
    </div>
  <div style="background-color: #f2f2f2">
      <?php
      getTweets($userid);
      echo "<br />";
      /*getTweets($userid,$start_from2,$limit2);
      echo "<br />";
      //To display the pagination at the end
      /*$nr_tweets=getTweetNum($userid);
      $total_pages = ceil($nr_tweets / $limit2);

      $pagLink="";
      for ($i=1; $i<=$total_pages; $i++)
      {
               $pagLink .= "<a href='userProfile.php?id=". $userid."&page=".$i."' style='text-align:center'>".$i."</a>     ";
      }
      echo $pagLink;*/
      ?>
  </div>
  <?php
  }

  else {
  $tweetSearchFor = $_GET["search"];
  searchTweets($userid, $tweetSearchFor);
  }


   ?>
  </div>
  </div>


  <div class="col-md-3" style="margin-left:100px; margin-top:20px">

    <!--Form that is used to search for tweets-->
        <form action="searchTweets.php" method="post">
          <div style="font-size:14px;font-weight:bold; text-align:left">
          Search in the tweets
          </div>
          <input type="text" name="searchTweet" value="<?php echo isset($_GET["search"]) ? $_GET["search"] : '' ?>" size="20">
          <input type="submit" value="Submit" />
          <br />
          <br />
        </form>

        <!--Form that is used to search for Users-->
            <form action="searchUsers.php" method="post" style="margin-top:15px">
              <div style="font-size:14px;font-weight:bold; text-align:left">
              Search for users
              </div>
              <input type="text" name="searchUsers" value="<?php echo isset($_GET["searchU"]) ? $_GET["searchU"] : '' ?>" size="20">
              <input type="submit" value="Submit" />
              <br />
              <br />
            </form>

  <!-- Display list of other users -->
  <?php
  if(!isset($_GET["searchU"])) {?>
    <span style='font-size:18px;font-weight:bold;padding:40px'>Other Users you can follow</span><br/>
  	<div class="row" style="background-color: #f2f2f2; padding:25px;margin-top:20px;text-align:center">

      <?php
      getOtherUsers($userid);
      echo "<br />";
      /*getOtherUsers($userid,$start_from,$limit);
      echo "<br />";
  //To display the pagination at the end
   $total_users_num=getUsersNum($userid);
   $total_pages = ceil($total_users_num / $limit);

  $pagLink="";
  for ($i=1; $i<=$total_pages; $i++) {
               $pagLink .= "<a href='userProfile.php?id=". $userid."&page=".$i."'>".$i."</a>     ";
  }
  echo $pagLink;*/
}


    else {
      ?>
      <!-- Display the results users from the search -->

    	<div class="row" style="background-color: #f2f2f2; padding:25px;margin-top:20px;text-align:center">
    <?php
      $searchUser = $_GET["searchU"];

      searchUsers($userid, $searchUser);
    }  ?>



  	</div>
  </div>
  <?php }?>

  <?php $connDB->close(); ?>
