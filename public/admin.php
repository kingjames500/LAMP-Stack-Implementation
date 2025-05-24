<?php
require "../classes/traits/ApiResponse.php";
require_once "../classes/database/connection-class.php";
require_once "../classes/admin/admin-class.php";
require_once "../classes/admin/admin-view.class.php";
require_once "../classes/admin/admin-contr.class.php";

$alertType = "";
$message = "";

// Handle POST request
 if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $displayName = trim($_POST["displayName"]);
    
    try {
        $judge = new AdminContr($username, $displayName);
        $result = $judge->newJudge();
        
        if ($result['status'] === 'success') {
            $message = $result['message'];
            $alertType = "success";
        } else {
            $message = $result['message'];
            $alertType = "danger";
        }
    } catch (\Throwable $e) {
        $message = "Error: " . $e->getMessage();
        $alertType = "danger";
    }
}



$viewJudges = new AdminView();
$response = $viewJudges->getAllJudges(); 
$allJudges = $response['data'] ?? [];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin - Judge Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-5">
        <h1 class="mb-4">Admin Panel - Judge Management</h1>

        <?php if (!empty($message)) : ?>
        <div class="alert alert-<?= $alertType ?> alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($message) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>

        <div class="card mb-4">
            <div class="card-header bg-primary text-white">Add New Judge</div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username (unique)</label>
                        <input type="text" class="form-control" name="username" id="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="displayName" class="form-label">Display Name</label>
                        <input type="text" class="form-control" name="displayName" id="displayName" required>
                    </div>
                    <button type="submit" class="btn btn-success">Add Judge</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-secondary text-white">All Judges</div>
            <div class="card-body p-0">
                <?php if (!empty($allJudges)): ?>
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>Display Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $counter = 1; ?>
                        <?php foreach ($allJudges as  $j): ?>
                        <tr>
                            <td><?= $counter++ ?></td>
                            <td><?= htmlspecialchars($j['username']) ?></td>
                            <td><?= htmlspecialchars($j['display_name']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <?php else: ?>
                <div class="p-3">No judges found.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>