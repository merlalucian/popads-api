<?php
$servername = "localhost";
$username = "###";
$password = "###";
$dbname = "###";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM api";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
$state ='';
$valid ='';
$idd=$row['id'];
$url='';
$ch='';
$fields_string='';
$fields='';
//The url you wish to send the POST request

$url= 'https://www.popads.net/api/report_advertiser?key=###&campaigns='.$row['id_campaign'].'&groups=website';
//echo $url;
//The data you want to send via POST
$fields = [
  '__VIEWSTATE '      => $state,
  '__EVENTVALIDATION' => $valid,
  'btnSubmit'         => 'Submit'
];

//url-ify the data for the POST
$fields_string = http_build_query($fields);

//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_POST, true);
curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

//So that curl_exec returns the contents of the cURL; rather than echoing it
curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 

//execute post
$result2 = curl_exec($ch);
$arr = json_decode($result2, true);

//Here build your code to get the data from $arr
//etc.


//Test to see array structure

echo "for campaign:";
echo $row['campaign'];
echo "delete";
foreach($arr['rows'] as $camp){
$impressions=$camp['impressions'];
$cost = $camp['cost'];
$website = $camp['website_id'];
$count = $camp['conversion_count'];
$site = array();

if ($cost > $row['cpa'] &&  $count== 0)
{
	
	echo $website; echo ',';
	
}

if ($impressions > $row['click'] &&  $count== 0)
{	
	echo $website; echo ',';
	
}

}

    }
} else {
    echo "0 results";
}


?>