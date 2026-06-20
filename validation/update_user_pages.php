<?php
include '../core/init.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'];
    $selectedPages = isset($_POST['pages']) ? $_POST['pages'] : [];

    // Begin transaction
    $pdo->beginTransaction();

    try {
        // Delete existing pages for the user
        $stmt = $pdo->prepare("DELETE FROM user_pages WHERE user_id = :userId");
        $stmt->execute(['userId' => $userId]);

        // Prepare statement to fetch parent page
        $fetchParentStmt = $pdo->prepare("SELECT sub_menu FROM pages WHERE id = :pageId");

        // Prepare statement to insert pages
        $insertPageStmt = $pdo->prepare("INSERT INTO user_pages (user_id, page_id) VALUES (:userId, :pageId)");

        // Track already assigned pages to avoid duplicate inserts
        $assignedPages = [];

        foreach ($selectedPages as $pageId) {
            // Assign the selected page
            if (!in_array($pageId, $assignedPages)) {
                $insertPageStmt->execute(['userId' => $userId, 'pageId' => $pageId]);
                $assignedPages[] = $pageId;
            }

            // Fetch the parent of the current page
            $fetchParentStmt->execute(['pageId' => $pageId]);
            $parentId = $fetchParentStmt->fetchColumn();

            // If the page has a parent and it's not assigned yet, assign the parent
            if ($parentId && !in_array($parentId, $assignedPages)) {
                $insertPageStmt->execute(['userId' => $userId, 'pageId' => $parentId]);
                $assignedPages[] = $parentId;
            }
        }

        // Commit transaction
        $pdo->commit();
        $_SESSION['status'] = "Pages Successfully Assigned";
        $_SESSION['code'] = "success";
        echo '<script>window.location.href="../staffs"</script>';

    } catch (Exception $e) {
        // Rollback on error
        $pdo->rollBack();
        $_SESSION['status'] = $e->getMessage();
        $_SESSION['code'] = "danger";
        echo '<script>window.location.href="../staffs"</script>';
    }
}

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $userId = $_POST['user_id'];
//     $selectedPages = isset($_POST['pages']) ? $_POST['pages'] : [];

//     // Begin transaction
//     $pdo->beginTransaction();

//     try {
//         // Delete existing pages for the user
//         $stmt = $pdo->prepare("DELETE FROM user_pages WHERE user_id = :userId");
//         $stmt->execute(['userId' => $userId]);

//         // Insert new pages for the user
//         $stmt = $pdo->prepare("INSERT INTO user_pages (user_id, page_id) VALUES (:userId, :pageId)");
//         foreach ($selectedPages as $pageId) {
//             $stmt->execute(['userId' => $userId, 'pageId' => $pageId]);
//         }

//         // Commit transaction
//         $pdo->commit();
//         $_SESSION['status'] = "Pages Successfully Assigned";
//         $_SESSION['code'] = "success";
//         echo '<script>window.location.href="../staffs"</script>';

//     } catch (Exception $e) {
//         $pdo->rollBack();
//         $_SESSION['status'] = $e->getMessage();
//         $_SESSION['code'] = "danger";
//         echo '<script>window.location.href="../staffs"</script>';
//     }
// }
