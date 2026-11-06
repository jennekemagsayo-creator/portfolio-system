<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio</title>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style/style.css">
</head>
<body>

    <!-- NAV -->
    <nav class="navbar navbar-expand-lg fixed-top terminal-nav">
        <div class="container">
            <a class="navbar-brand" href="#hero">~/portfolio</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#about">$ about</a></li>
                    <li class="nav-item"><a class="nav-link" href="#skills">$ skills</a></li>
                    <li class="nav-item"><a class="nav-link" href="#experience">$ experience</a></li>
                    <li class="nav-item"><a class="nav-link" href="#projects">$ projects</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">$ contact</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- HERO -->
    <section id="hero" class="hero-section d-flex align-items-center">
        <div class="container">
            <div class="terminal-window hero-terminal mx-auto">
                <div class="terminal-header">
                    <span class="dot red"></span><span class="dot yellow"></span><span class="dot green"></span>
                    <span class="terminal-title">visitor@portfolio: ~</span>
                </div>
                <div class="terminal-body">
                    <p class="mb-1">$ whoami</p>
                    <h1 class="hero-name"><span id="typedName"></span><span class="cursor">_</span></h1>
                    <p class="hero-tagline" id="heroTagline">&nbsp;</p>
                    <p class="mb-0 mt-3">$ <a href="#about" class="link-accent">cat about.txt</a></p>
                </div>
            </div>
        </div>
    </section>

    <!-- ABOUT -->
    <section id="about" class="section-block">
        <div class="container">
            <h2 class="section-heading">$ about</h2>
            <div class="terminal-window">
                <div class="terminal-header">
                    <span class="dot red"></span><span class="dot yellow"></span><span class="dot green"></span>
                    <span class="terminal-title">about.txt</span>
                </div>
                <div class="terminal-body">
                    <img id="aboutPhoto" class="profile-photo d-none" alt="Profile photo">
                    <p id="aboutBio">Loading...</p>
                    <p class="mb-0">
                        <span class="text-muted">contact:</span> <span id="aboutEmail"></span>
                        &nbsp;|&nbsp;
                        <a id="aboutGithub" href="#" target="_blank" class="link-accent">GitHub</a>
                        &nbsp;|&nbsp;
                        <a id="aboutLinkedin" href="#" target="_blank" class="link-accent">LinkedIn</a>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- SKILLS -->
    <section id="skills" class="section-block section-alt">
        <div class="container">
            <h2 class="section-heading">$ skills --list</h2>
            <div id="skillsContainer" class="row g-3"></div>
        </div>
    </section>

    <!-- EXPERIENCE & EDUCATION -->
    <section id="experience" class="section-block">
        <div class="container">
            <h2 class="section-heading">$ git log --experience</h2>
            <div id="experienceTimeline" class="timeline mb-5"></div>

            <h2 class="section-heading">$ git log --education</h2>
            <div id="educationTimeline" class="timeline"></div>
        </div>
    </section>

    <!-- PROJECTS -->
    <section id="projects" class="section-block section-alt">
        <div class="container">
            <h2 class="section-heading">$ ls ./projects</h2>
            <div id="projectsContainer" class="row g-4"></div>
        </div>
    </section>

    <!-- CONTACT -->
    <section id="contact" class="section-block">
        <div class="container">
            <h2 class="section-heading">$ contact --send</h2>
            <div class="terminal-window mx-auto contact-terminal">
                <div class="terminal-header">
                    <span class="dot red"></span><span class="dot yellow"></span><span class="dot green"></span>
                    <span class="terminal-title">send_message.php</span>
                </div>
                <div class="terminal-body">
                    <form id="contactForm">
                        <div class="mb-3">
                            <label class="form-label">name</label>
                            <input type="text" class="form-control" id="contactName" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">email</label>
                            <input type="email" class="form-control" id="contactEmail" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">message</label>
                            <textarea class="form-control" id="contactMessage" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-accent">./send</button>
                        <span id="contactStatus" class="ms-3"></span>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer-block text-center">
        <p class="mb-0">// built with PHP, MySQL &amp; Bootstrap</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
