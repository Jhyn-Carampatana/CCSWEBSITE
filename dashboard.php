<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: Login.php");
    exit();
}

// Get user info from session
$username = $_SESSION['name'] ?? 'Student';
$id_number = $_SESSION['id_number'] ?? '';
$last_name = $_SESSION['last_name'] ?? '';
$fullname = trim($username . ' ' . $last_name);

// Database connection for additional data (optional)
$conn = new mysqli("localhost", "root", "", "jhyn");
if ($conn->connect_error) {
    // Don't die, just continue without extra data
    $conn = null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>CCS Lab Dashboard | University of Cebu</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #eef2f5;
            font-family: 'Inter', sans-serif;
            padding: 32px 28px;
            color: #1a2c3e;
        }

        .dashboard {
            max-width: 1400px;
            margin: 0 auto;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 28px;
            flex-wrap: wrap;
            gap: 16px;
        }
        
        .title-section h1 {
            font-size: 1.85rem;
            font-weight: 600;
            letter-spacing: -0.3px;
            background: linear-gradient(135deg, #1e4668, #2c5a7a);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
        }
        
        .title-section p {
            font-size: 0.9rem;
            color: #4a627a;
            margin-top: 6px;
            font-weight: 500;
        }
        
        .user-info {
            background: white;
            padding: 8px 18px;
            border-radius: 60px;
            font-size: 0.85rem;
            font-weight: 500;
            box-shadow: 0 2px 6px rgba(0,0,0,0.02), 0 1px 2px rgba(0,0,0,0.05);
            color: #2c5a7a;
            border: 1px solid #dce5ec;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .user-info i {
            margin-right: 4px;
        }
        
        .logout-btn {
            background: none;
            border: none;
            color: #e0584b;
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 600;
            padding: 4px 8px;
            border-radius: 20px;
            transition: background 0.2s;
        }
        
        .logout-btn:hover {
            background: #fee2e0;
        }
        
        .date-badge {
            background: white;
            padding: 8px 18px;
            border-radius: 60px;
            font-size: 0.85rem;
            font-weight: 500;
            box-shadow: 0 2px 6px rgba(0,0,0,0.02), 0 1px 2px rgba(0,0,0,0.05);
            color: #2c5a7a;
            border: 1px solid #dce5ec;
        }
        
        .date-badge i {
            margin-right: 8px;
            font-size: 0.8rem;
        }

        .grid-main {
            display: grid;
            grid-template-columns: 1fr 0.9fr;
            gap: 28px;
        }

        .card {
            background: #ffffff;
            border-radius: 28px;
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.04), 0 0 0 1px rgba(0, 0, 0, 0.02);
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s;
        }
        
        .card:hover {
            box-shadow: 0 20px 32px rgba(0, 0, 0, 0.08), 0 0 0 1px rgba(0, 0, 0, 0.03);
        }
        
        .card-header {
            padding: 20px 26px 12px 26px;
            border-bottom: 1px solid #edf2f6;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .card-header i {
            font-size: 1.6rem;
            color: #2c7da0;
            background: #eaf4f9;
            padding: 8px;
            border-radius: 18px;
        }
        
        .card-header h2 {
            font-size: 1.45rem;
            font-weight: 600;
            color: #1a3a4f;
        }
        
        .card-content {
            padding: 18px 26px 26px 26px;
        }

        .announcement-item {
            padding: 16px 0;
            border-bottom: 1px solid #ecf3f8;
        }
        
        .announcement-item:last-child {
            border-bottom: none;
        }
        
        .announcement-date {
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #2c7da0;
            background: #eef5fa;
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            margin-bottom: 10px;
        }
        
        .announcement-title {
            font-weight: 700;
            font-size: 1rem;
            margin-bottom: 8px;
            color: #0f2c3b;
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }
        
        .announcement-title i {
            color: #2c7da0;
            font-size: 0.9rem;
        }
        
        .announcement-desc {
            font-size: 0.9rem;
            color: #2c4a62;
            line-height: 1.4;
            margin-top: 4px;
        }
        
        .badge-new {
            background: #e0584b20;
            color: #bc4e2c;
            font-size: 0.65rem;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 30px;
            margin-left: 6px;
        }

        .rules-list {
            list-style: none;
            margin-top: 8px;
        }
        
        .rules-list li {
            display: flex;
            gap: 14px;
            margin-bottom: 18px;
            font-size: 0.94rem;
            line-height: 1.4;
            color: #1f3f54;
        }
        
        .rules-list li i {
            color: #2c7da0;
            font-size: 1rem;
            margin-top: 2px;
            min-width: 22px;
        }
        
        .rule-number {
            font-weight: 700;
            color: #1f597b;
        }

        .campus-map-card {
            margin-top: 28px;
        }
        
        .map-placeholder {
            background: #eef2f7;
            border-radius: 24px;
            padding: 24px 16px;
            text-align: center;
            margin-top: 8px;
            border: 1px dashed #bbd1e0;
        }
        
        .map-placeholder i {
            font-size: 3.2rem;
            color: #3f7e9e;
            margin-bottom: 12px;
        }
        
        .map-placeholder p {
            font-weight: 500;
            color: #1c4d6b;
        }
        
        .map-detail {
            font-size: 0.8rem;
            color: #4f6f87;
            margin-top: 6px;
        }
        
        .btn-reserve {
            background: #f0f6fc;
            border: none;
            padding: 8px 16px;
            border-radius: 32px;
            font-weight: 500;
            font-size: 0.8rem;
            color: #1e6f92;
            cursor: pointer;
            transition: 0.2s;
            margin-top: 12px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-reserve:hover {
            background: #e2edf5;
            color: #0a4b69;
        }
        
        hr {
            margin: 12px 0;
            border: 0;
            height: 1px;
            background: #e2eaf0;
        }

        .reservation-note {
            background: #fef8e7;
            border-left: 4px solid #f4b942;
            padding: 12px 16px;
            border-radius: 16px;
            margin-top: 18px;
            font-size: 0.85rem;
            display: flex;
            gap: 12px;
            align-items: center;
            flex-wrap: wrap;
        }
        
        .welcome-message {
            background: linear-gradient(135deg, #e6f4ff 0%, #d9eafb 100%);
            padding: 12px 20px;
            border-radius: 16px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            border-left: 4px solid #2c7da0;
        }

        @media (max-width: 880px) {
            body {
                padding: 20px 16px;
            }
            .grid-main {
                grid-template-columns: 1fr;
                gap: 24px;
            }
            .campus-map-card {
                margin-top: 0;
            }
        }

        footer {
            margin-top: 44px;
            text-align: center;
            font-size: 0.75rem;
            color: #6b8aa3;
            border-top: 1px solid #dce6ed;
            padding-top: 24px;
        }
    </style>
</head>
<body>
<div class="dashboard">
    <div class="top-bar">
        <div class="title-section">
            <h1><i class="fas fa-flask" style="color:#2c7da0; margin-right: 8px;"></i>CCS Lab Dashboard</h1>
            <p>College of Computer Studies • University of Cebu</p>
        </div>
        <div style="display: flex; gap: 12px; align-items: center;">
            <div class="user-info">
                <i class="fas fa-user-circle"></i>
                <span>Welcome, <?php echo htmlspecialchars($fullname ?: $username); ?>!</span>
                <span style="font-size: 0.7rem; color:#64748b;">(ID: <?php echo htmlspecialchars($id_number); ?>)</span>
                <form method="POST" action="logout.php" style="display: inline;">
                    <button type="submit" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</button>
                </form>
            </div>
            <div class="date-badge">
                <i class="far fa-calendar-alt"></i> 
                <span id="currentDate"></span>
            </div>
        </div>
    </div>

    <div class="welcome-message">
        <i class="fas fa-graduation-cap" style="color:#2c7da0; margin-right: 10px;"></i>
        Good to see you, <strong><?php echo htmlspecialchars($fullname ?: $username); ?></strong>! Welcome to the CCS Laboratory Management System.
    </div>

    <div class="grid-main">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-bullhorn"></i>
                <h2>Announcements</h2>
            </div>
            <div class="card-content">
                <div class="announcement-item">
                    <div class="announcement-date">
                        <i class="far fa-clock"></i> CCS Asia | 2025-03-25
                    </div>
                    <div class="announcement-title">
                        <i class="fas fa-chalkboard-user"></i> Midterm Lab Schedule
                        <span class="badge-new">Updated</span>
                    </div>
                    <div class="announcement-desc">
                        Laboratory schedule for the midterm has been posted. 
                        <strong>Please check the Reservation tab</strong> for time slots and workstation availability.
                    </div>
                    <div class="reservation-note">
                        <i class="fas fa-calendar-check" style="color:#e6a017;"></i>
                        <span><strong>Reservation tab:</strong> Mid-term practical sessions available • April 5–9, 2025. Book your lab slot now.</span>
                        <button class="btn-reserve" id="reserveMockBtn"><i class="fas fa-arrow-right"></i> View Slots</button>
                    </div>
                </div>

                <div class="announcement-item">
                    <div class="announcement-date">
                        <i class="far fa-clock"></i> CCS Asia | 2025-03-20
                    </div>
                    <div class="announcement-title">
                        <i class="fas fa-laptop-code"></i> New Lab Equipment Available
                        <span class="badge-new">Important</span>
                    </div>
                    <div class="announcement-desc">
                        New workstations with upgraded specifications are now available in Lab A-101. Students can now reserve these units for programming projects.
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-gavel"></i>
                    <h2>Laboratory Rules & Regulations</h2>
                </div>
                <div class="card-content">
                    <div style="margin-bottom: 8px; font-size:0.8rem; font-weight:500; color:#2c5a7a;">
                        <i class="fas fa-university"></i> University of Cebu — College of Computer Studies
                    </div>
                    <ul class="rules-list">
                        <li>
                            <i class="fas fa-volume-off"></i>
                            <span><span class="rule-number">1.</span> Maintain silence, proper decorum, and discipline inside the laboratory.</span>
                        </li>
                        <li>
                            <i class="fas fa-camera-slash"></i>
                            <span><span class="rule-number">2.</span> Cameras are not allowed inside the lab. This includes computer-assisted programs, etc.</span>
                        </li>
                        <li>
                            <i class="fas fa-globe"></i>
                            <span><span class="rule-number">3.</span> Surfing the Internet is allowed only with the permission of the instructor.</span>
                        </li>
                    </ul>
                    <hr>
                    <div style="display: flex; gap: 16px; flex-wrap: wrap; justify-content: space-between; align-items: center;">
                        <div><i class="fas fa-id-card"></i> <span style="font-size:0.8rem;">ID required for lab access</span></div>
                        <div><i class="fas fa-plug"></i> <span style="font-size:0.8rem;">No food/drinks at workstations</span></div>
                    </div>
                </div>
            </div>

            <div class="card campus-map-card">
                <div class="card-header">
                    <i class="fas fa-map-location-dot"></i>
                    <h2>Campus Map</h2>
                </div>
                <div class="card-content">
                    <div class="map-placeholder">
                        <i class="fas fa-map"></i>
                        <p><strong>College of Computer Studies</strong></p>
                        <div class="map-detail">
                            <i class="fas fa-location-dot"></i> Main Building, Level 3 • Computer Labs Wing
                        </div>
                        <div style="margin: 12px 0 4px 0; display: flex; justify-content: center; gap: 20px; flex-wrap: wrap;">
                            <span><i class="fas fa-chalkboard"></i> Lab A-101</span>
                            <span><i class="fas fa-microchip"></i> AI Research Hub</span>
                            <span><i class="fas fa-wifi"></i> Smart Classroom</span>
                        </div>
                        <button class="btn-reserve" id="mapDirectionsBtn"><i class="fas fa-directions"></i> Get Directions</button>
                    </div>
                    <div style="margin-top: 14px; font-size: 0.75rem; background: #f4f9fe; padding: 10px 12px; border-radius: 20px; display: flex; align-items: center; gap: 12px;">
                        <i class="fas fa-city"></i> 
                        <span><strong>📍 Cebu City Campus</strong> — University of Cebu, Main Campus, Cebu City. Open daily 8:00 – 20:00.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <i class="fas fa-microchip"></i> CCS Laboratory Management System • Respect lab guidelines • For urgent support contact lab supervisor
    </footer>
</div>

<script>
    (function() {
        const dateElem = document.getElementById('currentDate');
        if(dateElem) {
            const now = new Date();
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            dateElem.innerText = now.toLocaleDateString(undefined, options);
        }

        const reserveBtn = document.getElementById('reserveMockBtn');
        if(reserveBtn) {
            reserveBtn.addEventListener('click', (e) => {
                e.preventDefault();
                alert("📅 Reservation System\n\nAvailable Lab Slots:\n• April 5, 2025 (9am-12pm) – Section A\n• April 6, 2025 (2pm-5pm) – Section B\n• April 7, 2025 (10am-1pm) – Practical Exam\n\nPlease contact the lab coordinator for booking confirmation.");
            });
        }

        const mapBtn = document.getElementById('mapDirectionsBtn');
        if(mapBtn) {
            mapBtn.addEventListener('click', () => {
                alert("🗺️ Campus Map Directions\n\n📍 University of Cebu - Main Campus\nCollege of Computer Studies Building, 3rd Floor\nFrom the main gate: walk straight 200m, turn right at the library building.");
            });
        }
    })();
</script>
</body>
</html>