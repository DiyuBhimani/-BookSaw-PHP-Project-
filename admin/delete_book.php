<?php

include("connected.php");

// Check book id
if (!isset($_GET['b_id']) || empty($_GET['b_id'])) {

    echo "<script>
    alert('⚠️ Invalid Book ID');
    window.location.href='books.php';
    </script>";
    exit;
}

$b_id = intval($_GET['b_id']);

// Get image name before deleting
$select = "SELECT image FROM book WHERE b_id = ?";
$stmt = mysqli_prepare($conn, $select);
mysqli_stmt_bind_param($stmt, "i", $b_id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$book = mysqli_fetch_assoc($result);

if (!$book) {
    echo "<script>
    alert('⚠️ Book not found');
    window.location.href='books.php';
    </script>";
    exit;
}

// Delete book
$delete_query = "DELETE FROM book WHERE b_id = ?";
$delete_stmt = mysqli_prepare($conn, $delete_query);
mysqli_stmt_bind_param($delete_stmt, "i", $b_id);

if (mysqli_stmt_execute($delete_stmt)) {

    // Delete image file
    $image_path = "uploads/" . $book['image']; // Change folder if needed

    if (!empty($book['image']) && file_exists($image_path)) {
        unlink($image_path);
    }

    echo "<script>
    alert('✅ Book deleted successfully');
    window.location.href='books.php';
    </script>";

} else {

    echo "<script>
    alert('❌ Book delete failed: " . mysqli_error($conn) . "');
    window.location.href='books.php';
    </script>";

}

mysqli_close($conn);

?>
