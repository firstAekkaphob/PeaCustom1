<?php
session_start();

function display_seating_chart($seating) {
    ?>
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
    <?php
}
?>
