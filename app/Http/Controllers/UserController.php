<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\GoogleSheet;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        $users = User::get();
        return view("user.index", compact("users"));
    }

    public function create() {
        return view("user.create");
    }

    public function edit($id) {
        $user = User::find($id);
        return view("user.edit", compact("user"));
    }

    public function store(Request $request, GoogleSheet $googleSheet) {
        $data = [
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'ip' => $_SERVER['HTTP_USER_AGENT'],
            'link' => $_SERVER['REQUEST_URI'],
            'comments' => $request['comments'],
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $user = User::create($data);

        $id = $user->id;
        $user_for_sheet = User::find($id);
        $values = [
            [
                $user_for_sheet['id'],
                $user_for_sheet['first_name'],
                $user_for_sheet['last_name'],
                $user_for_sheet['email'],
                $user_for_sheet['phone'],
                $user_for_sheet['ip'],
                $user_for_sheet['link'],
                $user_for_sheet['comments'],
                $user_for_sheet['created_at'],
                $user_for_sheet['updated_at']

            ]
        ];

        $savedData = $googleSheet->saveDataToSheet($values);

        if($savedData) {
            return redirect()->back()->with("success", "Row successfully created");
        }
    }

    public function update(Request $request, GoogleSheet $googleSheet) {
        $user = User::find($request['id']);
        $data = [
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'comments' => $request['comments'],
            'updated_at' => now(),
        ];
        $user->update($data);
        $values = [
            [
                $user['id'],
                $user['first_name'],
                $user['last_name'],
                $user['email'],
                $user['phone'],
                $user['ip'],
                $user['link'],
                $user['comments'],
                $user['created_at'],
                $user['updated_at']

            ]
        ];

        $data = $googleSheet->readGoogleSheet();
        $row = [];
        for($i = 1; $i < count($data);$i++) {
            if($data[$i][0] == $user['id']) {
                $row = $data[$i];
                break;
            }
        }

        $savedData = $googleSheet->saveDataToSheet($values);
    }
}
