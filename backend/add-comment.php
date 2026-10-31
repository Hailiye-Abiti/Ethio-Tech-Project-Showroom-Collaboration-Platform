<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $project_id = intval($_POST['project_id']);
    $user_name = trim($_POST['user_name']);
    $comment_text = trim($_POST['comment_text']);

    if (!empty($user_name) && !empty($comment_text) && $project_id > 0) {
        $stmt = $conn->prepare("INSERT INTO comments (project_id, user_name, comment_text) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $project_id, $user_name, $comment_text);
        
        if ($stmt->execute()) {
            // አስተያየቱ ከተመዘገበ በኋላ ወደነበረበት የፕሮጀክት ዝርዝር ገጽ መመለስ
            header("Location: ../frontend/project-detail.php?id=" . $project_id);
            exit();
        } else {
            echo "ስህተት ተፈጥሯል: " . $conn->error;
        }
    } else {
        echo "<script>alert('እባክዎን ሁሉንም መስኮች ይሙሉ!'); window.history.back();</script>";
    }
}
?>
