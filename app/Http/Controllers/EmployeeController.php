<?php

namespace App\Http\Controllers;

use App\DTO\employee\CreateEmployeeDTO;
use App\DTO\employee\UpdateEmployeeDTO;
use App\Models\Affiliate;
use App\Models\Employee;
use App\Models\User;
use App\Services\EmployeeService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    //
    public function __construct(
        protected EmployeeService $employeeService
    ) {
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $request = (object) $request->toArray();

            $employee = $this->employeeService->store(CreateEmployeeDTO::makeFromRequest($request));

            DB::commit();

            return response()->json(['message' => 'Funcionário cadastrado com sucesso', 'customer' => $employee], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Erro ao cadastrar o funcionário', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $temEmployee = $this->employeeService->findOne($id);
            if (!$temEmployee) return response()->json(['message' => 'Erro ao tentar encontrar funcionário para atualizar']);

            $employee = $this->employeeService->update(UpdateEmployeeDTO::makeFromRequest($request, $id));

            return response()->json(['message' => 'Funcionário atualizado com sucesso', 'employee' => $employee]);
        } catch (Exception $e) {
            return response()->json(['message' => 'Erro ao atualizar o funcionário', 'error' => $e->getMessage()], 500);
        }
    }
}
