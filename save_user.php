<?php
// save_user.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $username = $data['username'];
    $coins = $data['coins'];

    // JSON faylini o'qish
    $jsonFile = 'users.json';
    $jsonData = json_decode(file_get_contents($jsonFile), true);

    // Foydalanuvchi ma'lumotlarini yangilash
    $userFound = false;
    foreach ($jsonData['users'] as &$user) {
        if ($user['username'] === $username) {
            $user['coins'] = $coins; // Tangalarni yangilash
            $userFound = true;
            break;
        }
    }

    // Agar foydalanuvchi topilmasa, yangi foydalanuvchi qo'shish
    if (!$userFound) {
        $jsonData['users'][] = ['username' => $username, 'coins' => $coins];
    }

    // Yangilangan JSON ma'lumotlarini saqlash
    file_put_contents($jsonFile, json_encode($jsonData, JSON_PRETTY_PRINT));

    // Muvaffaqiyatli saqlash xabari
    echo json_encode(['status' => 'success']);
}
?>