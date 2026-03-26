<?php
session_start();
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: Login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "jhyn");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get statistics
$total_students = $conn->query("SELECT COUNT(*) as total FROM students")->fetch_assoc()['total'];
$total_sit_ins = $conn->query("SELECT COUNT(*) as total FROM sit_in_records")->fetch_assoc()['total'];
$pending_sit_ins = $conn->query("SELECT COUNT(*) as total FROM sit_in_records WHERE status = 'Pending'")->fetch_assoc()['total'];
$approved_sit_ins = $conn->query("SELECT COUNT(*) as total FROM sit_in_records WHERE status = 'Approved'")->fetch_assoc()['total'];

// Get recent sit-in records
$recent_sit_ins = $conn->query("SELECT * FROM sit_in_records ORDER BY created_at DESC LIMIT 10");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - CCS Sit-in Monitoring System</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: #f0f2f5;
        }
        
        /* Sidebar */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 280px;
            height: 100%;
            background: linear-gradient(180deg, #1e3a5f 0%, #0f2d4a 100%);
            color: white;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            transition: all 0.3s;
            z-index: 100;
        }
        
        .sidebar-header {
            padding: 30px 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-header h3 {
            font-size: 1.3rem;
            margin-bottom: 5px;
        }
        
        .sidebar-header p {
            font-size: 0.75rem;
            opacity: 0.8;
        }
        
        .sidebar-menu {
            padding: 20px 0;
        }
        
        .menu-item {
            padding: 12px 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            transition: all 0.3s;
            color: rgba(255,255,255,0.8);
            margin: 5px 0;
        }
        
        .menu-item:hover, .menu-item.active {
            background: rgba(255,255,255,0.1);
            color: white;
            border-left: 3px solid #3b9eff;
        }
        
        .menu-item i {
            width: 24px;
            font-size: 1.1rem;
        }
        
        /* Main Content */
        .main-content {
            margin-left: 280px;
            padding: 20px;
            min-height: 100vh;
        }
        
        /* Top Bar */
        .top-bar {
            background: white;
            padding: 15px 25px;
            border-radius: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        
        .top-bar h2 {
            font-size: 1.3rem;
            color: #1e3a5f;
        }
        
        .admin-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .admin-name {
            font-weight: 500;
            color: #1e3a5f;
        }
        
        .logout-btn {
            background: #dc2626;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            transition: background 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        
        .logout-btn:hover {
            background: #b91c1c;
        }
        
        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: transform 0.2s;
        }
        
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .stat-info h3 {
            font-size: 0.85rem;
            color: #64748b;
            margin-bottom: 8px;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #1e3a5f;
        }
        
        .stat-icon {
            font-size: 2.5rem;
            color: #3b9eff;
        }
        
        /* Tables */
        .table-container {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            margin-bottom: 30px;
            overflow-x: auto;
        }
        
        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .table-header h3 {
            color: #1e3a5f;
            font-size: 1.1rem;
        }
        
        .search-box {
            padding: 8px 12px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            width: 250px;
            font-family: 'Poppins', sans-serif;
        }
        
        .add-btn {
            background: #10b981;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        
        .add-btn:hover {
            background: #059669;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }
        
        th {
            background: #f8fafc;
            font-weight: 600;
            color: #1e3a5f;
        }
        
        tr:hover {
            background: #f8fafc;
        }
        
        .status-badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-block;
        }
        
        .status-approved {
            background: #d1fae5;
            color: #10b981;
        }
        
        .status-pending {
            background: #fef3c7;
            color: #f59e0b;
        }
        
        .btn-action {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.75rem;
            margin: 0 2px;
            transition: all 0.2s;
        }
        
        .btn-approve {
            background: #10b981;
            color: white;
        }
        
        .btn-approve:hover {
            background: #059669;
        }
        
        .btn-delete {
            background: #ef4444;
            color: white;
        }
        
        .btn-delete:hover {
            background: #dc2626;
        }
        
        .btn-edit {
            background: #3b82f6;
            color: white;
        }
        
        .btn-edit:hover {
            background: #2563eb;
        }
        
        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        
        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 12px;
            width: 90%;
            max-width: 500px;
            animation: modalSlideIn 0.3s ease;
        }
        
        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .modal-content h3 {
            margin-bottom: 20px;
            color: #1e3a5f;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: #334155;
        }
        
        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            font-family: 'Poppins', sans-serif;
        }
        
        .form-group input:focus, .form-group select:focus {
            outline: none;
            border-color: #3b9eff;
        }
        
        .modal-buttons {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        
        .modal-buttons button {
            flex: 1;
            padding: 10px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
        }
        
        .btn-save {
            background: #10b981;
            color: white;
        }
        
        .btn-cancel {
            background: #e2e8f0;
            color: #334155;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                left: -280px;
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h3><i class="fas fa-shield-alt"></i> CCS Admin</h3>
            <p>Sit-in Monitoring System</p>
        </div>
        <div class="sidebar-menu">
            <div class="menu-item active" onclick="showSection('dashboard')">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </div>
            <div class="menu-item" onclick="showSection('students')">
                <i class="fas fa-users"></i> Student Management
            </div>
            <div class="menu-item" onclick="showSection('sit-ins')">
                <i class="fas fa-chair"></i> Sit-in Records
            </div>
        </div>
    </div>
    
    <div class="main-content">
        <div class="top-bar">
            <h2 id="page-title">Dashboard</h2>
            <div class="admin-info">
                <span class="admin-name"><i class="fas fa-user-shield"></i> <?php echo $_SESSION['admin_name']; ?></span>
                <a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>
        
        <!-- Dashboard Section -->
        <div id="dashboard-section">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-info">
                        <h3>Total Students</h3>
                        <div class="stat-number"><?php echo $total_students; ?></div>
                    </div>
                    <i class="fas fa-users stat-icon"></i>
                </div>
                <div class="stat-card">
                    <div class="stat-info">
                        <h3>Total Sit-ins</h3>
                        <div class="stat-number"><?php echo $total_sit_ins; ?></div>
                    </div>
                    <i class="fas fa-calendar-check stat-icon"></i>
                </div>
                <div class="stat-card">
                    <div class="stat-info">
                        <h3>Pending Requests</h3>
                        <div class="stat-number"><?php echo $pending_sit_ins; ?></div>
                    </div>
                    <i class="fas fa-clock stat-icon"></i>
                </div>
                <div class="stat-card">
                    <div class="stat-info">
                        <h3>Approved Sit-ins</h3>
                        <div class="stat-number"><?php echo $approved_sit_ins; ?></div>
                    </div>
                    <i class="fas fa-check-circle stat-icon"></i>
                </div>
            </div>
            
            <div class="table-container">
                <div class="table-header">
                    <h3><i class="fas fa-history"></i> Recent Sit-in Requests</h3>
                </div>
                <table>
                    <thead>
                        <tr><th>Sit ID</th><th>Student Name</th><th>Purpose</th><th>Lab</th><th>Status</th><th>Date</th></tr>
                    </thead>
                    <tbody>
                        <?php if ($recent_sit_ins && $recent_sit_ins->num_rows > 0): ?>
                            <?php while($row = $recent_sit_ins->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['sit_id']; ?></td>
                                <td><?php echo $row['student_name']; ?></td>
                                <td><?php echo $row['purpose']; ?></td>
                                <td><?php echo $row['sit_lab']; ?></td>
                                <td><span class="status-badge status-<?php echo strtolower($row['status']); ?>"><?php echo $row['status']; ?></span></td>
                                <td><?php echo $row['sit_date']; ?></td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="6" style="text-align: center;">No records found</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Students Section -->
        <div id="students-section" style="display:none;">
            <div class="table-container">
                <div class="table-header">
                    <h3><i class="fas fa-graduation-cap"></i> Student Information</h3>
                    <input type="text" class="search-box" placeholder="Search students..." id="studentSearch">
                </div>
                <table id="studentsTable">
                    <thead>
                        <tr><th>ID Number</th><th>Name</th><th>Course</th><th>Level</th><th>Email</th><th>Actions</th></tr>
                    </thead>
                    <tbody>
                        <?php
                        $students = $conn->query("SELECT * FROM students ORDER BY created_at DESC");
                        while($student = $students->fetch_assoc()):
                        ?>
                        <tr>
                            <td><?php echo $student['id_number']; ?></td>
                            <td><?php echo $student['first_name'] . ' ' . $student['last_name']; ?></td>
                            <td><?php echo $student['course']; ?></td>
                            <td><?php echo $student['course_level']; ?></td>
                            <td><?php echo $student['email']; ?></td>
                            <td>
                                <button class="btn-action btn-edit" onclick="editStudent(<?php echo $student['id']; ?>)">Edit</button>
                                <button class="btn-action btn-delete" onclick="deleteStudent(<?php echo $student['id']; ?>)">Delete</button>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Sit-ins Section -->
        <div id="sit-ins-section" style="display:none;">
            <div class="table-container">
                <div class="table-header">
                    <h3><i class="fas fa-chair"></i> Sit-in Records</h3>
                    <button class="add-btn" onclick="showAddSitInModal()"><i class="fas fa-plus"></i> Add Sit-in</button>
                </div>
                <table id="sitInsTable">
                    <thead>
                        <tr><th>Sit ID</th><th>ID Number</th><th>Name</th><th>Purpose</th><th>Lab</th><th>Session</th><th>Status</th><th>Actions</th></tr>
                    </thead>
                    <tbody>
                        <?php
                        $sit_ins = $conn->query("SELECT * FROM sit_in_records ORDER BY created_at DESC");
                        while($record = $sit_ins->fetch_assoc()):
                        ?>
                        <tr>
                            <td><?php echo $record['sit_id']; ?></td>
                            <td><?php echo $record['id_number']; ?></td>
                            <td><?php echo $record['student_name']; ?></td>
                            <td><?php echo $record['purpose']; ?></td>
                            <td><?php echo $record['sit_lab']; ?></td>
                            <td><?php echo $record['session']; ?></td>
                            <td><span class="status-badge status-<?php echo strtolower($record['status']); ?>"><?php echo $record['status']; ?></span></td>
                            <td>
                                <?php if($record['status'] == 'Pending'): ?>
                                <button class="btn-action btn-approve" onclick="approveSitIn(<?php echo $record['id']; ?>)">Approve</button>
                                <?php endif; ?>
                                <button class="btn-action btn-delete" onclick="deleteSitIn(<?php echo $record['id']; ?>)">Delete</button>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Add Sit-in Modal -->
    <div id="sitInModal" class="modal">
        <div class="modal-content">
            <h3><i class="fas fa-plus"></i> Add New Sit-in Record</h3>
            <form id="sitInForm">
                <div class="form-group">
                    <label>Student ID Number</label>
                    <input type="text" id="student_id_number" placeholder="Enter student ID number" required>
                </div>
                <div class="form-group">
                    <label>Purpose</label>
                    <select id="purpose" required>
                        <option>Programming</option>
                        <option>Research</option>
                        <option>Exam</option>
                        <option>Project</option>
                        <option>Laboratory Activity</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Lab</label>
                    <select id="lab" required>
                        <option>Lab A-101</option>
                        <option>Lab A-102</option>
                        <option>Lab B-201</option>
                        <option>Lab B-202</option>
                        <option>AI Research Hub</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Session</label>
                    <select id="session" required>
                        <option>Morning (8AM - 12PM)</option>
                        <option>Afternoon (1PM - 5PM)</option>
                        <option>Evening (6PM - 9PM)</option>
                    </select>
                </div>
                <div class="modal-buttons">
                    <button type="submit" class="btn-save">Save Record</button>
                    <button type="button" class="btn-cancel" onclick="closeModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        function showSection(section) {
            document.getElementById('dashboard-section').style.display = 'none';
            document.getElementById('students-section').style.display = 'none';
            document.getElementById('sit-ins-section').style.display = 'none';
            
            if(section === 'dashboard') {
                document.getElementById('dashboard-section').style.display = 'block';
                document.getElementById('page-title').innerHTML = '<i class="fas fa-tachometer-alt"></i> Dashboard';
            } else if(section === 'students') {
                document.getElementById('students-section').style.display = 'block';
                document.getElementById('page-title').innerHTML = '<i class="fas fa-users"></i> Student Management';
            } else if(section === 'sit-ins') {
                document.getElementById('sit-ins-section').style.display = 'block';
                document.getElementById('page-title').innerHTML = '<i class="fas fa-chair"></i> Sit-in Records';
            }
            
            document.querySelectorAll('.menu-item').forEach(item => item.classList.remove('active'));
            event.target.closest('.menu-item').classList.add('active');
        }
        
        // Search students
        const studentSearch = document.getElementById('studentSearch');
        if(studentSearch) {
            studentSearch.addEventListener('keyup', function() {
                let filter = this.value.toLowerCase();
                let rows = document.querySelectorAll('#studentsTable tbody tr');
                rows.forEach(row => {
                    let text = row.innerText.toLowerCase();
                    row.style.display = text.includes(filter) ? '' : 'none';
                });
            });
        }
        
        function showAddSitInModal() {
            document.getElementById('sitInModal').style.display = 'flex';
        }
        
        function closeModal() {
            document.getElementById('sitInModal').style.display = 'none';
        }
        
        document.getElementById('sitInForm').addEventListener('submit', function(e) {
            e.preventDefault();
            let formData = new FormData();
            formData.append('student_id', document.getElementById('student_id_number').value);
            formData.append('purpose', document.getElementById('purpose').value);
            formData.append('lab', document.getElementById('lab').value);
            formData.append('session', document.getElementById('session').value);
            
            fetch('add_sit_in.php', {
                method: 'POST',
                body: formData
            }).then(response => response.json())
              .then(data => {
                  if(data.success) {
                      alert('Sit-in record added successfully!');
                      location.reload();
                  } else {
                      alert('Error: ' + data.message);
                  }
              }).catch(error => {
                  alert('Error adding record');
              });
            closeModal();
        });
        
        function approveSitIn(id) {
            if(confirm('Approve this sit-in request?')) {
                window.location.href = `approve_sit_in.php?id=${id}`;
            }
        }
        
        function deleteSitIn(id) {
            if(confirm('Delete this sit-in record?')) {
                window.location.href = `delete_sit_in.php?id=${id}`;
            }
        }
        
        function editStudent(id) {
            let newName = prompt('Enter new name for the student:');
            if(newName) {
                window.location.href = `edit_student.php?id=${id}&name=${encodeURIComponent(newName)}`;
            }
        }
        
        function deleteStudent(id) {
            if(confirm('Delete this student account? This action cannot be undone.')) {
                window.location.href = `delete_student.php?id=${id}`;
            }
        }
        
        // Close modal when clicking outside
        window.onclick = function(event) {
            let modal = document.getElementById('sitInModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</body>
</html> 