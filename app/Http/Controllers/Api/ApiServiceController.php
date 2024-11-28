<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ApiServiceController extends Controller
{

  public function postService(Request $request)
  {
    $rules = [
      'name' => [
        'required',                     // El campo es obligatorio
        'string',                       // Debe ser una cadena
        'max:255',                      // Máximo de 255 caracteres
        'unique:services,name',         // Debe ser único en la tabla 'services'
        'regex:/^[a-zA-Z0-9\s]+$/',     // Solo permite letras, números y espacios
      ],
      'description' => [
        'nullable',                     // Puede ser nulo
        'string',                       // Debe ser una cadena
        'max:1000',                     // Máximo de 1000 caracteres
      ],
      'amount' => [                    // Puede ser nulo
        'numeric',                      // Debe ser un número
        'regex:/^\d{1,20}(\.\d{1,2})?$/', // Regex para cantidad con máximo 20 dígitos enteros y 2 decimales
      ],
      'category' => [                     // Puede ser nulo
        'string',                       // Debe ser una cadena
        'max:100',                      // Máximo de 100 caracteres
      ],
      'is_active' => [
        'required',                     // Campo obligatorio
        'boolean',                      // Solo puede ser verdadero o falso
      ],
    ];

    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()):
      $data = [
        'title' => __('word.general.error'),
        'type' => 'error',
        'msg' => __('word.general.error_validation'),
        'msgs' => json_encode($validator->errors()->all())
      ];
      return $data;
    else:
      $service = new Service();
      $service->name = e($request->input('name'));
      $service->description = e($request->input('description'));
      $service->amount = e($request->input('amount'));
      $service->category = e($request->input('category'));
      $service->is_active = e($request->input('is_active'));
      if ($service->save()):
        $data = ['type' => 'success', 'title' => __('word.general.app'), 'msg' => __('word.service.v_success'), 'msgs' => json_encode($validator->errors()->all())];
        return $data;
      endif;
    endif;
    // return $request->all();
    // if($request->validated()): return;
    // else: return;
    // endif;
    // Login::create($request->validated());
    // return response()->json($data);
    //$validated = $request->validated();
    //Service::create($validated);
    //return redirect()->route('service.index')->with('success', 'Servicio creado correctamente.');
    //return back()->with('success', 'El registro se ha completado exitosamente.');
  }
}
