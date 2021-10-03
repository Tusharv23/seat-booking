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
        } else if ($tableProbab > $nToSeatRatio){
            for($i = 0; $i<$this->rows; $i++){
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
}
?>