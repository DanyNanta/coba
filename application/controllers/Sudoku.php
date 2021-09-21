<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sudoku extends CI_Controller {

    public static $_GRID_SIZE = 9;
    public static $board_solve;

    public function __construct()
    {
        parent::__construct();
    }

	public function index()
	{
		$this->load->view('welcome_message');
	}
    
    private function isNumberInRow($board, $number, $row){
        for($i = 0; $i < Sudoku::$_GRID_SIZE; $i++) {
            if($board[$row][$i] == $number){
                return true;
            }
        }
        return false;
    }
    
    private function isNumberInColumn($board, $number, $column){
        for($i = 0; $i < Sudoku::$_GRID_SIZE; $i++) {
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
            for($j = $localBoxColumn; $j < $localBoxColumn + 3; $j++){
                if($board[$i][$j] == $number){
                    return true;
                }
            }
        }
        return false;
    }

    private function isValidPlacement($board, $number, $row, $column){
        return !Sudoku::isNumberInRow($board, $number, $row) && 
        !Sudoku::isNumberInColumn($board, $number, $column) && 
        !Sudoku::isNumberInBox($board, $number, $row ,$column);
    }

    private function solveBoard($board){
        for($row = 0; $row < Sudoku::$_GRID_SIZE; $row++){
            for($column = 0; $column < Sudoku::$_GRID_SIZE; $column++){
                if($board[$row][$column] == 0){
                    for($numberToTry = 1; $numberToTry <= Sudoku::$_GRID_SIZE; $numberToTry++){
                        if(Sudoku::isValidPlacement($board,$numberToTry,$row, $column)){
                            $board[$row][$column] = $numberToTry;

                            if($this->solveBoard($board)){
                                Sudoku::$board_solve[$row][$column] =$board[$row][$column];
                                return true;
                            }
                            else {
                                $board[$row][$column] = 0;
                            }
                        }
                    }
                    return false;
                }
            }
        }
        return true;
    }

    public function solve(){
        $post = $this->input->post();
        $board = json_decode($post['board']);
        $trying = $this->solveBoard($board);
        if($trying){
            Sudoku::newBoard($board);
        } else {
            echo "Unsolved";
        }        
    }

    public function newBoard($board){
        for($i = 0; $i <Sudoku::$_GRID_SIZE ; $i++){
            for($j=0; $j < Sudoku::$_GRID_SIZE ; $j++){
                if($board[$i][$j] == 0){
                    $board[$i][$j] = Sudoku::$board_solve[$i][$j];
                } 
            }
        }
        print_r($board) ;
    }
}