<?php

namespace App\Http\Controllers;

use App\Models\Businesstype;
use App\Models\Company;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $companies = Company::with(['user', 'activity','businesstype'])->orderBy('created_at', 'desc')->paginate($perPage);
        return view("company.index", compact('companies', 'perPage'));
    }
    public function create()
    {
        $company = new Company();
        $activities = Activity::where('status', true)->get();
        $businesstypes = Businesstype::where('status', true)->get();
        return view("company.create", compact('company', 'activities','businesstypes'));
    }
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:companies,name|string|max:100',
            'nit' => 'required|numeric',
            'description' => 'nullable|string|max:150',
            'activity_uuid' => 'required|exists:activities,activity_uuid',
            'businesstype_uuid' => 'required|exists:businesstypes,businesstype_uuid',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        Company::create([
            'name' => $request->name,
            'nit' => $request->nit,
            'description' => $request->description,
            'activity_uuid' => $request->activity_uuid,
            'businesstype_uuid' => $request->businesstype_uuid,
            'user_id' => Auth::id(),
        ]);
        return redirect("/companies")->with('success', __('word.company.alert.store'));
    }
    public function edit(string $company_uuid)
    {
        $company = Company::where('company_uuid', $company_uuid)->firstOrFail();
        $activities = Activity::where('status', true)->get();
        $businesstypes = Businesstype::where('status', true)->get();
        return view("company.edit", compact('company', 'activities','businesstypes'));
    }
    public function update(Request $request, string $company_uuid)
    {
        $company = Company::where('company_uuid', $company_uuid)->firstOrFail();
        $rules = [
            'name' => 'required|string|max:100|unique:companies,name,' . $company->company_uuid . ',company_uuid',
            'nit' => 'required|numeric',
            'description' => 'nullable|string|max:150',
            'activity_uuid' => 'required|exists:activities,activity_uuid',
            'businesstype_uuid' => 'required|exists:businesstypes,businesstype_uuid',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $company->update([
            'name' => $request->name,
            'nit' => $request->nit,
            'description' => $request->description,
            'activity_uuid' => $request->activity_uuid,
            'businesstype_uuid' => $request->businesstype_uuid,
        ]);
        return redirect("/companies")->with('success', __('word.company.alert.update'));
    }
    public function destroy(string $company_uuid)
    {
        try {
            $company = Company::where('company_uuid', $company_uuid)->first();
            if ($company) {
                $company->delete();
                return response()->json([
                    'type' => 'success',
                    'title' => __('word.general.success'),
                    'msg' => __('word.company.delete_success'),
                    'redirect' => route('companies.index')
                ], 200);
            } else {
                return response()->json([
                    'type' => 'error',
                    'title' => __('word.general.error'),
                    'msg' => __('word.general.not_found'),
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'type' => 'error',
                'title' => __('word.general.error'),
                'msg' => __('word.general.bad_request'),
            ], 500);
        }
    }
    public function disable(string $company_uuid)
    {
        $company = Company::where('company_uuid', $company_uuid)->firstOrFail();
        $company->update([
            'status' => false,
        ]);
        return redirect("/companies")->with('success', __('word.company.alert.disable'));
    }
    public function enable(string $company_uuid)
    {
        $company = Company::where('company_uuid', $company_uuid)->firstOrFail();
        $company->update([
            'status' => true,
        ]);
        return redirect("/companies")->with('success', __('word.company.alert.enable'));
    }
}
