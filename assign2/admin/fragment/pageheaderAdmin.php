<?php
function formatText($text)
{
    // Remove leading and trailing spaces
    $text = trim($text);

    // Replace hyphens or underscores, with camelCase/PascalCase with spaces if they are present
    $text = preg_replace('/[-_]|([a-z])([A-Z])/', '$1 $2', $text);

    // Capitalize the first letter of each word
    $text = ucwords($text);

    return $text;
}
$formattedText = formatText($filename_without_ext);

?>
<div class="page-header">
    <h1>
        <?php
        $name_file = basename($_SERVER['PHP_SELF']);
        if ($name_file == "manage_list_job.php" || $name_file == "settingsAdmin.php" || $name_file == "profile.php" || $name_file == "staffManager.php" || $name_file == "manage.php") {
            $dash_or_withoutDash = $action_page . " " . $formattedText;
        } else {
            $dash_or_withoutDash = $action_page . " - " . $formattedText;
        }
        echo $dash_or_withoutDash;
        ?>
    </h1>
    <small>Home /
        <?php echo $dash_or_withoutDash; ?>
    </small>
</div>