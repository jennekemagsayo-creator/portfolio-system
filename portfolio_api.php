<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

include '../database.php';
include '../class/Portfolio.php';

$database = new Database();
$db = $database->getConnection();

if (!$db) {
    echo json_encode(["status" => "error", "message" => "Database connection failed"]);
    exit;
}

$portfolio = new Portfolio($db);

$method = $_SERVER['REQUEST_METHOD'];
$resource = isset($_GET['resource']) ? $_GET['resource'] : '';

// Helper: read JSON body for POST/PUT
function getJsonBody() {
    $data = json_decode(file_get_contents("php://input"), true);
    return $data ?: [];
}

switch ($resource) {

    // ===================== PROFILE =====================
    case 'profile':
        if ($method === 'GET') {
            echo json_encode(["status" => "success", "profile" => $portfolio->getProfile()]);
        } elseif ($method === 'PUT') {
            $data = getJsonBody();
            $required = ['full_name', 'tagline', 'bio', 'email', 'phone', 'github_url', 'linkedin_url', 'photo_path'];
            foreach ($required as $field) {
                if (!isset($data[$field])) $data[$field] = '';
            }
            $result = $portfolio->updateProfile($data);
            echo json_encode($result
                ? ["status" => "success", "message" => "Profile updated successfully"]
                : ["status" => "error", "message" => "Failed to update profile"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid method for profile"]);
        }
        break;

    // ===================== SKILLS =====================
    case 'skills':
        if ($method === 'GET') {
            if (isset($_GET['id'])) {
                $item = $portfolio->getSkillById($_GET['id']);
                echo json_encode($item
                    ? ["status" => "success", "skill" => $item]
                    : ["status" => "error", "message" => "Skill not found"]);
            } else {
                echo json_encode(["status" => "success", "skills" => $portfolio->getAllSkills()]);
            }
        } elseif ($method === 'POST') {
            $data = getJsonBody();
            if (isset($data['skill_name'], $data['proficiency'], $data['category'])) {
                $result = $portfolio->addSkill($data['skill_name'], $data['proficiency'], $data['category']);
                echo json_encode($result
                    ? ["status" => "success", "message" => "Skill added successfully"]
                    : ["status" => "error", "message" => "Failed to add skill"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Invalid input"]);
            }
        } elseif ($method === 'PUT') {
            $data = getJsonBody();
            if (isset($data['id'], $data['skill_name'], $data['proficiency'], $data['category'])) {
                $result = $portfolio->updateSkill($data['id'], $data['skill_name'], $data['proficiency'], $data['category']);
                echo json_encode($result
                    ? ["status" => "success", "message" => "Skill updated successfully"]
                    : ["status" => "error", "message" => "Failed to update skill"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Invalid input"]);
            }
        } elseif ($method === 'DELETE') {
            if (isset($_GET['id'])) {
                $result = $portfolio->deleteSkill($_GET['id']);
                echo json_encode($result
                    ? ["status" => "success", "message" => "Skill deleted successfully"]
                    : ["status" => "error", "message" => "Failed to delete skill"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Invalid ID"]);
            }
        }
        break;

    // ===================== EXPERIENCE =====================
    case 'experience':
        if ($method === 'GET') {
            if (isset($_GET['id'])) {
                $item = $portfolio->getExperienceById($_GET['id']);
                echo json_encode($item
                    ? ["status" => "success", "experience" => $item]
                    : ["status" => "error", "message" => "Experience not found"]);
            } else {
                echo json_encode(["status" => "success", "experience" => $portfolio->getAllExperience()]);
            }
        } elseif ($method === 'POST') {
            $data = getJsonBody();
            if (isset($data['company'], $data['role'], $data['start_date'], $data['end_date'])) {
                $description = $data['description'] ?? '';
                $result = $portfolio->addExperience($data['company'], $data['role'], $data['start_date'], $data['end_date'], $description);
                echo json_encode($result
                    ? ["status" => "success", "message" => "Experience added successfully"]
                    : ["status" => "error", "message" => "Failed to add experience"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Invalid input"]);
            }
        } elseif ($method === 'PUT') {
            $data = getJsonBody();
            if (isset($data['id'], $data['company'], $data['role'], $data['start_date'], $data['end_date'])) {
                $description = $data['description'] ?? '';
                $result = $portfolio->updateExperience($data['id'], $data['company'], $data['role'], $data['start_date'], $data['end_date'], $description);
                echo json_encode($result
                    ? ["status" => "success", "message" => "Experience updated successfully"]
                    : ["status" => "error", "message" => "Failed to update experience"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Invalid input"]);
            }
        } elseif ($method === 'DELETE') {
            if (isset($_GET['id'])) {
                $result = $portfolio->deleteExperience($_GET['id']);
                echo json_encode($result
                    ? ["status" => "success", "message" => "Experience deleted successfully"]
                    : ["status" => "error", "message" => "Failed to delete experience"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Invalid ID"]);
            }
        }
        break;

    // ===================== EDUCATION =====================
    case 'education':
        if ($method === 'GET') {
            if (isset($_GET['id'])) {
                $item = $portfolio->getEducationById($_GET['id']);
                echo json_encode($item
                    ? ["status" => "success", "education" => $item]
                    : ["status" => "error", "message" => "Education not found"]);
            } else {
                echo json_encode(["status" => "success", "education" => $portfolio->getAllEducation()]);
            }
        } elseif ($method === 'POST') {
            $data = getJsonBody();
            if (isset($data['school'], $data['degree'], $data['start_date'], $data['end_date'])) {
                $description = $data['description'] ?? '';
                $result = $portfolio->addEducation($data['school'], $data['degree'], $data['start_date'], $data['end_date'], $description);
                echo json_encode($result
                    ? ["status" => "success", "message" => "Education added successfully"]
                    : ["status" => "error", "message" => "Failed to add education"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Invalid input"]);
            }
        } elseif ($method === 'PUT') {
            $data = getJsonBody();
            if (isset($data['id'], $data['school'], $data['degree'], $data['start_date'], $data['end_date'])) {
                $description = $data['description'] ?? '';
                $result = $portfolio->updateEducation($data['id'], $data['school'], $data['degree'], $data['start_date'], $data['end_date'], $description);
                echo json_encode($result
                    ? ["status" => "success", "message" => "Education updated successfully"]
                    : ["status" => "error", "message" => "Failed to update education"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Invalid input"]);
            }
        } elseif ($method === 'DELETE') {
            if (isset($_GET['id'])) {
                $result = $portfolio->deleteEducation($_GET['id']);
                echo json_encode($result
                    ? ["status" => "success", "message" => "Education deleted successfully"]
                    : ["status" => "error", "message" => "Failed to delete education"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Invalid ID"]);
            }
        }
        break;

    // ===================== PROJECTS =====================
    case 'projects':
        if ($method === 'GET') {
            if (isset($_GET['id'])) {
                $item = $portfolio->getProjectById($_GET['id']);
                echo json_encode($item
                    ? ["status" => "success", "project" => $item]
                    : ["status" => "error", "message" => "Project not found"]);
            } else {
                echo json_encode(["status" => "success", "projects" => $portfolio->getAllProjects()]);
            }
        } elseif ($method === 'POST') {
            $data = getJsonBody();
            if (isset($data['title'], $data['description'], $data['tech_stack'])) {
                $image_path = $data['image_path'] ?? '';
                $project_url = $data['project_url'] ?? '';
                $github_url = $data['github_url'] ?? '';
                $result = $portfolio->addProject($data['title'], $data['description'], $data['tech_stack'], $image_path, $project_url, $github_url);
                echo json_encode($result
                    ? ["status" => "success", "message" => "Project added successfully"]
                    : ["status" => "error", "message" => "Failed to add project"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Invalid input"]);
            }
        } elseif ($method === 'PUT') {
            $data = getJsonBody();
            if (isset($data['id'], $data['title'], $data['description'], $data['tech_stack'])) {
                $image_path = $data['image_path'] ?? '';
                $project_url = $data['project_url'] ?? '';
                $github_url = $data['github_url'] ?? '';
                $result = $portfolio->updateProject($data['id'], $data['title'], $data['description'], $data['tech_stack'], $image_path, $project_url, $github_url);
                echo json_encode($result
                    ? ["status" => "success", "message" => "Project updated successfully"]
                    : ["status" => "error", "message" => "Failed to update project"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Invalid input"]);
            }
        } elseif ($method === 'DELETE') {
            if (isset($_GET['id'])) {
                $result = $portfolio->deleteProject($_GET['id']);
                echo json_encode($result
                    ? ["status" => "success", "message" => "Project deleted successfully"]
                    : ["status" => "error", "message" => "Failed to delete project"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Invalid ID"]);
            }
        }
        break;

    // ===================== MESSAGES (contact form) =====================
    case 'messages':
        if ($method === 'GET') {
            echo json_encode(["status" => "success", "messages" => $portfolio->getAllMessages()]);
        } elseif ($method === 'POST') {
            $data = getJsonBody();
            if (isset($data['name'], $data['email'], $data['message'])) {
                $result = $portfolio->addMessage($data['name'], $data['email'], $data['message']);
                echo json_encode($result
                    ? ["status" => "success", "message" => "Message sent successfully"]
                    : ["status" => "error", "message" => "Failed to send message"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Invalid input"]);
            }
        } elseif ($method === 'DELETE') {
            if (isset($_GET['id'])) {
                $result = $portfolio->deleteMessage($_GET['id']);
                echo json_encode($result
                    ? ["status" => "success", "message" => "Message deleted successfully"]
                    : ["status" => "error", "message" => "Failed to delete message"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Invalid ID"]);
            }
        }
        break;

    default:
        echo json_encode(["status" => "error", "message" => "Unknown resource. Use ?resource=profile|skills|experience|education|projects|messages"]);
        break;
}
