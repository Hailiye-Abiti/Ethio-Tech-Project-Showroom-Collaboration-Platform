<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // ፓስወርዱን በደህንነት መደበቅ (Hashing)
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // ኢሜይሉ ከዚህ ቀደም የተመዘገበ መሆኑን ማረጋገጥ
    $checkEmail = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $result = $checkEmail->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('ይህ ኢሜይል ከዚህ ቀደም ተመዝግቧል! እባክዎ በሌላ ይሞክሩ።'); window.location.href='register.html';</script>";
    } else {
        // አዲስ ተጠቃሚ መመዝገብ
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashed_password);

        if ($stmt->execute()) {
            // ከተመዘገበ በኋላ በቀጥታ ወደ Login ገጽ መላክ (Redirect)
            echo "<script>alert('በተ his ተመዝግበዋል! አሁን ይግቡ (Login)።'); window.location.href='login.html';</script>";
            exit();
        } else {
            echo "ስህተት ተፈጥሯል፡ " . $conn->error;
        }
    }
}
?>
