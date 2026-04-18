<?php
$ch = curl_init('http://127.0.0.1:8000/calculate');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'Accept: application/json']);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    'followers' => '10000',
    'likes' => '500',
    'comments' => '50',
    'shares' => '10',
    'platform' => 'Instagram',
    'overall_split' => '100',
    'industry_id' => 1
]));
$response = curl_exec($ch);
echo "Response: " . $response . "\n";
echo "HTTP Code: " . curl_getinfo($ch, CURLINFO_HTTP_CODE) . "\n";
