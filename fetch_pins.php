<?php
header('Content-Type: application/json');
include 'db.php';

$result=$conn->query("SELECT id, latitude, longitude, message, color, created_at FROM pins ORDER BY created_at DESC");
if(!$result){ echo json_encode(['error'=>$conn->error]); exit; }

$pins=[];
while($row=$result->fetch_assoc()){
    $pins[]=[
        'id'=>$row['id'],
        'latitude'=>$row['latitude'],
        'longitude'=>$row['longitude'],
        'message'=>htmlspecialchars($row['message']),
        'color'=>$row['color'],
        'created_at'=>$row['created_at']
    ];
}
echo json_encode($pins);
?>