<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.head')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #0055d4;
            --primary-dark: #003087;
            --accent: #FFD700;
            --accent-dark: #FFC107;
            --bg-light: #f8fafc;
            --bg-dark: #0f172a;
            --text-light: #1e293b;
            --text-dark: #f1f5f9;
        }

        body {
            background: var(--bg-light);
            color: var(--text-light);
            overflow-x: hidden;
        }

        /* Animated gradient background */
        .gradient-bg {
            position: fixed;
            inset: 0;
            z-index: -1;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 25%, #f093fb 50%, #4facfe 75%, #00f2fe 100%);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            opacity: 0.03;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Floating orbs */
        .orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.2;
            animation: float 20s ease-in-out infinite;
            z-index: -1;
        }

        .orb-1 {
            width: 400px;
            height: 400px;
            background: var(--primary);
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .orb-2 {
            width: 350px;
            height: 350px;
            background: var(--accent);
            bottom: 20%;
            right: 10%;
            animation-delay: 5s;
        }

        .orb-3 {
            width: 300px;
            height: 300px;
            background: #8b5cf6;
            top: 50%;
            right: 30%;
            animation-delay: 10s;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(30px, -30px) scale(1.1); }
            50% { transform: translate(-20px, 20px) scale(0.9); }
            75% { transform: translate(40px, 10px) scale(1.05); }
        }

        /* Navigation */
        nav {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            padding: 1rem 2rem;
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.8);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        nav.scrolled {
            padding: 0.5rem 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .nav-container {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 800;
            font-size: 1.25rem;
            background: linear-gradient(135deg, var(--primary), #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary), #8b5cf6);
            border-radius: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }

        .logo-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--text-light);
            font-weight: 600;
            position: relative;
            transition: color 0.3s ease;
        }

        .nav-links a:hover {
            color: var(--primary);
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary);
            transition: width 0.3s ease;
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        .btn-primary {
            padding: 0.75rem 1.5rem;
            background: linear-gradient(135deg, var(--primary), #8b5cf6);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 85, 212, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(0, 85, 212, 0.4);
        }

        /* Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 6rem 2rem 4rem;
            position: relative;
        }

        .hero-container {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        .hero-content {
            animation: fadeInUp 1s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: linear-gradient(135deg, rgba(255, 215, 0, 0.2), rgba(255, 193, 7, 0.2));
            border: 1px solid rgba(255, 215, 0, 0.3);
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--primary-dark);
            margin-bottom: 1.5rem;
        }

        .badge-icon {
            width: 24px;
            height: 24px;
            background: var(--accent);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        h1 {
            font-size: 4rem;
            font-weight: 900;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, var(--primary-dark), #8b5cf6, var(--primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: fadeInUp 1s ease-out 0.2s both;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            color: #64748b;
            margin-bottom: 2rem;
            line-height: 1.6;
            animation: fadeInUp 1s ease-out 0.4s both;
        }

        .cta-buttons {
            display: flex;
            gap: 1rem;
            margin-bottom: 3rem;
            animation: fadeInUp 1s ease-out 0.6s both;
        }

        .btn-large {
            padding: 1rem 2rem;
            font-size: 1.125rem;
            border-radius: 14px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .btn-gradient {
            background: linear-gradient(135deg, var(--primary), #8b5cf6);
            color: white;
            box-shadow: 0 10px 30px rgba(0, 85, 212, 0.3);
        }

        .btn-gradient:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(0, 85, 212, 0.4);
        }

        .btn-outline {
            background: rgba(255, 255, 255, 0.9);
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .btn-outline:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-3px);
        }

        .stats {
            display: flex;
            gap: 3rem;
            animation: fadeInUp 1s ease-out 0.8s both;
        }

        .stat-item {
            text-align: left;
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 900;
            background: linear-gradient(135deg, var(--primary), #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 0.25rem;
        }

        .stat-label {
            color: #64748b;
            font-size: 0.875rem;
            font-weight: 600;
        }

        /* Hero Visual */
        .hero-visual {
            position: relative;
            animation: fadeInUp 1s ease-out 0.4s both;
        }

        .chat-demo {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 2rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.5);
            animation: floatSlow 6s ease-in-out infinite;
        }

        @keyframes floatSlow {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .chat-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .bot-avatar {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary), #8b5cf6);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .bot-info h4 {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-light);
            margin-bottom: 0.25rem;
        }

        .status {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.75rem;
            color: #10b981;
            font-weight: 600;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            background: #10b981;
            border-radius: 50%;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.4; }
        }

        .chat-messages {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .message {
            padding: 1rem 1.25rem;
            border-radius: 16px;
            max-width: 85%;
            animation: messageSlide 0.5s ease-out;
        }

        @keyframes messageSlide {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .message-bot {
            background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
            align-self: flex-start;
        }

        .message-user {
            background: linear-gradient(135deg, var(--primary), #8b5cf6);
            color: white;
            align-self: flex-end;
        }

        /* Features Section */
        .features {
            padding: 6rem 2rem;
            background: white;
        }

        .section-container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-title {
            font-size: 3rem;
            font-weight: 900;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, var(--primary-dark), #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .section-subtitle {
            font-size: 1.25rem;
            color: #64748b;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }

        .feature-card {
            padding: 2rem;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9), rgba(248, 250, 252, 0.9));
            border-radius: 20px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border-color: var(--primary);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary), #8b5cf6);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }

        .feature-card:hover .feature-icon {
            transform: rotate(5deg) scale(1.1);
        }

        .feature-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--text-light);
        }

        .feature-description {
            color: #64748b;
            line-height: 1.6;
        }

        /* Team Section */
        .team {
            padding: 6rem 2rem;
            background: linear-gradient(135deg, #f8fafc, white);
        }

        .team-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 3rem;
            max-width: 1000px;
            margin: 0 auto;
        }

        .team-card {
            text-align: center;
            transition: transform 0.3s ease;
        }

        .team-card:hover {
            transform: translateY(-10px);
        }

        .team-avatar {
            width: 150px;
            height: 150px;
            margin: 0 auto 1.5rem;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), #8b5cf6);
            padding: 5px;
            transition: all 0.3s ease;
        }

        .team-card:hover .team-avatar {
            transform: scale(1.1);
            box-shadow: 0 20px 40px rgba(0, 85, 212, 0.3);
        }

        .team-avatar-inner {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            font-weight: 900;
            color: var(--primary);
            overflow: hidden;
        }

        .team-avatar-inner img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .team-name {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--text-light);
        }

        .team-role {
            color: #64748b;
            font-weight: 600;
        }

        /* CTA Section */
        .cta {
            padding: 6rem 2rem;
            background: linear-gradient(135deg, var(--primary-dark), var(--primary), #8b5cf6);
            color: white;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url('data:image/svg+xml,<svg width="60" height="60" xmlns="http://www.w3.org/2000/svg"><rect width="1" height="1" fill="white" opacity="0.1"/></svg>');
            opacity: 0.3;
        }

        .cta-content {
            position: relative;
            z-index: 1;
            max-width: 800px;
            margin: 0 auto;
        }

        .cta h2 {
            font-size: 3rem;
            font-weight: 900;
            margin-bottom: 1.5rem;
        }

        .cta p {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .btn-white {
            background: white;
            color: var(--primary);
            padding: 1rem 2rem;
            border-radius: 14px;
            font-weight: 700;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .btn-white:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        }

        footer {
            padding: 2rem;
            text-align: center;
            background: var(--bg-dark);
            color: var(--text-dark);
        }

        @media (max-width: 1024px) {
            .hero-container {
                grid-template-columns: 1fr;
            }
            
            .features-grid,
            .team-grid {
                grid-template-columns: 1fr;
            }
            
            h1 {
                font-size: 3rem;
            }
        }
    </style>
</head>
<body>
    <div class="gradient-bg"></div>
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>

    <!-- Navigation -->
    <nav id="nav">
        <div class="nav-container">
            <div class="logo">
                <div class="logo-icon">
                    <img src="{{ asset('images/assets/PSU logo.png') }}" alt="">
                </div>
                <span>{{ config('app.name') }}</span>
            </div>
            <ul class="nav-links">
                <li><a href="#home">Home</a></li>
                <li><a href="#features">Features</a></li>
                <li><a href="#team">Team</a></li>
                <li><a href="#contact">Contact</a></li>
                <li><button class="btn-primary">Login</button></li>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="hero-container">
            <div class="hero-content">
                <div class="badge">
                    <div class="badge-icon">🎓</div>
                    <span>PSU San Carlos Campus</span>
                </div>
                <h1>Smart Inbox<br>Management<br>System</h1>
                <p class="hero-subtitle">
                    Streamline communication at Pangasinan State University with AI-powered chatbot integration. Never miss an inquiry again.
                </p>
                <div class="cta-buttons">
                    <a href="#features" class="btn-large btn-gradient">
                        View Demo →
                    </a>
                    <a href="#features" class="btn-large btn-outline">
                        Learn More
                    </a>
                </div>
                <div class="stats">
                    <div class="stat-item">
                        <div class="stat-value">24/7</div>
                        <div class="stat-label">AI Availability</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">100%</div>
                        <div class="stat-label">Response Rate</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">⚡ Fast</div>
                        <div class="stat-label">Instant Replies</div>
                    </div>
                </div>
            </div>
            <div class="hero-visual">
                <div class="chat-demo">
                    <div class="chat-header">
                        <div class="bot-avatar">🤖</div>
                        <div class="bot-info">
                            <h4>PSU Chatbot</h4>
                            <div class="status">
                                <div class="status-dot"></div>
                                Online
                            </div>
                        </div>
                    </div>
                    <div class="chat-messages">
                        <div class="message message-bot">
                            Hello! How can I help you today?
                        </div>
                        <div class="message message-user">
                            What are the admission requirements?
                        </div>
                        <div class="message message-bot">
                            Here are the admission requirements for PSU...
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="features">
        <div class="section-container">
            <div class="section-header">
                <h2 class="section-title">Powerful Features</h2>
                <p class="section-subtitle">Everything you need for efficient communication management</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">🤖</div>
                    <h3 class="feature-title">AI Chatbot</h3>
                    <p class="feature-description">Intelligent chatbot handles common inquiries automatically, providing instant responses 24/7.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📊</div>
                    <h3 class="feature-title">Centralized Dashboard</h3>
                    <p class="feature-description">Consolidate messages from all channels into one unified inbox for easy management.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">⚡</div>
                    <h3 class="feature-title">Smart Categorization</h3>
                    <p class="feature-description">Automatically sort and prioritize messages based on content and urgency.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📈</div>
                    <h3 class="feature-title">Analytics & Insights</h3>
                    <p class="feature-description">Track response times, volumes, and satisfaction to improve effectiveness.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🔒</div>
                    <h3 class="feature-title">Secure & Reliable</h3>
                    <p class="feature-description">Enterprise-grade security with role-based access control.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">💬</div>
                    <h3 class="feature-title">Multi-Channel Support</h3>
                    <p class="feature-description">Integrate with Facebook Messenger, website forms, and more.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section id="team" class="team">
        <div class="section-container">
            <div class="section-header">
                <h2 class="section-title">Meet The Team</h2>
                <p class="section-subtitle">The developers behind this innovative solution</p>
            </div>
            <div class="team-grid">
                <div class="team-card">
                    <div class="team-avatar">
                        <div class="team-avatar-inner">
                            <img src="{{ asset('images/assets/dev me.jpg') }}" alt="Orland Benniedict D. Sayson">
                        </div>
                    </div>
                    <h4 class="team-name">Orland Benniedict D. Sayson</h4>
                    <p class="team-role">Lead Developer</p>
                </div>
                <div class="team-card">
                    <div class="team-avatar">
                        <div class="team-avatar-inner">
                            <img src="{{ asset('images/assets/dev vero.jpg') }}" alt="Angeline R. Dalisay">
                        </div>
                    </div>
                    <h4 class="team-name">Angeline R. Dalisay</h4>
                    <p class="team-role">Researcher</p>
                </div>
                <div class="team-card">
                    <div class="team-avatar">
                        <div class="team-avatar-inner">
                            <img src="{{ asset('images/assets/dev bur.jpg') }}" alt="Wilbur V. Grefaldo">
                        </div>
                    </div>
                    <h4 class="team-name">Wilbur V. Grefaldo</h4>
                    <p class="team-role">Researcher</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section id="contact" class="cta">
        <div class="cta-content">
            <h2>Ready to Transform Your Communication?</h2>
            <p>Join PSU San Carlos Campus in revolutionizing stakeholder engagement</p>
            <a href="#" class="btn-white">Get Started Now →</a>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>© 2024 PSU Smart Inbox Management System. All rights reserved.</p>
        <p style="margin-top: 0.5rem; opacity: 0.7;">Pangasinan State University - San Carlos Campus</p>
    </footer>

    <script>
        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });

        // Nav scroll effect
        const nav = document.getElementById('nav');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        });

        // Intersection observer for fade-in animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.feature-card, .team-card').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(el);
        });
    </script>
</body>
</html>