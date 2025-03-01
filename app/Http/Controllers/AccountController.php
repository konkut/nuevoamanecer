<?php

namespace App\Http\Controllers;
use App\Models\Account;
use App\Models\Accountclass;
use App\Models\Accountgroup;
use App\Models\Accountsubgroup;
use App\Models\Receipt;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        $perpage_accountclasses = $request->input('perpage_accountclasses', 10);
        $perpage_accountgroups = $request->input('perpage_accountgroups', 10);
        $perpage_accountsubgroups = $request->input('perpage_accountsubgroups', 10);
        $perpage_accounts = $request->input('perpage_accounts', 10);
        $accountclasses = Accountclass::with('user')->orderBy('code', 'asc')->paginate($perpage_accountclasses);
        $accountgroups = Accountgroup::with(['user', 'accountclass'])->orderBy('code', 'asc')->paginate($perpage_accountgroups);
        $accountsubgroups = Accountsubgroup::with(['user', 'accountgroup'])->orderBy('code', 'asc')->paginate($perpage_accountsubgroups);
        $accounts = Account::with(['user','accountsubgroup'])->orderBy('code', 'asc')->paginate($perpage_accounts);
        $accountclass = new Accountclass();
        $accountgroup = new Accountgroup();
        $accountsubgroup = new Accountsubgroup();
        $account = new Account();
        $all_accountclasses = Accountclass::where("status", true)->orderBy('code', 'asc')->get();
        $all_accountgroups = Accountgroup::where("status", true)->orderBy('code', 'asc')->get();
        $all_accountsubgroups = Accountsubgroup::where("status", true)->orderBy('code', 'asc')->get();
        return view("account.index", compact(
            'accountclasses', 'accountclass',
            'accountgroups', 'accountgroup',
            'accountsubgroups', 'accountsubgroup',
            'accounts', 'account',
            'perpage_accountclasses', 'perpage_accountgroups',
            'perpage_accountsubgroups', 'perpage_accounts',
            'all_accountclasses', 'all_accountgroups', 'all_accountsubgroups'
        ));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:accounts,name|string|max:70',
            'description' => 'nullable|string|max:100',
            'accountsubgroup_uuid' => 'required|exists:accountsubgroups,accountsubgroup_uuid',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $accountsubgroup = Accountsubgroup::where('accountsubgroup_uuid', $request->accountsubgroup_uuid)->first();
        if ($accountsubgroup) {
            $base = ($accountsubgroup->code * 100);
            $next = Account::where('accountsubgroup_uuid', $request->accountsubgroup_uuid)->max('code');
            if (!$next) {
                $next = $base + 1;
            } else {
                $next += 1;
            }
            Account::create([
                'code' => $next,
                'name' => $request->name,
                'description' => $request->description,
                'accountsubgroup_uuid' => $request->accountsubgroup_uuid,
                'user_id' => Auth::id(),
            ]);
        }
        return redirect("/accounts")->with('success', __('word.account.alert.store'));
    }

    public function edit(string $account_uuid)
    {
        try {
            $account = Account::where('account_uuid', $account_uuid)->first();
            if ($account) {
                return response()->json([
                    'type' => 'success',
                    'title' => __('word.general.success'),
                    'account' => $account,
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
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, string $account_uuid)
    {
        $account = Account::where('account_uuid', $account_uuid)->firstOrFail();
        $rules = [
            'name' => 'required|string|max:70|unique:accounts,name,' . $account->account_uuid . ',account_uuid',
            'description' => 'nullable|string|max:100',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $accountsubgroup = Accountsubgroup::where('accountsubgroup_uuid', $request->accountsubgroup_uuid)->first();
        if ($accountsubgroup) {
            $base = ($accountsubgroup->code * 100);
            $next = Account::where('accountsubgroup_uuid', $request->accountsubgroup_uuid)->max('code');
            if (!$next) {
                $next = $base + 1;
            } else {
                $next += 1;
            }
            $account->update([
                'code' => $account->accountsubgroup_uuid == $request->accountsubgroup_uuid ? $account->code : $next,
                'name' => $request->name,
                'description' => $request->description,
                'accountsubgroup_uuid' => $request->accountsubgroup_uuid,
            ]);
        }
        return redirect("/accounts")->with('success', __('word.account.alert.update'));
    }

    public function destroy(string $account_uuid)
    {
        try {
            $account = Account::where('account_uuid', $account_uuid)->first();
            if ($account) {
                $account->delete();
                return response()->json([
                    'type' => 'success',
                    'title' => __('word.general.success'),
                    'msg' => __('word.account.delete_success'),
                    'redirect' => route('accounts.index')
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

    public function disable(string $account_uuid)
    {
        $account = Account::where('account_uuid', $account_uuid)->first();
        if ($account){
            $account->update([
                'status' => false,
            ]);
        }
        return redirect("/accounts")->with('success', __('word.account.alert.disable'));
    }

    public function enable(string $account_uuid)
    {
        $account = Account::where('account_uuid', $account_uuid)->first();
        if ($account){
            $account->update([
                'status' => true,
            ]);
        }
        return redirect("/accounts")->with('success', __('word.account.alert.enable'));
    }
    public function chart()
    {
        $accounts = Accountclass::with('groups.subgroups.accounts')->orderBy('code', 'asc')->get();
        $pdf = Pdf::loadView('account.charts', ['accountclasses' => $accounts])
            ->setPaper('letter', 'portrait')
            ->setOption('isPhpEnabled', true); // Habilitar PHP en la vista
        $name = __('word.account.chart');
        $date = Carbon::now()->format('Y-m-d'); // Formato seguro para nombres de archivo
        $filename = "{$name}_{$date}.pdf";

        return $pdf->stream($filename);
    }
}
