<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $projects = Project::with(['company', 'user'])->orderBy('created_at', 'desc')->paginate($perPage);
        $projects->each(function ($project) {
            $project->start_date = Carbon::parse($project->start_date)->format('d-m-Y');
            $project->end_date = Carbon::parse($project->end_date)->format('d-m-Y');
        });
        return view("project.index", compact('projects', 'perPage'));
    }

    public function create()
    {
        $project = new Project();
        $companies = Company::where('status', true)->get();
        return view("project.create", compact('project', 'companies'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:100|unique:projects,name',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'budget' => 'nullable|numeric|min:0',
            'company_uuid' => 'required|exists:companies,company_uuid',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'budget' => $request->budget,
            'company_uuid' => $request->company_uuid,
            'user_id' => Auth::id(),
        ]);
        return redirect("/projects")->with('success', __('word.project.alert.store'));
    }

    public function edit(string $project_uuid)
    {
        $project = Project::where('project_uuid', $project_uuid)->firstOrFail();
        $companies = Company::where('status', true)->get();
        return view("project.edit", compact('project', 'companies'));
    }

    public function update(Request $request, string $project_uuid)
    {
        $project = Project::where('project_uuid', $project_uuid)->firstOrFail();
        $rules = [
            'name' => 'required|string|max:100|unique:projects,name,' . $project->project_uuid . ',project_uuid',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'budget' => 'nullable|numeric|min:0',
            'company_uuid' => 'required|exists:companies,company_uuid',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $project->update([
            'name' => $request->name,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'budget' => $request->budget,
            'company_uuid' => $request->company_uuid,
        ]);
        return redirect("/projects")->with('success', __('word.project.alert.update'));
    }

    public function destroy(string $project_uuid)
    {
        try {
            $project = Project::where('project_uuid', $project_uuid)->first();
            if ($project) {
                $project->delete();
                return response()->json([
                    'type' => 'success',
                    'title' => __('word.general.success'),
                    'msg' => __('word.project.delete_success'),
                    'redirect' => route('projects.index')
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

    public function disable(string $project_uuid)
    {
        $project = Project::where('project_uuid', $project_uuid)->firstOrFail();
        $project->update(['status' => false]);
        return redirect("/projects")->with('success', __('word.project.alert.disable'));
    }

    public function enable(string $project_uuid)
    {
        $project = Project::where('project_uuid', $project_uuid)->firstOrFail();
        $project->update(['status' => true]);
        return redirect("/projects")->with('success', __('word.project.alert.enable'));
    }
}
