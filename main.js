const API = "api/portfolio_api.php";

document.addEventListener("DOMContentLoaded", () => {
    loadProfile();
    loadSkills();
    loadExperience();
    loadEducation();
    loadProjects();
    document.getElementById('contactForm').addEventListener('submit', sendMessage);
});

// ---------- PROFILE + TYPING EFFECT ----------
function loadProfile() {
    fetch(`${API}?resource=profile`)
        .then(r => r.json())
        .then(data => {
            if (data.status !== 'success' || !data.profile) return;
            const p = data.profile;

            typeText(document.getElementById('typedName'), p.full_name || 'Guest', () => {
                document.getElementById('heroTagline').textContent = '$ ' + (p.tagline || '');
            });

            const photo = document.getElementById('aboutPhoto');
            if (p.photo_path) {
                photo.src = p.photo_path;
                photo.classList.remove('d-none');
            }

            document.getElementById('aboutBio').textContent = p.bio || '';
            document.getElementById('aboutEmail').textContent = p.email || '';
            document.getElementById('aboutGithub').href = p.github_url || '#';
            document.getElementById('aboutLinkedin').href = p.linkedin_url || '#';
        });
}

function typeText(el, text, onDone) {
    let i = 0;
    el.textContent = '';
    const interval = setInterval(() => {
        el.textContent += text.charAt(i);
        i++;
        if (i >= text.length) {
            clearInterval(interval);
            if (onDone) onDone();
        }
    }, 80);
}

// ---------- SKILLS ----------
function loadSkills() {
    fetch(`${API}?resource=skills`)
        .then(r => r.json())
        .then(data => {
            const container = document.getElementById('skillsContainer');
            container.innerHTML = '';
            (data.skills || []).forEach(skill => {
                const filled = Math.round(skill.proficiency / 10);
                const bar = '■'.repeat(filled) + '□'.repeat(10 - filled);
                container.innerHTML += `
                    <div class="col-md-6">
                        <div class="skill-row">
                            <div class="d-flex justify-content-between">
                                <span class="skill-name">${skill.skill_name}</span>
                                <span class="skill-category">${skill.category}</span>
                            </div>
                            <div class="skill-bar">[${bar}] ${skill.proficiency}%</div>
                        </div>
                    </div>`;
            });
        });
}

// ---------- EXPERIENCE ----------
function loadExperience() {
    fetch(`${API}?resource=experience`)
        .then(r => r.json())
        .then(data => {
            const container = document.getElementById('experienceTimeline');
            container.innerHTML = '';
            (data.experience || []).forEach(item => {
                container.innerHTML += `
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-content">
                            <div class="timeline-date">${item.start_date} — ${item.end_date}</div>
                            <h5 class="timeline-title">${item.role} <span class="text-muted">@ ${item.company}</span></h5>
                            <p class="mb-0">${item.description || ''}</p>
                        </div>
                    </div>`;
            });
        });
}

// ---------- EDUCATION ----------
function loadEducation() {
    fetch(`${API}?resource=education`)
        .then(r => r.json())
        .then(data => {
            const container = document.getElementById('educationTimeline');
            container.innerHTML = '';
            (data.education || []).forEach(item => {
                container.innerHTML += `
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="timeline-content">
                            <div class="timeline-date">${item.start_date} — ${item.end_date}</div>
                            <h5 class="timeline-title">${item.degree} <span class="text-muted">@ ${item.school}</span></h5>
                            <p class="mb-0">${item.description || ''}</p>
                        </div>
                    </div>`;
            });
        });
}

// ---------- PROJECTS ----------
function loadProjects() {
    fetch(`${API}?resource=projects`)
        .then(r => r.json())
        .then(data => {
            const container = document.getElementById('projectsContainer');
            container.innerHTML = '';
            (data.projects || []).forEach(proj => {
                const badges = (proj.tech_stack || '').split(',')
                    .map(t => `<span class="tech-badge">${t.trim()}</span>`).join(' ');
                const liveLink = proj.project_url ? `<a href="${proj.project_url}" target="_blank" class="link-accent me-3">Live</a>` : '';
                const ghLink = proj.github_url ? `<a href="${proj.github_url}" target="_blank" class="link-accent">GitHub</a>` : '';

                container.innerHTML += `
                    <div class="col-md-4">
                        <div class="project-card h-100">
                            <h5>${proj.title}</h5>
                            <p>${proj.description}</p>
                            <div class="mb-3">${badges}</div>
                            <div>${liveLink}${ghLink}</div>
                        </div>
                    </div>`;
            });
        });
}

// ---------- CONTACT FORM ----------
function sendMessage(e) {
    e.preventDefault();
    const body = {
        name: document.getElementById('contactName').value.trim(),
        email: document.getElementById('contactEmail').value.trim(),
        message: document.getElementById('contactMessage').value.trim()
    };
    fetch(`${API}?resource=messages`, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(body)
    })
        .then(r => r.json())
        .then(data => {
            const status = document.getElementById('contactStatus');
            status.textContent = data.message;
            if (data.status === 'success') document.getElementById('contactForm').reset();
        });
}
