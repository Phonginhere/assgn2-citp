<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once __DIR__ . '/../../settings.php';
// if (isset($_GET['id'])) {
//     $skillId = $_GET['id'];
// }
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $idSkill = isset($_POST["idSkill"]) ? $_POST["idSkill"] : "";

    $skillsname = isset($_POST["skillsname"]) ? $_POST["skillsname"] : "";
    $currentFile = isset($_POST["currentFile"]) ? $_POST["currentFile"] : "";

    $resultSkill = skillValidation($skillsname);

    if (is_array($resultSkill)) {
        $resultSkill = null;
        //INSERT INTO `skill`(`skill_id`, `skillName`) VALUES ('[value-1]','[value-2]') using pdo
        if(str_contains($currentFile, "Adding")){
            $sql = "INSERT INTO skill (skillName) VALUES (:skillsname)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':skillsname', $skillsname);
            $stmt->execute();
        }else{
            try{
                // echo $skillsname;
                // echo $idSkill;
                $sql = "UPDATE skill SET skillName = :skillsname WHERE skill_id = :skill_id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':skillsname', $skillsname);
                $stmt->bindParam(':skill_id', $idSkill);
                $stmt->execute();
            }catch(PDOException $e){
                echo 'Error: ' . $e->getMessage();
            }
            
            
        }
        
        //location to 

        header("Location: ../manage_list_job.php");
    } else {
        $_SESSION['resultSkill'] = $resultSkill;
        header("Location: ../".$currentFile);
    }
}
function skillValidation($skillsname){
    $result = "";

    $max_length = 20;

    if (empty($skillsname)) {
        $result = "Please enter Skill Name.";
    } elseif (strlen($skillsname) > $max_length) {
        if (strlen($skillsname) > $max_length) {
            $result = "Skill Name should be no more than $max_length characters long.";
        }
    } else {
        $result = array($skillsname);
    }
    return $result;
}
?>