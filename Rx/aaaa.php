<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>TVS Engineering Services</title>
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
    /* ===== Variables ===== */
    :root {
        --primary: #1e3a8a;
        --secondary: #60a5fa;
        --bg: #f3f4f6;
        --light: #ffffff;
        --dark: #333333;
        --trans: 0.3s ease;
    }

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: 'Montserrat', sans-serif;
        background: var(--bg);
        color: var(--dark);
    }

    /* ส่วนนี้ใส่ไว้หลัง CSS ปัจจุบัน */
    .reveal {
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.6s ease-out;
    }

    .reveal.show {
        opacity: 1;
        transform: translateY(0);
    }


    a {
        text-decoration: none;
        color: inherit;
    }

    img,
    video {
        max-width: 100%;
        display: block;
    }

    /* ===== Container ===== */
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* ===== Header ===== */
    header {
        background: var(--light);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        position: sticky;
        top: 0;
        z-index: 100;
    }

    .nav {
        display: flex;
        align-items: center;
        justify-content: space-between;
        height: 70px;
    }

    .logo {
        display: flex;
        align-items: center;
    }

    .logo img {
        height: 40px;
        margin-right: 8px;
    }

    .logo span {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--primary);
    }

    /* Nav Links */
    .nav-links {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .nav-links a {
        position: relative;
        padding: 8px 0;
        font-weight: 600;
        color: var(--dark);
    }

    .nav-links a::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 0;
        height: 2px;
        background: var(--primary);
        transition: width var(--trans);
    }

    .nav-links a:hover::after {
        width: 100%;
    }

    /* Dropdown “More” */
    .dropdown {
        position: relative;
    }

    .btn-dropdown {
        background: transparent;
        border: none;
        font: inherit;
        padding: 8px 12px;
        cursor: pointer;
        font-weight: 600;
        transition: color var(--trans);
        color: var(--dark);
    }

    .btn-dropdown:hover {
        color: var(--primary);
    }

    .dropdown-content {
        position: absolute;
        top: calc(100% + 4px);
        right: 0;
        background: var(--light);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 4px;
        overflow: hidden;
        display: none;
        z-index: 150;
    }

    .dropdown-content a {
        display: block;
        padding: 8px 16px;
        white-space: nowrap;
        font-size: 0.95rem;
        color: var(--dark);
        transition: background var(--trans);
    }

    .dropdown-content a:hover {
        background: var(--bg);
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }

    /* Auth Buttons */
    .auth-buttons {
        display: flex;
        gap: 12px;
    }

    .btn {
        display: inline-block;
        padding: 8px 16px;
        border-radius: 4px;
        font-weight: 600;
        transition: background var(--trans), color var(--trans);
    }

    .btn-login {
        background: transparent;
        border: 2px solid var(--primary);
        color: var(--primary);
    }

    .btn-login:hover {
        background: var(--primary);
        color: var(--light);
    }

    .btn-register {
        background: var(--primary);
        border: 2px solid var(--primary);
        color: var(--light);
    }

    .btn-register:hover {
        background: transparent;
        color: var(--primary);
    }

    /* Hamburger (mobile) */
    .hamburger {
        display: none;
        cursor: pointer;
    }

    .hamburger div {
        width: 25px;
        height: 3px;
        background: var(--dark);
        margin: 5px 0;
        transition: all var(--trans);
    }

    @media(max-width:768px) {

        .nav-links,
        .auth-buttons {
            display: none;
        }

        .hamburger {
            display: block;
        }

        .mobile-menu {
            display: none;
            flex-direction: column;
            background: var(--light);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .mobile-menu a,
        .mobile-menu .btn {
            padding: 12px 20px;
            border-bottom: 1px solid #ececec;
        }

        .mobile-menu.open {
            display: flex;
        }
    }

    @media(min-width:769px) {
        .mobile-menu {
            display: none !important;
        }
    }

    /* ===== Hero ===== */
    #hero {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: var(--light);
        text-align: center;
        padding: 100px 20px;
        position: relative;
        overflow: hidden;
    }

    #hero h1 {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 20px;
    }

    #hero p {
        font-size: 1.25rem;
        margin-bottom: 30px;
    }

    .btn-cta {
        background: var(--light);
        color: var(--primary);
        padding: 14px 28px;
        border-radius: 50px;
        font-size: 1rem;
        font-weight: 600;
        transition: background var(--trans), transform var(--trans);
    }

    .btn-cta:hover {
        background: #ffffffcc;
        transform: translateY(-3px);
    }

    #hero::after {
        content: '';
        position: absolute;
        bottom: -50px;
        left: 50%;
        transform: translateX(-50%);
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background: var(--light);
        opacity: 0.1;
    }

    /* ===== Services ===== */
    #services {
        padding: 60px 20px;
    }

    #services h2 {
        text-align: center;
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 40px;
        color: var(--primary);
    }

    .services-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 30px;
    }

    .service-card {
        background: var(--light);
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        transition: transform var(--trans), box-shadow var(--trans);
    }

    .service-card img {
        height: 60px;
        margin-bottom: 16px;
    }

    .service-card h3 {
        font-size: 1.125rem;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .service-card p {
        font-size: 0.95rem;
        color: #555;
    }

    .service-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    /* ===== Video Section ===== */
    #report {
        padding: 60px 20px;
        background: #fff;
    }

    #report h2 {
        text-align: center;
        font-size: 1.75rem;
        font-weight: 800;
        margin-bottom: 20px;
        color: var(--primary);
    }

    .video-wrapper {
        position: relative;
        padding-bottom: 56.25%;
        /* 16:9 */
        height: 0;
        overflow: hidden;
        max-width: 800px;
        margin: 0 auto;
    }

    .video-wrapper video {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border-radius: 8px;
    }

    /* ===== Modal ===== */
    #modal-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
        z-index: 200;
        visibility: hidden;
        opacity: 0;
        transition: opacity var(--trans), visibility var(--trans);
    }

    #modal-backdrop.show {
        visibility: visible;
        opacity: 1;
    }

    .modal {
        background: var(--light);
        border-radius: 8px;
        width: 100%;
        max-width: 400px;
        padding: 24px;
        position: relative;
    }

    .modal-close {
        position: absolute;
        top: 12px;
        right: 12px;
        font-size: 1.5rem;
        color: #888;
        cursor: pointer;
    }

    .modal h3 {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 16px;
    }

    .modal form label {
        display: block;
        margin-bottom: 8px;
        font-size: 0.9rem;
        color: #444;
    }

    .modal form input {
        width: 100%;
        padding: 8px;
        margin-bottom: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .modal form .actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
    }

    /* ===== Footer ===== */
    footer {
        background: var(--light);
        text-align: center;
        padding: 20px;
        border-top: 1px solid #e2e8f0;
        font-size: 0.9rem;
        color: #777;
    }
    </style>
</head>

<body>

    <!-- Header -->
    <header>
        <div class="container nav">
            <div class="logo">
                <img src="logo.png" alt="TVS Logo">
                <span>TVS</span>
            </div>
            <nav class="nav-links">
                <a href="#">Volicon</a>
                <a href="#">TV On-line</a>
                <a href="#">Playlist</a>
                <a href="#">FTP Record</a>
                <a href="#">Live Event</a>
                <div class="dropdown">
                    <button class="btn-dropdown">More ▾</button>
                    <div class="dropdown-content">
                        <a href="#">Offair Record</a>
                        <a href="#">GC-EM-FTP</a>
                        <a href="#">Ingest</a>
                        <a href="#">VOD</a>
                        <a href="#">Logo Corner</a>
                        <a href="#">TVC Asrunlog</a>
                    </div>
                </div>
            </nav>
            <div class="auth-buttons">
                <a href="#" class="btn btn-login" id="open-login">Login</a>
                <a href="#" class="btn btn-register" id="open-register">Register</a>
            </div>
            <div class="hamburger" id="hamburger">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
        <div class="mobile-menu" id="mobile-menu">
            <a href="#">Volicon</a>
            <a href="#">TV On-line</a>
            <a href="#">Playlist</a>
            <a href="#">FTP Record</a>
            <a href="#">Live Event</a>
            <a href="#">Offair Record</a>
            <a href="#">GC-EM-FTP</a>
            <a href="#">Ingest</a>
            <a href="#">VOD</a>
            <a href="#">Logo Corner</a>
            <a href="#">TVC Asrunlog</a>
            <a href="#" class="btn btn-login" id="mob-login">Login</a>
            <a href="#" class="btn btn-register" id="mob-register">Register</a>
        </div>
    </header>

    <!-- Hero -->
    <section id="hero">
        <div class="container">
            <h1 class="reveal">TRANSMISSION</h1>
            <p class="reveal">Engineering Department</p>
            <a href="#services" class="btn-cta reveal">ดูบริการของเรา</a>
        </div>
    </section>

    <!-- Services -->
    <section id="services">
        <div class="container">
            <h2>บริการของเรา</h2>
            <div class="services-grid">
                <div class="service-card reveal">
                    <img src="icon-volicon.svg" alt="Volicon">
                    <h3>Volicon</h3>
                    <p>Monitor &amp; record video streams in real time.</p>
                </div>
                <div class="service-card reveal">
                    <img src="icon-tv.svg" alt="TV On-line">
                    <h3>TV On-line</h3>
                    <p>Live streaming ผ่านเว็บและอุปกรณ์มือถือ</p>
                </div>
                <div class="service-card reveal">
                    <img src="icon-playlist.svg" alt="Playlist">
                    <h3>Playlist</h3>
                    <p>จัดการรายการเล่นวิดีโออย่างมืออาชีพ</p>
                </div>
                <div class="service-card reveal">
                    <img src="icon-ftp.svg" alt="FTP Record">
                    <h3>FTP Record</h3>
                    <p>อัพโหลดไฟล์บันทึกอัตโนมัติไปยังเซิร์ฟเวอร์</p>
                </div>
                <div class="service-card reveal">
                    <img src="icon-live.svg" alt="Live Event">
                    <h3>Live Event</h3>
                    <p>ถ่ายทอดสดอีเวนท์ใหญ่ ด้วยความเสถียรสูง</p>
                </div>
                <div class="service-card reveal">
                    <img src="icon-offair.svg" alt="Offair Record">
                    <h3>Offair Record</h3>
                    <p>บันทึกเนื้อหาออนแอร์จากระบบออกอากาศ</p>
                </div>
                <div class="service-card reveal">
                    <img src="icon-gc-em-ftp.svg" alt="GC-EM-FTP">
                    <h3>GC-EM-FTP</h3>
                    <p>ส่งไฟล์งานกลุ่ม GC-EM ผ่าน FTP อย่างปลอดภัย</p>
                </div>
                <div class="service-card reveal">
                    <img src="icon-ingest.svg" alt="Ingest">
                    <h3>Ingest</h3>
                    <p>นำเข้าวิดีโอเข้าระบบ พร้อม metadata ครบถ้วน</p>
                </div>
                <div class="service-card reveal">
                    <img src="icon-vod.svg" alt="VOD">
                    <h3>VOD</h3>
                    <p>จัดการและสตรีมวิดีโอตามคำขอแบบ Video-on-Demand</p>
                </div>
                <div class="service-card reveal">
                    <img src="icon-logo-corner.svg" alt="Logo Corner">
                    <h3>Logo Corner</h3>
                    <p>เพิ่มโลโก้หรือมาร์กเกอร์มุมจออัตโนมัติ</p>
                </div>
                <div class="service-card reveal">
                    <img src="icon-tvc-asrunlog.svg" alt="TVC Asrunlog">
                    <h3>TVC Asrunlog</h3>
                    <p>เก็บบันทึกการออกอากาศ (as-run log) ของ TVC</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Video / Report -->
    <section id="report">
        <div class="container">
            <h2>Engineering Report</h2>
            <div class="video-wrapper">
                <video controls poster="poster.jpg">
                    <source src="report.mp4" type="video/mp4">
                    Your browser does not support HTML5 video.
                </video>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            © 2025 TVS Engineering Services. สงวนลิขสิทธิ์.
        </div>
    </footer>

    <!-- Modal Login/Register -->
    <div id="modal-backdrop">
        <div class="modal">
            <span class="modal-close" id="modal-close">&times;</span>
            <h3 id="modal-title">Login</h3>
            <form>
                <label>Email</label>
                <input type="email" placeholder="you@example.com" required>
                <label>Password</label>
                <input type="password" required>
                <div class="actions">
                    <button type="button" id="modal-cancel" class="btn">Cancel</button>
                    <button type="submit" class="btn btn-register">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    // Toggle mobile menu
    document.getElementById('hamburger').addEventListener('click', () => {
        document.getElementById('mobile-menu').classList.toggle('open');
    });
    // Modal logic
    const backdrop = document.getElementById('modal-backdrop');
    const title = document.getElementById('modal-title');
    ['open-login', 'open-register', 'mob-login', 'mob-register'].forEach(id => {
        document.getElementById(id).addEventListener('click', e => {
            e.preventDefault();
            title.textContent = e.target.textContent.trim();
            backdrop.classList.add('show');
        });
    });
    ['modal-close', 'modal-cancel', 'modal-backdrop'].forEach(id => {
        document.getElementById(id).addEventListener('click', e => {
            if (e.target.id === id) backdrop.classList.remove('show');
        });
    });
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const observer = new IntersectionObserver((entries, obs) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('show');
                    obs.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.2
        });

        document.querySelectorAll('.reveal').forEach(el => {
            observer.observe(el);
        });
    });
    </script>

</body>

</html>