<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: Login.php");
    exit();
}
// Using the data visible in your database screenshot
$student_name = "Jhyn Libaton Carampatana"; 
$student_id = "21478755";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | UC - CCS</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --nav-blue: #0d47a1;
            --card-glass: rgba(255, 255, 255, 0.1);
            --border-glass: rgba(255, 255, 255, 0.2);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }

        body { 
            /* Keeping your original blue grid background */
            background-color: #163a70;
            background-image: 
                linear-gradient(rgba(255, 255, 255, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.05) 1px, transparent 1px);
            background-size: 30px 30px;
            color: white;
            min-height: 100vh;
        }

        /* Top Navigation Bar */
        .navbar {
            background-color: var(--nav-blue);
            padding: 12px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-size: 0.85rem;
            transition: 0.3s;
        }

        .nav-links a:hover { color: #ffc107; }

        .logout-btn {
            background: #ffc107;
            color: black !important;
            padding: 6px 15px;
            border-radius: 4px;
            font-weight: bold;
        }

        /* 3-Column Content Grid */
        .container {
            display: grid;
            grid-template-columns: 1fr 1.2fr 1.8fr; /* Matching the reference proportions */
            gap: 20px;
            padding: 30px;
            max-width: 1500px;
            margin: auto;
        }

        .card {
            background: var(--card-glass);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border-glass);
            border-radius: 10px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .card-header {
            background: rgba(255, 255, 255, 0.15);
            padding: 12px 15px;
            font-weight: 700;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid var(--border-glass);
        }

        /* Student Info Styles */
        .profile-section { text-align: center; padding: 20px; }
        .profile-img { 
            width: 130px; height: 130px; 
            border-radius: 10px; border: 3px solid var(--border-glass); 
            margin-bottom: 15px;
        }

        .info-list { list-style: none; padding: 0 20px 20px; font-size: 0.85rem; }
        .info-list li { margin-bottom: 12px; display: flex; }
        .info-list li strong { width: 80px; color: #ffc107; }

        /* Content Blocks */
        .card-body { padding: 20px; font-size: 0.9rem; line-height: 1.6; overflow-y: auto; height: 500px; }
        
        .announcement-item {
            background: rgba(255,255,255,0.05);
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
        }
        .meta-text { font-size: 0.75rem; color: #ffc107; margin-bottom: 5px; font-weight: bold; }
    </style>
</head>
<body>

    <nav class="navbar">
        <div style="font-weight: 700; font-size: 1.2rem;">Dashboard</div>
        <div class="nav-links">
            <a href="#">Notification ▾</a>
            <a href="#">Home</a>
            <a href="#">Edit Profile</a>
            <a href="#">History</a>
            <a href="#">Reservation</a>
            <a href="logout.php" class="logout-btn">Log out</a>
        </div>
    </nav>

    <div class="container">
        <div class="card">
            <div class="card-header">Student Information</div>
            <div class="profile-section">
                <img src="https://via.placeholder.com/150" class="profile-img" alt="Profile">
            </div>
            <ul class="info-list">
                <li><strong>Name:</strong> <?php echo $student_name; ?></li>
                <li><strong>Course:</strong> BSIT</li>
                <li><strong>Year:</strong> 3</li>
                <li><strong>Email:</strong> carampatanajhyn491@gmail.com</li>
                <li><strong>Address:</strong> Cebu, City</li>
                <li><strong>Session:</strong> 30</li>
            </ul>
        </div>

        <div class="card">
            <div class="card-header">Announcement</div>
            <div class="card-body">
                <div class="announcement-item">
                    <div class="meta-text">CCS Admin | 2026-Feb-11</div>
                    <p>Laboratory schedule for the midterms has been posted. Please check the Reservation tab.</p>
                </div>
                <div class="announcement-item">
                    <div class="meta-text">CCS Admin | 2024-May-08</div>
                    <p>Important Announcement: We are excited to announce the launch of our new website! 🚀</p>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Rules and Regulation</div>
            <div class="card-body">
                <h3 style="text-align: center; color: #ffc107;">University of Cebu</h3>
                <h4 style="text-align: center; margin-bottom: 20px; font-size: 0.8rem; opacity: 0.8;">COLLEGE OF INFORMATION & COMPUTER STUDIES</h4>
                <p><strong>LABORATORY RULES AND REGULATIONS</strong></p><br>
                <p>1. Maintain silence, proper decorum, and discipline inside the laboratory.</p><br>
                <p>2. Games are not allowed inside the lab. This includes computer-related games, card games, etc.</p><br>
                <p>3. Surfing the Internet is allowed only with the permission of the instructor.</p>
            </div>
        </div>
    </div>

</body>
</html>