<?php

namespace App\Imports;

use App\Test;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class UsersImport implements ToModel
{
    protected $test;
    public function __construct($test) {
        $this->test = $test;

    }
    // public function test($test) 
    // {
    //     $this->test = $test;
    // }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // dd($this->test);
        $this->createTest($row);

        // return new User([
            //
        // ]);
    }

    public function createTest ($row)
    {
        // dd($row);
        // $test = new Test;
        // $test->id = $row[0];
        // $test->name = $row[1];
        // $test->save();

        $test = Test::create([
            'id' => $row[0],
            'name' => $row[1],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        // can thiệp vào id

        $test->code = 1000 + $test->id;
        $test->save();
        
        // $old_test = Test::find($test->id);
        // $old_test->code = 1000 + $test->id;
        // $old_test->save();

        // DB::table('tests')->insert([
        //     'id' => $row[0],
        //     'name' => $row[1],
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);
    }

    public function createStudent ($row) 
    {
        $user = new User();
        $user->name = $row[1];
        $user->email = $row[2];
        $user->code = $row[3];
        $user->password = Hash::make($row[3]);
        $user->role_id = 4;
        $user->gender = $row[4];
        $user->address = $row[5];
        $user->date_of_birth = $row[6];
        $user->phone = $row[7];
        $user->is_active = 1;
        $user->save();
        $user->identity_code = 1000 + $user->id*1;
        $user->save();
    }
}
