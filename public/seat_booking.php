<?php
class bookSeats{
    public $aux_seats = 0;
    public $rows = 0;
    public $columns = 0;
    public $seats = null;
    function allocate_seats($n){
        $min = 1;
        $nToSeatRatio = $n/$this->columns;
        $selectedRow = null;
        $tableProbab = 0;
        for($i=0;$i<$this->rows;$i++){
            $probabilityOfRow = array_sum($this->seats[$i]);
            $tableProbab = $tableProbab + $probabilityOfRow;
            if($probabilityOfRow >= $nToSeatRatio){
                if($min>=$probabilityOfRow){
                    $min = $probabilityOfRow;
                    $selectedRow = $i;
                }
            } else {
                continue;
            }
        }
        if($selectedRow !== null){
            for($j=0;$j<$this->columns;$j++){
                if($this->seats[$selectedRow][$j]!=0 && $n){
                    $booked_seats[] = [
                        'reserved_row'=>$selectedRow,
                        'reserved_column'=>$j
                    ];
                    $this->seats[$selectedRow][$j] = 0;
                    $n--;
                }
            }
        } else if ($tableProbab >= $nToSeatRatio){
            for($i = 0; $i<$this->rows; $i++){
                $probabs[] = array_sum($this->seats[$i]);
            }
            arsort($probabs);

            // for($i = 0; $i<$this->rows; $i++){
            foreach($probabs as $i=>$value){
                for($j=0; $j<$this->columns; $j++){
                   if($n==0)
                       break;
                    if($this->seats[$i][$j] != 0){
                        $booked_seats[] = [
                            'reserved_row'=>$i,
                            'reserved_column'=>$j
                        ];
                        $this->seats[$i][$j] = 0;
                        $n--;
                    }
                }
                 if($n==0)
                       break;
            }
        } else {
            $bookedSeats = null;
        }
        return $booked_seats;
    }
    
    function create_map($rowSize,$total,$seatMap){
            $this->columns = $rowSize;
            $this->rows = round($total/$rowSize);
            $this->aux_seats = $total%$rowSize;
            $this->seats = [$this->rows-1][$this->columns-1];
            if($this->aux_seats){
                $this->rows = $this->rows + 1;
            }
            for($i = 0; $i<$this->rows; $i++){
                for($j=0; $j<$this->columns; $j++){
                   if(($i == $this->rows - 1 && $j >= $this->aux_seats) || 
                   in_array($i."-".$j,$seatMap)){
                       $this->seats[$i][$j] = 0;
                   } else {
                       $this->seats[$i][$j] = 1/$rowSize;
                   }
                }
            }
    }
    function render_coach($bookedSeats)
    {
        echo"<html>
        <head>
        <style>
        table
        {
        border-style:solid;
        border-width:2px;
        border-color:pink;
        }
        </style>
        </head>
        <body bgcolor='#f4f4f4'>";
        echo "<div style='top:20%;left:44%; position: relative;'> ";
        if(count($bookedSeats)>0){
            echo "Booked Seats are:";
        } else {
            echo "No Seat Available";
        }
        echo"<div>";
        foreach($bookedSeats as $seat){
           echo $seat.',';
        }
        echo "</div>";
        echo "<table border='1' style='margin-top:20px;'";
       
        echo"
        <tr>
        <td></td> 
        <td>0</td>
        <td>1</th>
        <td>2</td>
        <td>3</td>
        <td>4</td>
        <td>5</td>
        <td>6</td>
        </tr>";

        for($i = 0; $i<$this->rows; $i++){
            echo "<tr>";
            echo '<td>'.$i.'</td>';
            for($j=0; $j<$this->columns; $j++){
                if($i == $this->rows - 1 && $j >= $this->aux_seats)
                {
                    continue;
                } else if($this->seats[$i][$j] != 0){
                 echo '<td><div style="height: 2vh;width: 20px; background-color:#008000">
                 </div></td>';
                } else if(in_array($i.'-'.$j,$bookedSeats)){
                    echo '<td><div style="height: 2vh;width: 20px; background-color:#0000ff">
                    </div></td>';
                } else {
                    echo '<td><div style="height: 2vh;width: 20px; background-color:#ff0000">
                    </div></td>';
                }
            }
            echo "</tr>";
        }
        echo "</div>";
        echo"</body></html>";
    }  
}
?>