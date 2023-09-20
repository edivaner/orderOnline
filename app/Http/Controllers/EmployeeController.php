<?php

namespace App\Http\Controllers;

use App\Models\Affiliate;
use App\Models\Employee;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    //

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user' => 'required',
            'affiliate_id' => 'required'
        ]);

        try {
            DB::beginTransaction();


            $user = User::create([
                'name'      => $validated['user']['name'],
                'email'     => $validated['user']['email'],
                'password'  => $validated['user']['password'],
            ]);

            $employee = Employee::create([
                'user_id'      => $user->id,
                'affiliate_id' => $validated['affiliate_id'],
            ]);

            DB::commit();

            return response()->json(['message' => 'Funcionário cadastrado com sucesso', 'customer' => $employee, 'user' => $user], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Erro ao cadastrar o funcionário', 'error' => $e->getMessage()], 500);
        }
    }
}
