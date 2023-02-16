<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class products extends Controller
{
    //
    function productlist(){
        return"product listing";
    }

    function addProduct(){
        return "product added";
    }
    
    function updateProduct(){
        return "product updated";
    }

}
