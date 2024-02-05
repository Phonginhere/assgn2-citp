<?php
include_once __DIR__ . '/settings.php';

global $pdo;
//Prepare the SQL statement
$sql = "select jd.jobDescId as jdId, jd.name as nJob, jd.refNum as refN, jd.posTitle as jpTitle, concat(jd.minSala, '$', ' - ', jd.maxSala, '$') as salary, jd.bonus as bonus, 
jd.noteBonus as noteB, concat(s.staffFname, ' ', s.staffLname) as fLname, jd.note as note, jd.keyResponse as keyRes, jd.briefJobDescription as bJobdesc 
from jobDesc as jd
left join staff as s
on jd.reportTo = s.staffId
where jd.status = 1";
//Execute the SQL statement
$stmt = $pdo->prepare($sql);
$stmt->execute();
//Retrieve the result of the SQL query
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get all skills
$sql = "SELECT * FROM `skill`";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$allSkills = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="uft-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    require('./fragment/seo.php');
    require('./fragment/library.php');
    ?>
</head>

<body>
    <!-- begin nav bar header-->
    <header>
        <?php
        require('./fragment/navbar.php');
        ?>
    </header>
    <!-- end nav bar header-->
    <br><br><br><br>
    <section class="H1">
        <h1 id="hh1">
            <?php
            //count the result retrieve, if more than one, display number, if not, display there is no
            if (count($results) > 0) {
                echo count($results);
            } else {
                echo "There is no";
            }
            ?>
            Jobs Avalible
        </h1>
    </section>

    <?php if (!empty($results)): ?>
        <?php foreach ($results as $result): ?>
            <hr>
            <section>
                <h2><b>
                        <?= $result['nJob'] ?>
                    </b></h2>
                <table>
                    <tr>
                        <th>Catagory</th>
                        <th>Info</th>
                    </tr>
                    <tr>
                        <td>Reference num.</td>
                        <td>
                            <?= $result['refN'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Position title</td>
                        <td>
                            <?= $result['jpTitle'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Salary Range</td>
                        <td>
                            <?= $result['salary'] ?>
                            <?php if (strtolower($result['bonus']) === "yes"): ?>
                                +
                                <?= $result['bonus'] ?>
                            <?php endif; ?>
                            <?php if (!empty($result['noteB'])): ?>
                                <aside>
                                    <?= $result['noteB'] ?>
                                </aside>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>The person to report to</td>
                        <td> Leader of the team:
                            <?= $result['fLname'] ?>.
                            <aside>
                                <?php if (strtolower($result['note']) === "yes"): ?>
                                    This infomation will be sent to you after you get assinged.
                                    <br>
                                    If you have any question please refer to our support number and email.
                                <?php endif; ?>
                            </aside>
                        </td>
                    </tr>
                    <tr>
                        <td>Key responsibilities</td>
                        <td>
                            <?= $result['keyRes'] ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Minimum requirment</td>
                        <td>
                            <ul>
                                <?php foreach ($allSkills as $skill): ?>
                                    <?php
                                    $stmtAssociatedSkills = $pdo->prepare("SELECT skill_id FROM jobDesc_skill WHERE jobDescId = :jobDescId");
                                    $stmtAssociatedSkills->bindParam(':jobDescId', $result['jdId'], PDO::PARAM_INT);
                                    $stmtAssociatedSkills->execute();

                                    $associatedSkillIds = $stmtAssociatedSkills->fetchAll(PDO::FETCH_COLUMN);
                                    ?>
                                    <li>
                                        <?= in_array($skill['skill_id'], $associatedSkillIds) ? htmlspecialchars($skill['skillName']) : '' ?>
                                    </li>
                                    <!-- <li>HTML/CSS skills</li>
                                <li>Analytical skills</li>
                                <li>Responsive design skills</li>
                                <li>JavaScript skills</li>
                                <li>Interpersonal skills</li>
                                <li>Testing and debugging skills</li>
                                <li>Search engine optimization</li> -->
                                <?php endforeach; ?>
                            </ul>
                        </td>
                    </tr>
                    <tr>
                        <td>Job Description</td>
                        <td>
                            <?php $string = $result['bJobdesc'];
                            // Check and add a newline after the word
                            echo $string;
                            ?>
                        </td>
                    </tr>
                </table>
                <br>
                <a href="./apply.php?jobref=<?= $result['refN'] ?>" class="button">APPLY!!!!</a>
            </section>
            <br>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No records found</p>
    <?php endif; ?>

    <footer>
        <?php
        require('./fragment/footer.php');
        ?>
    </footer>
</body>

</html>