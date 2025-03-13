<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class MainController extends Controller
{
    public function home(): View
    {
        return view('home');
    }
    public function generateExercises(Request $request)
    {
        // form validation
        $request->validate([
            'check_sum' => 'required_without_all:check_subtraction,check_multiplication,check_division',
            'check_subtraction' => 'required_without_all:check_sum,check_multiplication,check_division',
            'check_multiplication' => 'required_without_all:check_sum,check_subtraction,check_division',
            'check_division' => 'required_without_all:check_sum,check_subtraction,check_multiplication',

            'number_one' => 'required|integer|min:0|max:999|lt:number_two',
            'number_two' => 'required|integer|min:0|max:999',
            'number_exercises' => 'required|integer|min:5|max:50',
        ]);

        // get select operations
        $operations = [];
        $operations[] = $request->check_sum ? 'sum'  : '';
        $operations[] = $request->check_subtraction ? 'subtraction'  : '';
        $operations[] = $request->check_multiplication ? 'mutiplication'  : '';
        $operations[] = $request->check_division ? 'division'  : '';

        //get numbers (min and max)
        $min = $request->number_one;
        $max = $request->number_two;

        // get number of exercises
        $numberExercises = $request->number_exercises;

        // generate exercises
        $exercises = [];
        for($index = 1; $index <= $numberExercises; $index++){
            $operation = $operations[\array_rand($operations)];
            $number1 = \rand($min, $max);
            $number2 = \rand($max, $max);

            $exercise = '';
            $sollution = '';

            switch ($operation) {
                case 'sum':
                    $exercise = "$number1 + $number2 =";
                    $sollution = $number1 + $number2;
                    break;
                case 'subtraction':
                    $exercise = "$number1 - $number2 =";
                    $sollution = $number1 - $number2;
                    break;
                case 'mutiplication':
                    $exercise = "$number1 * $number2 =";
                    $sollution = $number1 * $number2;
                    break;
                case 'division':
                    $exercise = "$number1 / $number2 =";
                    $sollution = $number1 / $number2;
                    break;
            }

            $exercises[] = [
                'exercise_number' => $index,
                'exercise' => $exercise,
                'sollution' => "$exercise $sollution"
            ];

        }

        \dd($exercises);
    }


    public function printExercises()
    {
        echo 'imprimir exercicios no navegador';
    }

    public function exportExercises()
    {
        echo 'exportar exercicios para um arquivo de texto';
    }
}
