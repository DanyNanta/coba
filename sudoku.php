<?php
  class Sudoku{
    private $_GRID_SIZE = 9;

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