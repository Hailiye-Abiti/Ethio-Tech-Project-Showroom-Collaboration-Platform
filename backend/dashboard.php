<?php
session_start();
require_once 'db.php';

// Login ያላደረገ ሰው በቀጥታ ገጹን እንዳይከፍተው መከላከል (Protected Page)
if (!isset($_SESSION['user_id'])) {
    header("Location: ../frontend/login.html");
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

// የተጠቃሚውን የራሱን ፕሮጀክቶች ብቻ ከዳታቤዝ ማምጣት
$stmt = $conn->prepare("SELECT * FROM projects WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$myProjects = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - EthioTech Hub</title>
    <link rel="stylesheet" href="../frontend/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <!-- Header -->
    <header>
        <div class="logo">
            <h2><a href="../index.html" style="text-decoration:none; color:inherit;"><i class="fa-solid fa-code"></i> EthioTech Hub</a></h2>
        </div>
        <nav>
            <a href="../index.html">Home</a>
            <a href="dashboard.php" class="active">Dashboard</a>
            <a href="../frontend/add-project.html"><i class="fa-solid fa-plus"></i> Add Project</a>
            <a href="logout.php" class="btn-login" style="background:#ef4444;"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
            <button id="themeToggle" class="theme-btn"><i class="fa-solid fa-moon"></i></button>
            <div class="lang-switch" style="display: inline-flex; gap: 5px;">
    <button onclick="changeLanguage('en')" id="btnEn" style="background: #2563eb; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; font-weight: bold;">EN</button>
    <button onclick="changeLanguage('am')" id="btnAm" style="background: #e5e7eb; color: #374151; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; font-weight: bold;">አማ</button>
</div>
        </nav>
    </header>
   
<!-- Hero Section -->
    <section class="hero">
        <h1>Discover Amazing Tech Projects in Ethiopia</h1>
        <p>Explore, share, and collaborate on software projects built by local developers and students.</p>
        
        <!-- Search & Filter Bar -->
        <div class="search-box">
            <input type="text" id="searchInput" placeholder="Search by title or tech stack (e.g., React, PHP)...">
            <button><i class="fa-solid fa-search"></i> Search</button>
        </div>
    </section>

    <!-- Dashboard Content -->
    <main class="container">

        <div class="dashboard-header" style="margin-bottom: 30px;">
            <h1>Welcome back, <?php echo htmlspecialchars($username); ?>! 👋</h1>
            <p style="color: #6b7280;">Manage your submitted projects and track community activity.</p>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2>My Projects</h2>
            <a href="../frontend/add-project.html" class="btn-submit" style="text-decoration:none; width:auto; padding: 10px 20px;">+ New Project</a>
        </div>
         </div>
         </div>
        <!-- Projects Grid -->
        <div class="projects-grid">
            <?php if ($myProjects->num_rows > 0): ?>
                <?php while ($row = $myProjects->fetch_assoc()): ?>
                    <div class="project-card">
                        <img src="<?php echo !empty($row['image_url']) ? htmlspecialchars($row['image_url']) : 'https://via.placeholder.com/300x160'; ?>" alt="Project Image">
                        <div class="card-content">
                            <span class="tech-badge"><?php echo htmlspecialchars($row['tech_stack']); ?></span>
                            <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                            <p><?php echo htmlspecialchars(substr($row['description'], 0, 100)) . '...'; ?></p>
                            <div class="card-footer">
                                <a href="../backend/project-detail.php?id=<?php echo $row['id']; ?>" class="btn-details">View Details</a>
                                <a href="edit-project.php?id=<?php echo $row['id']; ?>" class="btn-edit" style="background: #3b82f6; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 0.85rem;"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                            </div>
                            
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p style="grid-column: 1/-1; color: #6b7280;">እስካሁን ምንም የጫኑት ፕሮጀክት የለም። "+ New Project" የሚለውን በመጫን የመጀመሪያዎን ፕሮጀክት ያጋሩ!</p>
            <?php endif; ?>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; 2026 EthioTech Hub. Built for Internship Showcase.</p>
    </footer>

    <script src="../frontend/script.js"></script>
</body>
</html>
