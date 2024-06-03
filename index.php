<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Theater Seat Booking</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-4 text-center">Movie Theater Seat Booking</h1>
        <?php
        include 'Cinema.php';

        session_start();
        if (!isset($_SESSION['cinema'])) {
            $_SESSION['cinema'] = new Cinema(10, 20); // 10 rows and 20 seats per row
        }

        $cinema = $_SESSION['cinema'];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $action = $_POST['action'];
            $seat_number = (int)$_POST['seat_number'];
            $name = $_POST['name'] ?? '';

            if ($action == 'book') {
                $cinema->book_seat($seat_number, $name);
            } elseif ($action == 'cancel') {
                $cinema->cancel_booking($seat_number);
            } elseif ($action == 'purchase') {
                $cinema->purchase_seat($seat_number, $name);
            }

            $_SESSION['cinema'] = $cinema;
        }

        $seating = $cinema->display_seats();
        ?>

        <form method="POST" action="" class="my-4">
            <div class="form-row align-items-end">
                <div class="form-group col-md-3">
                    <label for="seat_number">Seat Number</label>
                    <input type="number" class="form-control" id="seat_number" name="seat_number" min="1" max="200" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group col-md-5">
                    <button type="submit" name="action" value="book" class="btn btn-primary">Book Seat</button>
                    <button type="submit" name="action" value="cancel" class="btn btn-danger">Cancel Booking</button>
                    <button type="submit" name="action" value="purchase" class="btn btn-warning">Purchase Seat</button>
                </div>
            </div>
        </form>

        <div class="seating-chart mt-4">
            <table class="table table-bordered text-center">
                <?php 
                $seat_number = 1;
                for ($i = 0; $i < 10; $i++): // 10 rows
                    ?>
                    <tr>
                        <?php for ($j = 0; $j < 20; $j++): // 20 seats per row
                            $status = isset($seating[$i][$j]) ? $seating[$i][$j] : 'O';
                            $class = 'bg-success';
                            if (strpos($status, 'B:') === 0) {
                                $class = 'bg-danger';
                            } elseif (strpos($status, 'S:') === 0) {
                                $class = 'bg-warning';
                            }
                            ?>
                            <td class="<?php echo $class; ?>">
                                <?php echo $seat_number; ?>
                            </td>
                            <?php $seat_number++; ?>
                        <?php endfor; ?>
                    </tr>
                <?php endfor; ?>
            </table>
        </div>
    </div>
</body>
</html>