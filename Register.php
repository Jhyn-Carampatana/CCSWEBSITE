<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>CCS Sit-in Monitoring System · Register</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --primary: #1a6fc4;
      --primary-dark: #1358a0;
      --navy: #0f2d55;
      --white: #ffffff;
      --gray-50: #f8fafc;
      --gray-100: #f1f5f9;
      --gray-200: #e2e8f0;
      --gray-400: #94a3b8;
      --gray-500: #64748b;
      --gray-700: #334155;
      --danger: #dc2626;
      --shadow-lg: 0 20px 60px rgba(15,45,85,0.18), 0 8px 24px rgba(15,45,85,0.10);
      --radius: 16px;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #0f2d55 0%, #1a5fa8 45%, #2176c7 75%, #1a9ed4 100%);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      position: relative;
    }

    body::before {
      content: '';
      position: fixed;
      inset: 0;
      background-image:
        linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
      background-size: 40px 40px;
      pointer-events: none;
    }

    body::after {
      content: '';
      position: fixed;
      inset: 0;
      background:
        radial-gradient(ellipse 55% 45% at 10% 90%, rgba(59,158,255,0.18) 0%, transparent 60%),
        radial-gradient(ellipse 45% 55% at 90% 10%, rgba(255,255,255,0.08) 0%, transparent 55%);
      pointer-events: none;
    }

    /* ── NAVBAR ── */
    nav {
      position: relative;
      z-index: 100;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 2.5rem;
      height: 60px;
      background: rgba(255,255,255,0.07);
      backdrop-filter: blur(20px);
      border-bottom: 1px solid rgba(255,255,255,0.10);
    }

    .nav-brand {
      display: flex;
      align-items: center;
      gap: 0.6rem;
      text-decoration: none;
    }

    .nav-brand-icon {
      width: 32px; height: 32px;
      background: rgba(255,255,255,0.15);
      border-radius: 8px;
      display: flex; align-items: center; justify-content: center;
      font-size: 0.9rem;
      border: 1px solid rgba(255,255,255,0.2);
    }

    .nav-brand-text {
      font-size: 0.88rem;
      font-weight: 600;
      color: white;
    }

    .nav-brand-text span { font-weight: 300; opacity: 0.75; }

    .nav-links {
      display: flex;
      align-items: center;
      gap: 0.25rem;
      list-style: none;
    }

    .nav-links a, .nav-links button {
      font-family: 'Poppins', sans-serif;
      font-size: 0.78rem;
      font-weight: 400;
      color: rgba(255,255,255,0.75);
      text-decoration: none;
      padding: 0.38rem 0.85rem;
      border-radius: 8px;
      border: none;
      background: none;
      cursor: pointer;
      transition: all 0.18s ease;
      display: flex; align-items: center; gap: 0.3rem;
    }

    .nav-links a:hover, .nav-links button:hover {
      color: white;
      background: rgba(255,255,255,0.12);
    }

    .nav-links .active { color: white; background: rgba(255,255,255,0.15); font-weight: 500; }
    .nav-links .btn-nav-login { color: var(--navy); background: white; font-weight: 500; padding: 0.38rem 1rem; }
    .nav-links .btn-nav-login:hover { background: var(--gray-100); color: var(--navy); }

    /* ── MAIN ── */
    main {
      position: relative;
      z-index: 1;
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem 1.5rem;
    }

    /* ── CARD ── */
    .card {
      background: var(--white);
      border-radius: var(--radius);
      box-shadow: var(--shadow-lg);
      width: 100%;
      max-width: 980px;
      display: grid;
      grid-template-columns: 300px 1fr;
      overflow: hidden;
      animation: cardIn 0.55s cubic-bezier(0.22, 1, 0.36, 1) both;
    }

    @keyframes cardIn {
      from { opacity: 0; transform: translateY(28px) scale(0.98); }
      to   { opacity: 1; transform: translateY(0) scale(1); }
    }

    /* ── LEFT PANEL ── */
    .left-panel {
      background: linear-gradient(160deg, #418aeb 0%, #80b4ec 60%, #3896e2 100%);
      padding: 3rem 2rem;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      position: relative;
      overflow: hidden;
      gap: 1.2rem;
    }

    .left-panel::before {
      content: '';
      position: absolute;
      top: -60px; right: -60px;
      width: 200px; height: 200px;
      border-radius: 50%;
      background: rgba(255,255,255,0.04);
      border: 1px solid rgba(255,255,255,0.06);
    }

    .left-panel::after {
      content: '';
      position: absolute;
      bottom: -80px; left: -40px;
      width: 240px; height: 240px;
      border-radius: 50%;
      background: rgba(59,158,255,0.08);
    }

    .left-badge {
      position: relative; z-index: 1;
      background: rgba(255,255,255,0.08);
      border: 1px solid rgba(255,255,255,0.14);
      border-radius: 50px;
      padding: 0.3rem 1rem;
      font-size: 0.65rem;
      font-weight: 500;
      color: white;
      letter-spacing: 0.12em;
      text-transform: uppercase;
    }

    .logo-wrap {
      position: relative; z-index: 1;
      width: 160px; height: 160px;
      border-radius: 50%;
      background: rgba(255,255,255,0.08);
      border: 1.5px solid rgba(255,255,255,0.15);
      display: flex; align-items: center; justify-content: center;
      padding: 1.2rem;
      box-shadow: 0 8px 32px rgba(0,0,0,0.2), inset 0 1px 0 rgba(255,255,255,0.1);
    }

    .logo-wrap img {
      width: 85%; height: 85%;
      object-fit: contain;
      filter: drop-shadow(0 4px 12px rgba(0,0,0,0.3));
    }

    .left-text {
      position: relative; z-index: 1;
      text-align: center;
    }

    .left-text h2 {
      font-size: 0.95rem;
      font-weight: 600;
      color: white;
      margin-bottom: 0.3rem;
    }

    .left-text p {
      font-size: 0.68rem;
      color: white;
      font-weight: 300;
      line-height: 1.6;
    }

    .left-dots {
      position: relative; z-index: 1;
      display: flex; gap: 6px;
    }

    .left-dots span {
      width: 5px; height: 5px;
      border-radius: 50%;
      background: rgba(255,255,255,0.25);
    }

    .left-dots span.active { background: white; width: 18px; border-radius: 3px; }

    /* ── RIGHT PANEL ── */
    .right-panel {
      padding: 2.5rem 2.8rem;
      display: flex;
      flex-direction: column;
      background: white;
      overflow-y: auto;
    }

    .form-header {
      margin-bottom: 1.5rem;
      animation: fadeUp 0.5s ease 0.15s both;
    }

    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(14px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    .form-header .eyebrow {
      font-size: 0.65rem;
      font-weight: 600;
      letter-spacing: 0.14em;
      text-transform: uppercase;
      color: var(--primary);
      margin-bottom: 0.4rem;
    }

    .form-header h1 {
      font-size: 1.45rem;
      font-weight: 700;
      color: var(--navy);
      letter-spacing: -0.025em;
      line-height: 1.2;
      margin-bottom: 0.3rem;
    }

    .form-header p {
      font-size: 0.78rem;
      color: var(--gray-400);
    }

    /* Back button */
    .btn-back {
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
      font-family: 'Poppins', sans-serif;
      font-size: 0.72rem;
      font-weight: 500;
      color: var(--primary);
      background: var(--gray-100);
      border: none;
      border-radius: 8px;
      padding: 0.35rem 0.8rem;
      cursor: pointer;
      text-decoration: none;
      transition: background 0.18s;
      margin-bottom: 1.2rem;
      width: fit-content;
    }

    .btn-back:hover { background: var(--gray-200); }

    /* ── FORM GRID ── */
    .form-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 0.9rem 1.2rem;
    }

    .form-grid .full { grid-column: 1 / -1; }

    .field { display: flex; flex-direction: column; gap: 0.35rem; }

    .field label {
      font-size: 0.7rem;
      font-weight: 600;
      color: var(--gray-700);
      letter-spacing: 0.03em;
    }

    .field-input-wrap { position: relative; }

    .field-input-wrap svg {
      position: absolute;
      left: 12px; top: 50%;
      transform: translateY(-50%);
      width: 15px; height: 15px;
      color: var(--gray-400);
      pointer-events: none;
      transition: color 0.2s;
    }

    .field-input-wrap input,
    .field-input-wrap select {
      width: 100%;
      padding: 0.68rem 0.9rem 0.68rem 2.5rem;
      border: 1.5px solid var(--gray-200);
      border-radius: 9px;
      font-family: 'Poppins', sans-serif;
      font-size: 0.8rem;
      color: var(--gray-700);
      background: var(--gray-50);
      outline: none;
      transition: all 0.2s ease;
      appearance: none;
    }

    .field-input-wrap input::placeholder { color: var(--gray-400); font-weight: 300; }

    .field-input-wrap input:focus,
    .field-input-wrap select:focus {
      border-color: var(--primary);
      background: white;
      box-shadow: 0 0 0 3px rgba(26,111,196,0.10);
    }

    .field-input-wrap:focus-within svg { color: var(--primary); }

    /* ── REGISTER BUTTON ── */
    .btn-register {
      margin-top: 1.4rem;
      width: 100%;
      padding: 0.82rem 1rem;
      background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
      color: white;
      border: none;
      border-radius: 10px;
      font-family: 'Poppins', sans-serif;
      font-size: 0.85rem;
      font-weight: 600;
      cursor: pointer;
      letter-spacing: 0.04em;
      position: relative;
      overflow: hidden;
      box-shadow: 0 4px 16px rgba(26,111,196,0.38);
      transition: transform 0.15s ease, box-shadow 0.2s ease;
    }

    .btn-register::before {
      content: '';
      position: absolute;
      top: 0; left: -100%;
      width: 60%; height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.18), transparent);
      transition: left 0.5s ease;
    }

    .btn-register:hover::before { left: 160%; }
    .btn-register:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(26,111,196,0.45); }
    .btn-register:active { transform: translateY(0); }

    .login-link {
      text-align: center;
      margin-top: 1rem;
      font-size: 0.78rem;
      color: var(--gray-500);
    }

    .login-link a {
      color: var(--primary);
      font-weight: 600;
      text-decoration: none;
    }

    .login-link a:hover { opacity: 0.75; }

    /* ── FOOTER ── */
    footer {
      position: relative; z-index: 1;
      padding: 1rem 2.5rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-top: 1px solid rgba(255,255,255,0.07);
    }

    .footer-copy {
     font-size: 0.72rem;
      color: rgba(255,255,255,0.85);
      font-weight: 300;
    }

    .footer-links { display: flex; gap: 1.5rem; }

    .footer-links a {
      font-size: 0.72rem;
      color: rgba(255,255,255,0.85);
      text-decoration: none;
      transition: color 0.2s;
    }

    .footer-links a:hover { color: rgba(255,255,255,0.65); }

    /* ── RESPONSIVE ── */
    @media (max-width: 720px) {
      .card { grid-template-columns: 1fr; }
      .left-panel { padding: 2rem; flex-direction: row; flex-wrap: wrap; justify-content: center; gap: 0.8rem; }
      .logo-wrap { width: 70px; height: 70px; padding: 0.6rem; }
      .left-text p, .left-badge, .left-dots { display: none; }
      .right-panel { padding: 2rem 1.5rem; }
      .form-grid { grid-template-columns: 1fr; }
      .form-grid .full { grid-column: 1; }
      footer { flex-direction: column; gap: 0.5rem; text-align: center; }
    }
  </style>
</head>
<body>

  <nav>
    <a class="nav-brand" href="#">
      <div class="nav-brand-icon">🎓</div>
      <span class="nav-brand-text">CCS <span>Sit-in Monitoring System</span></span>
    </a>
    <ul class="nav-links">
      <li><a href="#">Home</a></li>
      <li><button>Community <span style="font-size:0.6rem;opacity:0.7">▾</span></button></li>
      <li><a href="#">About</a></li>
      <li><a href="Login.php">Login</a></li>
      <li><a href="#" class="btn-nav-login">Register</a></li>
    </ul>
  </nav>

  <main>
    <div class="card">

      <!-- Left -->
      <div class="left-panel">
        <div class="left-badge">UC · Est. 1983</div>
       <div class="logo-wrap">
             <img src="University_of_Cebu_Logo.png" alt="University of Cebu Logo"/>
        </div>
        <div class="left-text">
          <h2>University of Cebu</h2>
          <p>College of Computer Studies<br/>Inceptum · Innovatio · Muneris</p>
        </div>
        <div class="left-dots">
          <span></span><span class="active"></span><span></span>
        </div>
      </div>

      <!-- Right -->
      <div class="right-panel">
        <a class="btn-back" href="Login.php">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5"/><path d="M12 19l-7-7 7-7"/></svg>
          Back
        </a>

        <div class="form-header">
          <p class="eyebrow">Registration</p>
          <h1>Create your account</h1>
          <p>Fill in your details to get started</p>
        </div>

        <div class="form-grid">

          <!-- ID Number -->
          <div class="field">
            <label>ID Number</label>
            <div class="field-input-wrap">
              <input type="text" placeholder="e.g. 20-1234-567"/>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
            </div>
          </div>

          <!-- Email -->
          <div class="field">
            <label>Email Address</label>
            <div class="field-input-wrap">
              <input type="email" placeholder="you@example.com"/>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
            </div>
          </div>

          <!-- Last Name -->
          <div class="field">
            <label>Last Name</label>
            <div class="field-input-wrap">
              <input type="text" placeholder="Enter last name"/>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>
          </div>

          <!-- First Name -->
          <div class="field">
            <label>First Name</label>
            <div class="field-input-wrap">
              <input type="text" placeholder="Enter first name"/>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>
          </div>

          <!-- Middle Name -->
          <div class="field">
            <label>Middle Name</label>
            <div class="field-input-wrap">
              <input type="text" placeholder="Enter middle name"/>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>
          </div>

          <!-- Course Level -->
          <div class="field">
            <label>Course Level</label>
            <div class="field-input-wrap">
              <select>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
              </select>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
            </div>
          </div>

          <!-- Course -->
          <div class="field">
            <label>Course</label>
            <div class="field-input-wrap">
              <select>
                <option>BSIT</option>
                <option>BSCS</option>
                <option>BSIS</option>
                <option>ACT</option>
              </select>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
            </div>
          </div>

          <!-- Address -->
          <div class="field">
            <label>Address</label>
            <div class="field-input-wrap">
              <input type="text" placeholder="Enter your address"/>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12S4 16 4 10a8 8 0 1 1 16 0z"/><circle cx="12" cy="10" r="3"/></svg>
            </div>
          </div>

          <!-- Password -->
          <div class="field">
            <label>Password</label>
            <div class="field-input-wrap">
              <input type="password" placeholder="Create a password"/>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            </div>
          </div>

          <!-- Repeat Password -->
          <div class="field">
            <label>Repeat Password</label>
            <div class="field-input-wrap">
              <input type="password" placeholder="Confirm your password"/>
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            </div>
          </div>

        </div>

        <button class="btn-register">Create Account</button>

        <p class="login-link">Already have an account? <a href="Login.php">Sign in here</a></p>
      </div>

    </div>
  </main>

  <footer>
    <span class="footer-copy">&copy; 2024 College of Computer Studies · University of Cebu</span>
    <div class="footer-links">
      <a href="#">Privacy Policy</a>
      <a href="#">Terms of Use</a>
      <a href="#">Support</a>
    </div>
  </footer>

</body>
</html>