<?php
header('Content-Type: application/json');
include 'db.php';

function respond($msg){ echo json_encode(['error'=>$msg]); exit; }

if(!isset($_POST['lat'],$_POST['lng'],$_POST['message'],$_POST['color'])) respond("Missing fields");

$lat=floatval($_POST['lat']);
$lng=floatval($_POST['lng']);
$message=trim($_POST['message']);
$color=trim($_POST['color']);

if(empty($message)) respond("Message cannot be empty");
$validColors=['yellow','blue','red','green','purple','orange'];
if(!in_array($color,$validColors)) respond("Invalid color");

$stmt=$conn->prepare("INSERT INTO pins (latitude, longitude, message, color, created_at) VALUES (?,?,?,?,NOW())");
if(!$stmt) respond("Prepare failed: ".$conn->error);
$stmt->bind_param("ddss",$lat,$lng,$message,$color);
if(!$stmt->execute()) respond("Execute failed: ".$stmt->error);

echo json_encode([
    "id"=>$stmt->insert_id,
    "latitude"=>$lat,
    "longitude"=>$lng,
    "message"=>htmlspecialchars($message),
    "color"=>$color,
    "created_at"=>date("Y-m-d H:i:s")
]);
?>