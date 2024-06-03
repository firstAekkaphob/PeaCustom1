<?php
class Cinema {
    private $rows;
    private $seats_per_row;
    private $seating;

    public function __construct($rows, $seats_per_row) {
        $this->rows = $rows;
        $this->seats_per_row = $seats_per_row;
        $this->seating = array_fill(0, $rows, array_fill(0, $seats_per_row, 'O'));
    }

    public function display_seats() {
        return $this->seating;
    }

    public function book_seat($seat_number, $name) {
        list($row, $seat) = $this->get_row_seat($seat_number);
        if ($this->is_valid_seat($row, $seat)) {
            if ($this->seating[$row-1][$seat-1] == 'O') {
                $this->seating[$row-1][$seat-1] = 'B:'.$name;
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    public function cancel_booking($seat_number) {
        list($row, $seat) = $this->get_row_seat($seat_number);
        if ($this->is_valid_seat($row, $seat)) {
            if (strpos($this->seating[$row-1][$seat-1], 'B:') === 0 || strpos($this->seating[$row-1][$seat-1], 'S:') === 0) {
                $this->seating[$row-1][$seat-1] = 'O';
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    public function purchase_seat($seat_number, $name) {
        list($row, $seat) = $this->get_row_seat($seat_number);
        if ($this->is_valid_seat($row, $seat)) {
            if ($this->seating[$row-1][$seat-1] == 'O' || $this->seating[$row-1][$seat-1] == 'B:'.$name) {
                $this->seating[$row-1][$seat-1] = 'S:'.$name;
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    private function is_valid_seat($row, $seat) {
        return $row > 0 && $row <= $this->rows && $seat > 0 && $seat <= $this->seats_per_row;
    }

    private function get_row_seat($seat_number) {
        $row = ceil($seat_number / $this->seats_per_row);
        $seat = $seat_number % $this->seats_per_row;
        if ($seat == 0) {
            $seat = $this->seats_per_row;
        }
        return [$row, $seat];
    }
}
?>