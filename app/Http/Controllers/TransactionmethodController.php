<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transactionmethod;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class TransactionmethodController extends Controller
{
    public function index(Request $request)
    {
      $perPage = $request->input('perPage', 10);
      $transactionmethods = Transactionmethod::orderBy('created_at', 'desc')->paginate($perPage);
      return view("transactionmethod.index", compact('transactionmethods', 'perPage'));
    }
    public function create()
    {
      $transactionmethod = new Transactionmethod();
      return view("transactionmethod.create", compact('transactionmethod'));
    }
    public function store(Request $request)
    {
      $rules = [
        'name' => [
          'required',
          'unique:transactionmethods,name',
          'string',
          'max:30',
          'regex:/^[a-zA-Z0-9\s]+$/',
        ],
        'description' => [
          'nullable',
          'string',
          'max:100',
        ]
      ];
      $validator = Validator::make($request->all(), $rules);
      if ($validator->fails()) {
        return redirect()->back()
          ->withErrors($validator)
          ->withInput();
      }
      Transactionmethod::create([
        'name' => $request->name,
        'description' => $request->description
      ]);
      return redirect("/transactionmethods")->with('success', 'Método de transacción registrado correctamente.');
    }
    public function edit(string $transactionmethod_uuid)
    {
        $transactionmethod = Transactionmethod::where('transactionmethod_uuid', $transactionmethod_uuid)->firstOrFail();
        return view("transactionmethod.edit", compact('transactionmethod'));
    }

    public function update(Request $request, string $transactionmethod_uuid)
    {
        $transactionmethod = Transactionmethod::where('transactionmethod_uuid', $transactionmethod_uuid)->firstOrFail();
      $rules = [
        'name' => [
          'required',
          'string',
          'max:30',
          'regex:/^[a-zA-Z0-9\s]+$/',
          'unique:transactionmethods,name,' . $transactionmethod->transactionmethod_uuid . ',transactionmethod_uuid',
        ],
        'description' => [
          'nullable',
          'string',
          'max:100',
        ],
        'status' => [
          'required',
          'integer',
        ],
      ];
      $validator = Validator::make($request->all(), $rules);
      if ($validator->fails()) {
        return redirect()->back()
          ->withErrors($validator)
          ->withInput();
      }
      $transactionmethod->update([
        'name' => $request->name,
        'description' => $request->description,
        'status' => $request->status,
      ]);
      return redirect("/transactionmethods")->with('success', 'Método de transacción actualizado correctamente.');
    }
    public function destroy(string $transactionmethod_uuid)
    {
        $transactionmethod = Transactionmethod::where('transactionmethod_uuid', $transactionmethod_uuid)->firstOrFail();
        $transactionmethod->delete();
        return redirect("/transactionmethods")->with('success', 'Método de transacción eliminado correctamente.');
    }
}
