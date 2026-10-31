<?php
require_once '../backend/db.php';

// በ URL በኩል የፕሮጀክት ID መምጣቱን ማረጋገጥ (ለምሳሌ: project-detail.php?id=1)
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: ../index.html");
    exit();
}

$project_id = intval($_GET['id']);

// ከዳታቤዝ የዚያን የተወሰነ ፕሮጀክት መረጃ ከነ ዩዘሩ ስም ጋር አብሮ ማምጣት
$stmt = $conn->prepare("SELECT projects.*, users.username FROM projects JOIN users ON projects.user_id = users.id WHERE projects.id = ?");
$stmt->bind_param("i", $project_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script>alert('ፕሮጀክቱ አልተገኘም!'); window.location.href='../index.html';</script>";
    exit();
}

$project = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($project['title']); ?> - EthioTech Hub</title>
    <link rel="stylesheet" href="../frontend/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <!-- Navigation Bar -->
    <header>
        <div class="logo">
            <h2><a href="../index.html" style="text-decoration:none; color:inherit;"><i class="fa-solid fa-code"></i> EthioTech Hub</a></h2>
        </div>
        <nav>
            <a href="../index.html">Home</a>
            <a href="../frontend/add-project.html"><i class="fa-solid fa-plus"></i> Add Project</a>

            <a href="../frontend/login.html" class="btn-login">Login</a>
            
        </nav>
    </header>

    <!-- Project Detail Container -->
    <main class="container detail-container">
        <a href="dashboard.php" class="btn-back"><i class="fa-solid fa-arrow-left"></i> Back to Projects</a>

        <div class="project-detail-card">
            <img src="<?php echo !empty($project['image_url']) ? htmlspecialchars($project['image_url']) : 'https://via.placeholder.com/800x400'; ?>" alt="Project Image" class="detail-img">
            
            <div class="detail-body">
                <span class="tech-badge"><?php echo htmlspecialchars($project['tech_stack']); ?></span>
                <h1><?php echo htmlspecialchars($project['title']); ?></h1>
                <p class="project-author">
                    <i class="fa-solid fa-user"></i> By <strong><?php echo htmlspecialchars($project['username']); ?></strong> | 
                    <i class="fa-solid fa-calendar"></i> <?php echo date("F Y", strtotime($project['created_at'])); ?>
                </p>
                
                <div class="description-box">
                    <h3>About the Project</h3>
                    <p>
                        <?php echo nl2br(htmlspecialchars($project['description'])); ?>
                    </p>
                </div>

                <?php if (!empty($project['project_link'])): ?>
                <div class="action-links">
                    <a href="<?php echo htmlspecialchars($project['project_link']); ?>" target="_blank" class="btn-github">
                        <i class="fa-brands fa-github"></i> View Source Code / Live Demo
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>

       <!-- Comments Section -->
        <div class="comments-section">
            <h3><i class="fa-solid fa-comments"></i> Community Feedback & Comments</h3>
            
            <!-- Comment Form -->
            <form action="add-comment.php" method="POST" class="comment-form">
                <input type="hidden" name="project_id" value="<?php echo $project['id']; ?>">
                <input type="text" name="user_name" placeholder="Your Name" required>
                <textarea name="comment_text" rows="3" placeholder="Leave a constructive comment or question..." required></textarea>
                <button type="submit" class="btn-comment">Post Comment</button>
            </form>

            <!-- Fetch and Display Comments from Database -->
            <div class="comments-list">
                <?php
                // የዚህን ፕሮጀክት አስተያየቶች ብቻ ከዳታቤዝ ማምጣት
                $comment_stmt = $conn->prepare("SELECT * FROM comments WHERE project_id = ? ORDER BY created_at DESC");
                $comment_stmt->bind_param("i", $project_id);
                $comment_stmt->execute();
                $comments = $comment_stmt->get_result();

                if ($comments->num_rows > 0):
                    while ($comment = $comments->fetch_assoc()):
                ?>
                    <div class="comment-item">
                        <h4><?php echo htmlspecialchars($comment['user_name']); ?></h4>
                        <p><?php echo nl2br(htmlspecialchars($comment['comment_text'])); ?></p>
                        <span class="comment-date"><?php echo date("M d, Y - h:i A", strtotime($comment['created_at'])); ?></span>
                    </div>
                <?php 
                    endwhile;
                else:
                ?>
                    <p style="color: #6b7280; font-size: 0.9rem;">እስካሁን ምንም አስተያየት አልተሰጠም። የመጀመሪያው አስተያየት ሰጪ ይሁኑ!</p>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; 2026 Ethio-Tech Hub. Built for Internship Showcase.</p>
    </footer>

    <script src="../frontend/script.js"></script>
</body>
</html>
