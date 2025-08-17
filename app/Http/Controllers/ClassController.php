<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StructureManager;

class ClassController extends Controller
{

    public function index()
    {

        return view('school_structure.classes.index');
    }
}
