<?php 


$url = "http://rivals.yahoo.com/ncaa/basketball/teams?type=schoolname&query=A";

$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $url); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
$data = curl_exec($ch); 
curl_close($ch);

$newDom = new domDocument;
$newDom->loadHTML($data);
$newDom->preserveWhiteSpace = false;
$page_tables = $newDom->getElementsByTagName('table');
$teams_table = $page_tables->item(6);
//echo $teams_table->nodeValue;
$teams = $teams_table->getElementsByTagName('tr');
$team_nums = $teams->length;

for($i =2; $i < $team_nums; $i++)
{
	$temp_teams = $teams->item($i)->getElementsByTagName('td');
	$link_value = $temp_teams->item(0)->getElementsByTagName('a');
	$link_destination=$link_value->item(0)->getAttribute("href");
	echo $link_destination;
	$team = $link_value->item(0)->nodeValue;
	echo "Team: ".$team."and Conference: ".$temp_teams->item(1)->nodeValue."<br />";
	
}

//echo "Number of teams = ".$team_nums;
/*
$transfer_rows = $transfer_section->getElementsByTagName('table');

$transfers = explode(",", $transfer_rows->item(4)->nodeValue);


echo $transfer_nums;

for($i =0; $i < $transfer_nums; $i++)
{
	if($i % 4 === 0)
	{
		echo "<br />";
	}
	echo $transfers[$i];
	
	
}
*/

?>