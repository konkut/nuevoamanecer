<?php

namespace App\Http\Controllers;

use App\Models\Accountclass;
use App\Models\Cashshift;
use App\Models\Company;
use App\Models\Project;
use App\Models\Voucher;
use App\Models\Voucherdetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class VoucherController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $vouchers = Voucher::where('project_uuid',session('project_uuid'))->with(['project', 'user'])->orderBy('created_at', 'desc')->paginate($perPage);
        $vouchers->each(function ($voucher) {
            $name = Company::where('company_uuid',$voucher->project->company_uuid)->value('name');
            $debit = Voucherdetail::where('voucher_uuid',$voucher->voucher_uuid)->sum('debit');
            $credit = Voucherdetail::where('voucher_uuid',$voucher->voucher_uuid)->sum('credit');
            $voucher->date = Carbon::parse($voucher->date)->format('d-m-Y');
            $voucher->debit = $debit;
            $voucher->credit = $credit;
            $voucher->company = $name;
            $voucher->data = Voucherdetail::where('voucher_uuid',$voucher->voucher_uuid)->orderBy('index','asc')->with(['analyticalaccount'])->get();
        });
        return view("voucher.index", compact('vouchers', 'perPage'));
    }

    public function create()
    {
        $voucher = new Voucher();
        $project = Project::where('project_uuid', session('project_uuid'))->with(['company'])->first();
        $analyticalaccounts = Accountclass::with('groups.subgroups.mainaccounts.analyticalaccounts')->orderBy('code', 'asc')->get();
        $last_voucher = Voucher::lockForUpdate()->orderBy('number', 'desc')->first();
        $next_code = $last_voucher ? intval($last_voucher->number) + 1 : 1;
        $number = str_pad($next_code, 6, '0', STR_PAD_LEFT);
        $voucher->name_company = $project->company->name;
        $voucher->name_project = $project->name;
        $voucher->number = $number;
        $voucher->date = Carbon::parse($voucher->date)->format('Y-m-d');
        return view("voucher.create", compact('voucher', 'analyticalaccounts'));
    }

    public function store(Request $request)
    {
        $rules = [
            'number' => 'required|numeric',
            'type' => 'required|string',
            'date' => 'required|date',
            'narration' => 'nullable|string',
            'cheque_number' => 'nullable|numeric',
            'ufv' => 'nullable|numeric',
            'usd' => 'nullable|numeric',
            'analyticalaccount_uuids' => 'required|array',
            'analyticalaccount_uuids.*' => 'required|string|max:36|exists:analyticalaccounts,analyticalaccount_uuid',
            'debits' => 'required|array',
            'debits.*' => 'nullable|numeric',
            'credits' => 'required|array',
            'credits.*' => 'nullable|numeric',
        ];
        $validator = Validator::make($request->all(), $rules);
        $validator->after(function ($validator) use ($request) {
            $last_voucher = Voucher::lockForUpdate()->orderBy('number', 'desc')->first();
            $next_code = $last_voucher ? intval($last_voucher->number) + 1 : 1;
            $number = str_pad($next_code, 6, '0', STR_PAD_LEFT);
            if ($request->input('number') != $number) {
                $validator->errors()->add('number', __('word.voucher.one_validation'));
                return;
            }
            if ($request->input('ufv') < 0) {
                $validator->errors()->add('ufv', __('word.voucher.three_validation'));
                return;
            }
            if ($request->input('usd') < 0) {
                $validator->errors()->add('usd', __('word.voucher.four_validation'));
                return;
            }
            if ($request->input('cheque_number') < 0) {
                $validator->errors()->add('cheque_number', __('word.voucher.five_validation'));
                return;
            }
            foreach ($request->input('debits') as $debit) {
                if ($debit > 10000) {
                    $validator->errors()->add('debits', __('word.rules.rule_thirty_five'));
                    return;
                }
                if ($debit < 0) {
                    $validator->errors()->add('debits', __('word.rules.rule_thirty_six'));
                    return;
                }
            }
            foreach ($request->input('credits') as $credit) {
                if ($credit > 10000) {
                    $validator->errors()->add('credits', __('word.rules.rule_thirty_seven'));
                    return;
                }
                if ($credit < 0) {
                    $validator->errors()->add('credits', __('word.rules.rule_thirty_eight'));
                    return;
                }
            }
            $total_debit = array_sum($request->input('debits'));
            $total_credit = array_sum($request->input('credits'));
            if ($total_debit != $total_credit){
                $validator->errors()->add('credits', __('word.voucher.six_validation', ['total' => $total_debit-$total_credit]));
                return;
            }
        });
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        DB::transaction(function () use ($request) {
            $voucher = Voucher::create([
                'number' => $request->number,
                'type' => $request->type,
                'date' => $request->date,
                'narration' => $request->narration,
                'cheque_number' => $request->cheque_number,
                'ufv' => $request->ufv,
                'usd' => $request->usd,
                'project_uuid' => session('project_uuid'),
                'user_id' => Auth::id(),
            ]);
            foreach ($request->analyticalaccount_uuids as $key => $analyticalaccount_uuid){
                Voucherdetail::create([
                    'debit' => $request->debits[$key] ?? 0,
                    'credit' => $request->credits[$key] ?? 0,
                    'index' => $key,
                    'analyticalaccount_uuid' => $analyticalaccount_uuid,
                    'voucher_uuid' => $voucher->voucher_uuid,
                ]);
            }
        });
        return redirect("/vouchers")->with('success', __('word.voucher.alert.store'));
    }

    public function edit(string $voucher_uuid)
    {
        $voucher = Voucher::where('voucher_uuid', $voucher_uuid)->first();
        $project = Project::where('project_uuid', $voucher->project_uuid)->with(['company'])->first();
        $analyticalaccounts = Accountclass::with('groups.subgroups.mainaccounts.analyticalaccounts')->orderBy('code', 'asc')->get();
        $vouchers = Voucherdetail::where('voucher_uuid',$voucher_uuid)->orderBy('index','asc')->with(['analyticalaccount'])->get();
        $analyticalaccount_uuids = [];
        $debits = [];
        $credits = [];
        foreach ($vouchers as $item){
            $analyticalaccount_uuids[] = $item->analyticalaccount_uuid;
            $debits[] = $item->debit;
            $credits[] = $item->credit;
        }
        $voucher->name_company = $project->company->name;
        $voucher->name_project = $project->name;
        $voucher->date = Carbon::parse($voucher->date)->format('Y-m-d');
        $voucher->analyticalaccount_uuids = $analyticalaccount_uuids;
        $voucher->debits = $debits;
        $voucher->credits = $credits;
        return view("voucher.edit", compact('voucher', 'analyticalaccounts'));
    }

    public function update(Request $request, string $voucher_uuid)
    {
        $voucher = Voucher::where('voucher_uuid', $voucher_uuid)->firstOrFail();
        $rules = [
            'number' => 'required|numeric',
            'type' => 'required|string',
            'date' => 'required|date',
            'narration' => 'nullable|string',
            'cheque_number' => 'nullable|numeric',
            'ufv' => 'nullable|numeric',
            'usd' => 'nullable|numeric',
            'analyticalaccount_uuids' => 'required|array',
            'analyticalaccount_uuids.*' => 'required|string|max:36|exists:analyticalaccounts,analyticalaccount_uuid',
            'debits' => 'required|array',
            'debits.*' => 'nullable|numeric',
            'credits' => 'required|array',
            'credits.*' => 'nullable|numeric',
        ];
        $validator = Validator::make($request->all(), $rules);
        $validator->after(function ($validator) use ($request, $voucher) {
            if ($request->input('number') != $voucher->number) {
                $validator->errors()->add('number', __('word.voucher.one_validation'));
                return;
            }
            if ($request->input('ufv') < 0) {
                $validator->errors()->add('ufv', __('word.voucher.three_validation'));
                return;
            }
            if ($request->input('usd') < 0) {
                $validator->errors()->add('usd', __('word.voucher.four_validation'));
                return;
            }
            if ($request->input('cheque_number') < 0) {
                $validator->errors()->add('cheque_number', __('word.voucher.five_validation'));
                return;
            }
            foreach ($request->input('debits') as $debit) {
                if ($debit > 10000) {
                    $validator->errors()->add('debits', __('word.rules.rule_thirty_five'));
                    return;
                }
                if ($debit < 0) {
                    $validator->errors()->add('debits', __('word.rules.rule_thirty_six'));
                    return;
                }
            }
            foreach ($request->input('credits') as $credit) {
                if ($credit > 10000) {
                    $validator->errors()->add('credits', __('word.rules.rule_thirty_seven'));
                    return;
                }
                if ($credit < 0) {
                    $validator->errors()->add('credits', __('word.rules.rule_thirty_eight'));
                    return;
                }
            }
            $total_debit = array_sum($request->input('debits'));
            $total_credit = array_sum($request->input('credits'));
            if ($total_debit != $total_credit){
                $validator->errors()->add('credits', __('word.voucher.six_validation', ['total' => $total_debit-$total_credit]));
                return;
            }
        });
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        DB::transaction(function () use ($request, $voucher) {
            $voucher->update([
                'number' => $request->number,
                'type' => $request->type,
                'date' => $request->date,
                'narration' => $request->narration,
                'cheque_number' => $request->cheque_number,
                'ufv' => $request->ufv,
                'usd' => $request->usd,
            ]);
            foreach ($request->analyticalaccount_uuids as $key => $analyticalaccount_uuid){
                $voucherdetail = Voucherdetail::where('voucher_uuid',$voucher->voucher_uuid)->where('index', $key)->first();
                if ($voucherdetail){
                    $voucherdetail->update([
                        'debit' => $request->debits[$key] ?? 0,
                        'credit' => $request->credits[$key] ?? 0,
                        'analyticalaccount_uuid' => $analyticalaccount_uuid,
                    ]);
                }
            }
        });
        return redirect("/vouchers")->with('success', __('word.voucher.alert.update'));
    }

    public function destroy(string $voucher_uuid)
    {
        try {
            $voucher = Voucher::where('voucher_uuid', $voucher_uuid)->first();
            if ($voucher) {
                $voucherdetails = Voucherdetail::where('voucher_uuid',$voucher_uuid)->get();
                foreach ($voucherdetails as $voucherdetail){
                    $voucherdetail->delete();
                }
                $voucher->delete();
                return response()->json([
                    'type' => 'success',
                    'title' => __('word.general.success'),
                    'msg' => __('word.voucher.delete_success'),
                    'redirect' => route('vouchers.index')
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
}
