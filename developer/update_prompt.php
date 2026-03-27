<?php
require_once('../includes/auth.php');
confirm_logged_in();
require_once '../config/db.php';

$id = (int) $_GET['id']; // Get the prompt ID from the URL
$stmt = $pdo->prepare("SELECT * FROM prompts WHERE id = ?");
$stmt->execute([$id]);
$prompt = $stmt->fetch(); // fetch the prompt from database


if($prompt['user_id'] !== $_SESSION['user_id'] && $_SESSION['role'] !== 'admin') {
    //Is the user the owner of the prompt?  OR  Is the user an admin?
    header("Location: dashboard.php");
    exit();
}
$categories = $pdo->query("SELECT * FROM categories")->fetchAll(); // Fetch all categories for the dropdown
?>

<h2>Edit Prompt</h2>

<form action="../controllers/promptController.php" method="POST">

    <!-- Hidden ID -->
    <input type="hidden" name="id" value="<?php echo $prompt['id']; ?>">

    <!-- Title -->
    <label>Title</label>
    <input type="text" name="title" value="<?php echo $prompt['title']; ?>" required>

    <!-- Category -->
    <label>Category</label>
    <select name="category_id">
        <?php
        foreach ($categories as $c) {
            ?>
            <option value="<?php echo $c['id']; ?>">
                <?php echo $c['name']; ?>
            </option>
            <?php
        }
        ?>
    </select>

    <!-- Content -->
    <label>Content</label>
    <textarea name="content" rows="8" required><?php echo $prompt['content']; ?></textarea>

    <!-- Button -->
    <button type="submit" name="edit_prompt">Update</button>

</form>

<?php include '../includes/footer.php'; ?>


