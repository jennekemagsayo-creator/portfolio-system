const API = "../api/portfolio_api.php";

// ---------- Field configuration per resource ----------
const RESOURCE_CONFIG = {
    skills: {
        singular: "skill",
        listKey: "skills",
        fields: [
            { key: "skill_name", label: "Skill Name", type: "text" },
            { key: "proficiency", label: "Proficiency (0-100)", type: "number" },
            { key: "category", label: "Category", type: "text" }
        ]
    },
    experience: {
        singular: "experience",
        listKey: "experience",
        fields: [
            { key: "company", label: "Company", type: "text" },
            { key: "role", label: "Role", type: "text" },
            { key: "start_date", label: "Start Date", type: "text" },
            { key: "end_date", label: "End Date", type: "text" },
            { key: "description", label: "Description", type: "textarea" }
        ]
    },
    education: {
        singular: "education",
        listKey: "education",
        fields: [
            { key: "school", label: "School", type: "text" },
            { key: "degree", label: "Degree", type: "text" },
            { key: "start_date", label: "Start Date", type: "text" },
            { key: "end_date", label: "End Date", type: "text" },
            { key: "description", label: "Description", type: "textarea" }
        ]
    },
    projects: {
        singular: "project",
        listKey: "projects",
        fields: [
            { key: "title", label: "Title", type: "text" },
            { key: "description", label: "Description", type: "textarea" },
            { key: "tech_stack", label: "Tech Stack (comma-separated)", type: "text" },
            { key: "image_path", label: "Image URL", type: "text" },
            { key: "project_url", label: "Live Project URL", type: "text" },
            { key: "github_url", label: "GitHub URL", type: "text" }
        ]
    }
};

let currentModalResource = null;
let currentEditId = null;
const cmsModal = new bootstrap.Modal(document.getElementById('cmsModal'));

document.addEventListener("DOMContentLoaded", () => {
    // Tab switching
    document.querySelectorAll('#cmsTabs .nav-link').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('#cmsTabs .nav-link').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            const tab = btn.dataset.tab;
            document.querySelectorAll('.cms-panel').forEach(p => p.classList.add('d-none'));
            document.getElementById('panel-' + tab).classList.remove('d-none');
            loadTab(tab);
        });
    });

    loadTab('profile');

    document.getElementById('profileForm').addEventListener('submit', saveProfile);
});

function loadTab(tab) {
    if (tab === 'profile') loadProfile();
    else if (tab === 'messages') loadMessages();
    else loadList(tab);
}

// ---------- PROFILE ----------
function loadProfile() {
    fetch(`${API}?resource=profile`)
        .then(r => r.json())
        .then(data => {
            if (data.status !== 'success' || !data.profile) return;
            const p = data.profile;
            document.getElementById('p_full_name').value = p.full_name || '';
            document.getElementById('p_tagline').value = p.tagline || '';
            document.getElementById('p_bio').value = p.bio || '';
            document.getElementById('p_email').value = p.email || '';
            document.getElementById('p_phone').value = p.phone || '';
            document.getElementById('p_github_url').value = p.github_url || '';
            document.getElementById('p_linkedin_url').value = p.linkedin_url || '';
            document.getElementById('p_photo_path').value = p.photo_path || '';
        });
}

function saveProfile(e) {
    e.preventDefault();
    const body = {
        full_name: document.getElementById('p_full_name').value.trim(),
        tagline: document.getElementById('p_tagline').value.trim(),
        bio: document.getElementById('p_bio').value.trim(),
        email: document.getElementById('p_email').value.trim(),
        phone: document.getElementById('p_phone').value.trim(),
        github_url: document.getElementById('p_github_url').value.trim(),
        linkedin_url: document.getElementById('p_linkedin_url').value.trim(),
        photo_path: document.getElementById('p_photo_path').value.trim()
    };
    fetch(`${API}?resource=profile`, {
        method: "PUT",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(body)
    })
        .then(r => r.json())
        .then(data => alert(data.message));
}

// ---------- GENERIC LIST (skills / experience / education / projects) ----------
function loadList(resource) {
    fetch(`${API}?resource=${resource}`)
        .then(r => r.json())
        .then(data => {
            const config = RESOURCE_CONFIG[resource];
            const items = data[config.listKey] || [];
            const tbody = document.getElementById('table-' + resource);
            tbody.innerHTML = '';

            items.forEach(item => {
                let rowHtml = '<tr>';
                if (resource === 'skills') {
                    rowHtml += `<td>${item.skill_name}</td><td>${item.category}</td><td>${item.proficiency}%</td>`;
                } else if (resource === 'experience') {
                    rowHtml += `<td>${item.company}</td><td>${item.role}</td><td>${item.start_date} – ${item.end_date}</td>`;
                } else if (resource === 'education') {
                    rowHtml += `<td>${item.school}</td><td>${item.degree}</td><td>${item.start_date} – ${item.end_date}</td>`;
                } else if (resource === 'projects') {
                    rowHtml += `<td>${item.title}</td><td>${item.tech_stack}</td>`;
                }
                rowHtml += `<td>
                    <button class="btn btn-sm btn-outline-accent" onclick='openEditModal("${resource}", ${JSON.stringify(item)})'>Edit</button>
                    <button class="btn btn-sm btn-outline-danger" onclick="deleteItem('${resource}', ${item.id})">Delete</button>
                </td></tr>`;
                tbody.innerHTML += rowHtml;
            });
        });
}

function openAddModal(resource) {
    currentModalResource = resource;
    currentEditId = null;
    buildModalForm(resource, {});
    document.getElementById('cmsModalTitle').textContent = 'Add ' + RESOURCE_CONFIG[resource].singular;
    cmsModal.show();
}

function openEditModal(resource, item) {
    currentModalResource = resource;
    currentEditId = item.id;
    buildModalForm(resource, item);
    document.getElementById('cmsModalTitle').textContent = 'Edit ' + RESOURCE_CONFIG[resource].singular;
    cmsModal.show();
}

function buildModalForm(resource, item) {
    const config = RESOURCE_CONFIG[resource];
    const form = document.getElementById('cmsForm');
    form.innerHTML = '';
    config.fields.forEach(field => {
        const value = item[field.key] || '';
        const wrapper = document.createElement('div');
        wrapper.className = 'mb-3';
        const inputTag = field.type === 'textarea'
            ? `<textarea class="form-control" id="field_${field.key}" rows="3">${value}</textarea>`
            : `<input type="${field.type}" class="form-control" id="field_${field.key}" value="${value}">`;
        wrapper.innerHTML = `<label class="form-label">${field.label}</label>${inputTag}`;
        form.appendChild(wrapper);
    });
}

function submitCmsForm() {
    const config = RESOURCE_CONFIG[currentModalResource];
    const body = {};
    config.fields.forEach(field => {
        body[field.key] = document.getElementById('field_' + field.key).value.trim();
    });

    const isEdit = currentEditId !== null;
    if (isEdit) body.id = currentEditId;

    fetch(`${API}?resource=${currentModalResource}`, {
        method: isEdit ? "PUT" : "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(body)
    })
        .then(r => r.json())
        .then(data => {
            alert(data.message);
            cmsModal.hide();
            loadList(currentModalResource);
        });
}

function deleteItem(resource, id) {
    if (!confirm('Delete this ' + RESOURCE_CONFIG[resource].singular + '?')) return;
    fetch(`${API}?resource=${resource}&id=${id}`, { method: "DELETE" })
        .then(r => r.json())
        .then(data => {
            alert(data.message);
            loadList(resource);
        });
}

// ---------- MESSAGES ----------
function loadMessages() {
    fetch(`${API}?resource=messages`)
        .then(r => r.json())
        .then(data => {
            const tbody = document.getElementById('table-messages');
            tbody.innerHTML = '';
            (data.messages || []).forEach(m => {
                tbody.innerHTML += `<tr>
                    <td>${m.name}</td>
                    <td>${m.email}</td>
                    <td>${m.message}</td>
                    <td>${m.created_at}</td>
                    <td><button class="btn btn-sm btn-outline-danger" onclick="deleteMessage(${m.id})">Delete</button></td>
                </tr>`;
            });
        });
}

function deleteMessage(id) {
    if (!confirm('Delete this message?')) return;
    fetch(`${API}?resource=messages&id=${id}`, { method: "DELETE" })
        .then(r => r.json())
        .then(data => {
            alert(data.message);
            loadMessages();
        });
}
