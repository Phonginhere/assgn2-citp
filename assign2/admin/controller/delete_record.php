<?php
// Including authentication check
include './controller/authCheck.php';


// Database settings
include_once __DIR__ . '/../../settings.php';

//check if actionPage=skills then delete the record at skills table if got id on the database, if not redirect to error page
if (isset($_GET['actionPage']) && $_GET['actionPage'] == 'skills') {
    if (isset($_GET['id'])) {
        try {
            // Prepare the SQL statement.
            global $pdo;
            $stmt = $pdo->prepare("DELETE FROM skill WHERE skill_id = :skillId");
            $stmt->bindValue(':skillId', $_GET['id']);
            $stmt->execute();
            header("Location: ../manage_list_job.php");
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        header("Location: ../../error.php");
    }
}

?>