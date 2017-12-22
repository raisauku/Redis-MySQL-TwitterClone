<?php
include 'connectdb.php';
//------------------------------------------------------------------------------
$tweetSrc = "what";
$res=0;
echo "Seacrh for tweets including the word : ".$tweetSrc."<br>";


for ($i=1; $i<=5; $i++)
{
   $start=microtime(TRUE);//START
    $sql = "SELECT * FROM words
            WHERE word=".$tweetSrc;
    $result = $connDB->query($sql);
    if($result)
    {
        while($row = $result->fetch_assoc())
        {
          $sql = "SELECT tweetText FROM tweets
                  WHERE tweetId=".$row["tweetId"].")";
        }
    }

  $end=microtime(TRUE);
  $timeNeeded=$end-$start;
  echo "Iteration ".$i." : ".$timeNeeded."<br>";
  $res= $res + $timeNeeded;
}
$res = $res/5;
echo "Average time for the query : ".  round($res,7). " microseconds"."<br>"."<br>";//END
?>
