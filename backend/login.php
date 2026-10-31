<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // የተደበቀውን ፓስወርድ ማረጋገጥ
        if (password_verify($password, $user['password'])) {
            // Session መክፈት
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // ወደ Dashboard ገጽ Redirect ማድረግ
           header("Location: dashboard.php"); // 
            exit();
        } else {
            echo "<script>alert('የተሳሳተ ፓስወርድ አስገብተዋል!'); window.location.href='login.html';</script>";
        }
    } else {
        echo "<script>alert('በዚህ ኢሜይል የተመዘገበ አካውንት አልተገኘም!'); window.location.href='login.html';</script>";
    }
}
?>
