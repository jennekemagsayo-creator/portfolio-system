<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — Portfolio CMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style/style.css">
</head>
<body class="admin-body">

    <nav class="navbar admin-navbar">
        <div class="container-fluid">
            <span class="navbar-brand">$ cms --dashboard</span>
            <span class="text-muted">
                Logged in as <?= htmlspecialchars($_SESSION['admin_username']) ?>
                &mdash; <a href="logout.php" class="link-accent">logout</a>
            </span>
        </div>
    </nav>

    <div class="container my-4">

        <ul class="nav nav-tabs mb-4" id="cmsTabs">
            <li class="nav-item"><button class="nav-link active" data-tab="profile">$ profile</button></li>
            <li class="nav-item"><button class="nav-link" data-tab="skills">$ skills</button></li>
            <li class="nav-item"><button class="nav-link" data-tab="experience">$ experience</button></li>
            <li class="nav-item"><button class="nav-link" data-tab="education">$ education</button></li>
            <li class="nav-item"><button class="nav-link" data-tab="projects">$ projects</button></li>
            <li class="nav-item"><button class="nav-link" data-tab="messages">$ messages</button></li>
        </ul>

        <!-- PROFILE TAB -->
        <div class="cms-panel" id="panel-profile">
            <div class="terminal-window">
                <div class="terminal-header">
                    <span class="dot red"></span><span class="dot yellow"></span><span class="dot green"></span>
                    <span class="terminal-title">edit-profile.php</span>
                </div>
                <div class="terminal-body">
                    <form id="profileForm">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="p_full_name">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tagline / Title</label>
                                <input type="text" class="form-control" id="p_tagline">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Bio</label>
                                <textarea class="form-control" id="p_bio" rows="4"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" id="p_email">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone</label>
                                <input type="text" class="form-control" id="p_phone">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">GitHub URL</label>
                                <input type="text" class="form-control" id="p_github_url">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">LinkedIn URL</label>
                                <input type="text" class="form-control" id="p_linkedin_url">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Photo path / URL</label>
                                <input type="text" class="form-control" id="p_photo_path">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-accent mt-3">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- SKILLS TAB -->
        <div class="cms-panel d-none" id="panel-skills">
            <button class="btn btn-accent mb-3" onclick="openAddModal('skills')">+ Add Skill</button>
            <table class="table cms-table">
                <thead><tr><th>Skill</th><th>Category</th><th>Proficiency</th><th>Actions</th></tr></thead>
                <tbody id="table-skills"></tbody>
            </table>
        </div>

        <!-- EXPERIENCE TAB -->
        <div class="cms-panel d-none" id="panel-experience">
            <button class="btn btn-accent mb-3" onclick="openAddModal('experience')">+ Add Experience</button>
            <table class="table cms-table">
                <thead><tr><th>Company</th><th>Role</th><th>Dates</th><th>Actions</th></tr></thead>
                <tbody id="table-experience"></tbody>
            </table>
        </div>

        <!-- EDUCATION TAB -->
        <div class="cms-panel d-none" id="panel-education">
            <button class="btn btn-accent mb-3" onclick="openAddModal('education')">+ Add Education</button>
            <table class="table cms-table">
                <thead><tr><th>School</th><th>Degree</th><th>Dates</th><th>Actions</th></tr></thead>
                <tbody id="table-education"></tbody>
            </table>
        </div>

        <!-- PROJECTS TAB -->
        <div class="cms-panel d-none" id="panel-projects">
            <button class="btn btn-accent mb-3" onclick="openAddModal('projects')">+ Add Project</button>
            <table class="table cms-table">
                <thead><tr><th>Title</th><th>Tech Stack</th><th>Actions</th></tr></thead>
                <tbody id="table-projects"></tbody>
            </table>
        </div>

        <!-- MESSAGES TAB -->
        <div class="cms-panel d-none" id="panel-messages">
            <table class="table cms-table">
                <thead><tr><th>Name</th><th>Email</th><th>Message</th><th>Received</th><th>Actions</th></tr></thead>
                <tbody id="table-messages"></tbody>
            </table>
        </div>

    </div>

    <!-- Shared Add/Edit Modal (fields injected by JS) -->
    <div class="modal fade" id="cmsModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content cms-modal">
                <div class="modal-header">
                    <h5 class="modal-title" id="cmsModalTitle">Add Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="cmsForm"></form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-accent" onclick="submitCmsForm()">Save</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="admin.js"></script>
</body>
</html>
