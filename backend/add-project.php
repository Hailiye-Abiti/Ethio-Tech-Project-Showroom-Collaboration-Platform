<?php
session_start();
require_once 'db.php';

// ተጠቃሚው ሎጊን ማድረጉን ማረጋገጥ
if (!isset($_SESSION['user_id'])) {
    header("Location: ../frontend/login.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $title = trim($_POST['title']);
    $tech_stack = trim($_POST['tech_stack']);
    $project_link = trim($_POST['project_link']);
    $image_url = trim($_POST['image_url']);
    $description = trim($_POST['description']);

    // መረጃውን ወደ projects ዳታቤዝ ቴብል ማስገባት
    $stmt = $conn->prepare("INSERT INTO projects (user_id, title, tech_stack, project_link, image_url, description) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $user_id, $title, $tech_stack, $project_link, $image_url, $description);

    if ($stmt->execute()) {
        echo "<script>alert('ፕሮጀክቱ በተሳካ ሁኔታ ተመዝግቧል!'); window.location.href='dashboard.php';</script>";
        exit();
    } else {
        echo "ስህተት ተፈጥሯል: " . $conn->error;
    }
}
?>
