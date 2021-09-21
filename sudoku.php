<?php
  class Sudoku{
    private $_GRID_SIZE = 9;
    public $board = array(
        array(0,3,0,0,0,0,8,0,0),
        array(0,0,6,3,0,0,0,4,2),
        array(2,0,8,6,7,0,3,0,5),
        array(8,5,0,0,1,0,6,2,0),
        array(0,0,7,0,0,0,9,0,0),
        array(0,4,9,0,5,0,0,1,8),
        array(9,0,5,0,4,7,2,0,6),
        array(3,7,0.0,0,6,4,0,0),
        array(0,0,1,0,0,0,0,7,0)
    );

    public function __construct(){

    }

    private function printBoard($board){
        for($row = 0; $row < $_GRID_SIZE; $row++){
            for($column = 0; $column < $_GRID_SIZE; $column++){
                print($board[$row][$column]);
            }
            print_r();
        }
    }
    
    private function isNumberInRow($board, $number, $row){
        for($i = 0; $i < $_GRID_SIZE; $i++) {
            if($board[$row][$i] == $number){
                return true;
            }
        }
        return false;
    }
    
    private function isNumberInColumn($board, $number, $column){
        for($i = 0; $i < $_GRID_SIZE; $i++) {
            if($board[$i][$column] == $number){
                return true;
            }
        }
        return false;
    }

    private function isNumberInBox($board, $number, $row, $column){
        $localBoxRow = $row - $row % 3;
        $localBoxColumn = $column - $column % 3;

        for($i = $localBoxRow; $i < $localBoxRow + 3; $i++) {
            for($j = $localBoxColumn; j < $localBoxColumn + 3; $j++){
                if($board[$i][$j] == $number){
                    return true;
                }
            }
        }
        return false;
    }

    private function isValidPlacement($board, $number, $row, $column){
        return !isNumberInRow($board, $number, $row) && 
        !isNumberInColumn($board, $number, $column) && 
        !isNumberInBox($board, $number, $row ,$column);
    }

    private function solveBoard($board){
        for($row = 0; $row < $_GRID_SIZE; $row++){
            for($column = 0; $column < $_GRID_SIZE; $column++){
                if($board[$row][$column] == 0){
                    for($numberToTry = 1; $numberToTry < $_GRID_SIZE; $numberToTry++){
                        if(isValidPlacement($board,$numberToTry,$row, $column)){
                            $board[$row][$column] = $numberToTry;

                            if(solveBoard($board)){
                                return true;
                            }
                            else {
                                $board[$row][$column] = 0;
                            }
                        }
                    }
                }
            }
        }
    }
  }
  
?>