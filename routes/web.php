<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $count_a = 0;
    $count_b = 0;

    for($i = 1; $i < 10000; $i++)
    {
        $user_id = str_random(6);

        $segment =  \App\Sdk\facade\Abtest::getSegment('test_a', $user_id);

        if($segment === 'A'){
            $count_a++;
        }
        if($segment === 'B'){
            $count_b++;
        }
    }
    echo "Total A: {$count_a} <br>";
    echo "Total B: {$count_b}";

});

Route::get('deterministic', function(){
    $user_id = str_random(6);
    $segment = '';
    $changes = -1;
    for($i = 1; $i < 10000; $i++) {
        $s = \App\Sdk\facade\Abtest::getSegment('test_a', $user_id);
        if($s !== $segment){
            $changes++;
            $segment = $s;
            echo $segment;
        }
    }
    dd($changes);
});
