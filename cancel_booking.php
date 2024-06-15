<?php
include('db.php');

if (isset($_GET['bookingId'])) {
    $bookingId = $_GET['bookingId'];

    // Check if the user confirmed the cancellation
    if (isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
        // Delete booking from database
        $query = "DELETE FROM bookings WHERE id = '$bookingId'";
        if (mysqli_query($conn, $query)) {
            echo "Booking cancelled successfully!";
            header("Refresh:2; url=booking.php"); // Redirect after 2 seconds
        } else {
            echo "Error cancelling booking: " . mysqli_error($conn);
        }
    } else {
        // Prompt user for confirmation
        echo '<script>
                var confirmDelete = confirm("Are you sure you want to cancel this booking?");
                if (confirmDelete) {
                    window.location.href = "cancel_booking.php?bookingId='.$bookingId.'&confirm=yes";
                }
            </script>';
    }
} else {
    echo "No booking ID provided.";
}
?>


