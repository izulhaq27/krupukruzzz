<?php
// app\Http\Controllers\TestController.php
namespace App\Http\Controllers;

class TestController  // HAPUS "extends Controller" sementara
{
    public function index()
    {
        // RETURN STRING SANGAT SEDERHANA
        return "TEST 123 - PLAIN TEXT";
    }
}