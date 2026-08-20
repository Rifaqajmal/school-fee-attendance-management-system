<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/04. eaglets_school/config/db.php';
requireLogin();

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name        = trim($_POST['name']);
    $monthly_fee = floatval($_POST['monthly_fee']);

    if (empty($name) || $monthly_fee <= 0) {
        $error = "Class name and monthly fee are required.";
    } else {
        $stmt = mysqli_prepare($conn,
            "INSERT INTO classes (name, monthly_fee) VALUES (?,?)"
        );
        mysqli_stmt_bind_param($stmt, "sd", $name, $monthly_fee);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: index.php?msg=added"); exit();
        } else {
            $error = "This class already exists.";
        }
    }
}

$pageTitle = "Add Class";
require_once '../includes/header.php';
?>

<div class="card border-0 shadow-sm" style="max-width:450px">
    <div class="card-header bg-white fw-bold">Add New Class</div>
    <div class="card-body">
        <?php if ($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Class Name *</label>
                <input type="text" name="name" class="form-control"
                       placeholder="e.g. Class 1" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Monthly Fee (Rs.) *</label>
                <input type="number" name="monthly_fee" class="form-control"
                       placeholder="1500" required>
            </div>
            <button type="submit" class="btn btn-success">Save Class</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
<?php require_once '../includes/footer.php'; ?>
