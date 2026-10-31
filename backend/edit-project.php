<?php
session_start();
require_once 'db.php';

// 1. ተጠቃሚው Login ማድረጉን ማረጋገጥ
if (!isset($_SESSION['user_id'])) {
    header("Location: ../frontend/login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

// 2. ፎርሙ ሲሞላ (POST ሲደረግ) መረጃውን ዳታቤዝ ውስጥ ማስተካከል (UPDATE)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $project_id = intval($_POST['project_id']);
    $title = trim($_POST['title']);
    $tech_stack = trim($_POST['tech_stack']);
    $project_link = trim($_POST['project_link']);
    $image_url = trim($_POST['image_url']);
    $description = trim($_POST['description']);

    $stmt = $conn->prepare("UPDATE projects SET title = ?, tech_stack = ?, project_link = ?, image_url = ?, description = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("sssssii", $title, $tech_stack, $project_link, $image_url, $description, $project_id, $user_id);

    if ($stmt->execute()) {
        echo "<script>alert('ፕሮጀክቱ በተሳካ ሁኔታ ተሻሽሏል!'); window.location.href='dashboard.php';</script>";
        exit();
    } else {
        echo "ስህተት ተፈጥሯል: " . $conn->error;
    }
}

// 3. ፎርሙ ገና ሲከፈት (GET) የፕሮጀክቱን መረጃ ከዳታቤዝ ማምጣት
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$project_id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM projects WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $project_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script>alert('ፕሮጀክቱ አልተገኘም ወይም የማስተካከል መብት የለዎትም!'); window.location.href='dashboard.php';</script>";
    exit();
}

$project = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Project - EthioTech Hub</title>
    <!-- ስታይል ከ frontend ፎልደር እንዲጠራ ../ ተደርጓል -->
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
            <a href="dashboard.php">Dashboard</a>
            <button id="themeToggle" class="theme-btn" title="Toggle Dark/Light Mode">
                <i class="fa-solid fa-moon"></i>
            </button>
                       <div class="lang-switch" style="display: inline-flex; gap: 5px; margin-left: 15px;">
    <button onclick="changeLanguage('en')" id="btnEn" style="background: #2563eb; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; font-weight: bold;">EN</button>
    <button onclick="changeLanguage('am')" id="btnAm" style="background: #e5e7eb; color: #374151; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; font-weight: bold;">አማ</button>
</div>
        </nav>
    </header>

    <!-- Edit Form Section -->
    <main class="container">
        <div class="form-card">
            <h2><i class="fa-solid fa-pen-to-square"></i> Edit Project Details</h2>
            <p class="form-subtitle">Update your project information below.</p>

            <!-- ፎርሙ መረጃውን ወደ ራሱ ወደ edit-project.php ይልካል -->
            <action="" method="POST">
            <form action="edit-project.php" method="POST">
                <input type="hidden" name="project_id" value="<?php echo $project['id']; ?>">

                <div class="form-group">
                    <label for="projectTitle">Project Title *</label>
                    <input type="text" id="projectTitle" name="title" value="<?php echo htmlspecialchars($project['title']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="techStack">Technologies Used (Tech Stack) *</label>
                    <input type="text" id="techStack" name="tech_stack" value="<?php echo htmlspecialchars($project['tech_stack']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="projectLink">Live Demo or GitHub Link</label>
                    <input type="url" id="projectLink" name="project_link" value="<?php echo htmlspecialchars($project['project_link']); ?>">
                </div>

                <div class="form-group">
                    <label for="imageUrl">Project Screenshot / Image URL</label>
                    <input type="url" id="imageUrl" name="image_url" value="<?php echo htmlspecialchars($project['image_url']); ?>">
                </div>

                <div class="form-group">
                    <label for="description">Project Description *</label>
                    <textarea id="description" name="description" rows="5" required><?php echo htmlspecialchars($project['description']); ?></textarea>
                </div>

                <button type="submit" class="btn-submit" style="background: #2563eb;"><i class="fa-solid fa-save"></i> Save Changes</button>
            </form>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; 2026 EthioTech Hub. Built for Internship Showcase.</p>
    </footer>

    <script src="../frontend/script.js"></script>
</body>
</html>
