<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Income;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $services = Service::with('user')->orderBy('created_at', 'desc')->paginate($perPage);
        return view("service.index", compact('services', 'perPage'));
    }

    public function create()
    {
        $service = new Service();
        $categories = Category::where("status", '1')->get();
        return view("service.create", compact('service', 'categories'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:services,name|string|max:70',
            'description' => 'nullable|string|max:110',
            'amount' => 'nullable|numeric',
            'commission' => 'nullable|numeric',
            'category_uuid' => 'required|string|max:36|exists:categories,category_uuid',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $validator->after(function ($validator) use ($request) {
            if ($request->input('amount') > 10000) {
                $validator->errors()->add('amount', __('word.rules.rule_seven'));
                return;
            }
            if ($request->input('amount') < 0) {
                $validator->errors()->add('amount', __('word.rules.rule_eight'));
                return;
            }
            if ($request->input('commission') > 10000) {
                $validator->errors()->add('commission', __('word.rules.rule_eleven'));
                return;
            }
            if ($request->input('commission') < 0) {
                $validator->errors()->add('commission', __('word.rules.rule_twelve'));
                return;
            }
        });
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        Service::create([
            'name' => $request->name,
            'description' => $request->description,
            'amount' => $request->amount,
            'commission' => $request->commission,
            'category_uuid' => $request->category_uuid,
            'user_id' => Auth::id(),
        ]);
        return redirect("/services")->with('success', __('word.service.alert.store'));
    }

    public function edit(string $service_uuid)
    {
        $categories = Category::where("status", '1')->get();
        $service = Service::where('service_uuid', $service_uuid)->firstOrFail();
        return view("service.edit", compact('service', 'categories'));
    }

    public function update(Request $request, string $service_uuid)
    {
        $service = Service::where('service_uuid', $service_uuid)->first();
        $rules = [
            'name' => 'required|string|max:70|unique:services,name,' . $service->service_uuid . ',service_uuid',
            'description' => 'nullable|string|max:110',
            'amount' => 'nullable|numeric',
            'commission' => 'nullable|numeric',
            'category_uuid' => 'required|string|max:36|exists:categories,category_uuid',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $validator->after(function ($validator) use ($request) {
            if ($request->input('amount') > 10000) {
                $validator->errors()->add('amount', __('word.rules.rule_seven'));
                return;
            }
            if ($request->input('amount') < 0) {
                $validator->errors()->add('amount', __('word.rules.rule_eight'));
                return;
            }
            if ($request->input('commission') > 10000) {
                $validator->errors()->add('commission', __('word.rules.rule_eleven'));
                return;
            }
            if ($request->input('commission') < 0) {
                $validator->errors()->add('commission', __('word.rules.rule_twelve'));
                return;
            }
        });
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $service->update([
            'name' => $request->name,
            'description' => $request->description,
            'amount' => $request->amount,
            'commission' => $request->commission,
            'category_uuid' => $request->category_uuid,
        ]);
        return redirect("/services")->with('success', __('word.service.alert.update'));
    }

    public function destroy(string $service_uuid)
    {
        try {
            $service = Service::where('service_uuid', $service_uuid)->first();
            $verified_income = DB::table('income_services')
                ->where('income_services.service_uuid', $service_uuid)->first();
            if (!$verified_income) {
                if ($service) {
                    $service->delete();
                    return response()->json([
                        'type' => 'success',
                        'title' => __('word.general.success'),
                        'msg' => __('word.service.delete_success'),
                        'redirect' => route('services.index')
                    ], 200);
                } else {
                    return response()->json([
                        'type' => 'error',
                        'title' => __('word.general.error'),
                        'msg' => __('word.general.not_found'),
                    ], 404);
                }
            } else {
                return response()->json([
                    'type' => 'error',
                    'title' => __('word.general.error'),
                    'msg' => __('word.service.not_allow'),
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'type' => 'error',
                'title' => __('word.general.error'),
                'msg' => __('word.general.bad_request'),
            ], 500);
        }
    }
    public function disable(string $service_uuid)
    {
        $service = Service::where('service_uuid', $service_uuid)->firstOrFail();
        $service->update([
            'status' => "0",
            'user_id' => Auth::id(),
        ]);
        return redirect("/services")->with('success', __('word.service.alert.disable'));
    }
    public function enable(string $service_uuid)
    {
        $service = Service::where('service_uuid', $service_uuid)->firstOrFail();
        $service->update([
            'status' => "1",
            'user_id' => Auth::id(),
        ]);
        return redirect("/services")->with('success', __('word.service.alert.enable'));
    }
}
