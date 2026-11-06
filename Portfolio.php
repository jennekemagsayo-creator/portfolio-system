<?php
class Portfolio {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // ---------- PROFILE (single row) ----------
    public function getProfile() {
        $stmt = $this->conn->prepare("SELECT * FROM profile LIMIT 1");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProfile($data) {
        $query = "UPDATE profile SET full_name=?, tagline=?, bio=?, email=?, phone=?, github_url=?, linkedin_url=?, photo_path=? WHERE id=1";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            $data['full_name'], $data['tagline'], $data['bio'], $data['email'],
            $data['phone'], $data['github_url'], $data['linkedin_url'], $data['photo_path']
        ]);
    }

    // ---------- SKILLS ----------
    public function getAllSkills() {
        $stmt = $this->conn->prepare("SELECT * FROM skills ORDER BY category, id ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSkillById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM skills WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addSkill($skill_name, $proficiency, $category) {
        $stmt = $this->conn->prepare("INSERT INTO skills (skill_name, proficiency, category) VALUES (?, ?, ?)");
        return $stmt->execute([$skill_name, $proficiency, $category]);
    }

    public function updateSkill($id, $skill_name, $proficiency, $category) {
        $stmt = $this->conn->prepare("UPDATE skills SET skill_name=?, proficiency=?, category=? WHERE id=?");
        return $stmt->execute([$skill_name, $proficiency, $category, $id]);
    }

    public function deleteSkill($id) {
        $stmt = $this->conn->prepare("DELETE FROM skills WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // ---------- EXPERIENCE ----------
    public function getAllExperience() {
        $stmt = $this->conn->prepare("SELECT * FROM experience ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getExperienceById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM experience WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addExperience($company, $role, $start_date, $end_date, $description) {
        $stmt = $this->conn->prepare("INSERT INTO experience (company, role, start_date, end_date, description) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$company, $role, $start_date, $end_date, $description]);
    }

    public function updateExperience($id, $company, $role, $start_date, $end_date, $description) {
        $stmt = $this->conn->prepare("UPDATE experience SET company=?, role=?, start_date=?, end_date=?, description=? WHERE id=?");
        return $stmt->execute([$company, $role, $start_date, $end_date, $description, $id]);
    }

    public function deleteExperience($id) {
        $stmt = $this->conn->prepare("DELETE FROM experience WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // ---------- EDUCATION ----------
    public function getAllEducation() {
        $stmt = $this->conn->prepare("SELECT * FROM education ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEducationById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM education WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addEducation($school, $degree, $start_date, $end_date, $description) {
        $stmt = $this->conn->prepare("INSERT INTO education (school, degree, start_date, end_date, description) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$school, $degree, $start_date, $end_date, $description]);
    }

    public function updateEducation($id, $school, $degree, $start_date, $end_date, $description) {
        $stmt = $this->conn->prepare("UPDATE education SET school=?, degree=?, start_date=?, end_date=?, description=? WHERE id=?");
        return $stmt->execute([$school, $degree, $start_date, $end_date, $description, $id]);
    }

    public function deleteEducation($id) {
        $stmt = $this->conn->prepare("DELETE FROM education WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // ---------- PROJECTS ----------
    public function getAllProjects() {
        $stmt = $this->conn->prepare("SELECT * FROM projects ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProjectById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM projects WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addProject($title, $description, $tech_stack, $image_path, $project_url, $github_url) {
        $stmt = $this->conn->prepare("INSERT INTO projects (title, description, tech_stack, image_path, project_url, github_url) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$title, $description, $tech_stack, $image_path, $project_url, $github_url]);
    }

    public function updateProject($id, $title, $description, $tech_stack, $image_path, $project_url, $github_url) {
        $stmt = $this->conn->prepare("UPDATE projects SET title=?, description=?, tech_stack=?, image_path=?, project_url=?, github_url=? WHERE id=?");
        return $stmt->execute([$title, $description, $tech_stack, $image_path, $project_url, $github_url, $id]);
    }

    public function deleteProject($id) {
        $stmt = $this->conn->prepare("DELETE FROM projects WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // ---------- MESSAGES (contact form) ----------
    public function getAllMessages() {
        $stmt = $this->conn->prepare("SELECT * FROM messages ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addMessage($name, $email, $message) {
        $stmt = $this->conn->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
        return $stmt->execute([$name, $email, $message]);
    }

    public function deleteMessage($id) {
        $stmt = $this->conn->prepare("DELETE FROM messages WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
