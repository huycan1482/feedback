<?php

namespace App\Http\Controllers;

use App\Imports\UsersImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function importTest (Request $request) 
    {
        $import = new UsersImport('hihi');
        Excel::import($import, request()->file('import_file'));
    }
}
