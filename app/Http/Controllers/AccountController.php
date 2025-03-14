<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Accountclass;
use App\Models\Accountgroup;
use App\Models\Accountsubgroup;
use App\Models\Analyticalaccount;
use App\Models\Businesstype;
use App\Models\Mainaccount;
use App\Models\Receipt;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        $perpage_accountclasses = $request->input('perpage_accountclasses', 10);
        $perpage_accountgroups = $request->input('perpage_accountgroups', 10);
        $perpage_accountsubgroups = $request->input('perpage_accountsubgroups', 10);
        $perpage_mainaccounts = $request->input('perpage_mainaccounts', 10);
        $perpage_analyticalaccounts = $request->input('perpage_analyticalaccounts', 10);
        $accountclasses = Accountclass::with('user')->orderBy('code', 'asc')->paginate($perpage_accountclasses);
        $accountgroups = Accountgroup::join('accountclasses', 'accountgroups.accountclass_uuid', '=', 'accountclasses.accountclass_uuid')
            ->with(['user', 'accountclass'])->select('accountgroups.*')
            ->orderBy('accountclasses.code', 'asc')
            ->orderBy('accountgroups.code', 'asc')
            ->paginate($perpage_accountgroups);
        $accountsubgroups = Accountsubgroup::join('accountgroups', 'accountsubgroups.accountgroup_uuid', '=', 'accountgroups.accountgroup_uuid')
            ->join('accountclasses', 'accountclasses.accountclass_uuid', '=', 'accountgroups.accountclass_uuid')
            ->with(['user', 'accountgroup'])->select('accountsubgroups.*')
            ->orderBy('accountclasses.code', 'asc')
            ->orderBy('accountgroups.code', 'asc')
            ->orderBy('accountsubgroups.code', 'asc')
            ->paginate($perpage_accountsubgroups);
        $mainaccounts = Mainaccount::join('accountsubgroups', 'accountsubgroups.accountsubgroup_uuid', '=', 'mainaccounts.accountsubgroup_uuid')
            ->join('accountgroups', 'accountgroups.accountgroup_uuid', '=', 'accountsubgroups.accountgroup_uuid')
            ->join('accountclasses', 'accountclasses.accountclass_uuid', '=', 'accountgroups.accountclass_uuid')
            ->with(['user', 'accountsubgroup','businesstypes'])
            ->select('mainaccounts.*')
            ->orderByRaw('CAST(accountclasses.code AS UNSIGNED) asc')
            ->orderByRaw('CAST(accountgroups.code AS UNSIGNED) asc')
            ->orderByRaw('CAST(accountsubgroups.code AS UNSIGNED) asc')
            ->orderByRaw('CAST(mainaccounts.code AS UNSIGNED) asc')
            ->paginate($perpage_mainaccounts);
        $analyticalaccounts = Analyticalaccount::join('mainaccounts', 'mainaccounts.mainaccount_uuid', '=', 'analyticalaccounts.mainaccount_uuid')
            ->join('accountsubgroups', 'accountsubgroups.accountsubgroup_uuid', '=', 'mainaccounts.accountsubgroup_uuid')
            ->join('accountgroups', 'accountgroups.accountgroup_uuid', '=', 'accountsubgroups.accountgroup_uuid')
            ->join('accountclasses', 'accountclasses.accountclass_uuid', '=', 'accountgroups.accountclass_uuid')
            ->with(['user', 'mainaccount'])
            ->select('analyticalaccounts.*')
            ->orderByRaw('CAST(accountclasses.code AS UNSIGNED) asc')
            ->orderByRaw('CAST(accountgroups.code AS UNSIGNED) asc')
            ->orderByRaw('CAST(accountsubgroups.code AS UNSIGNED) asc')
            ->orderByRaw('CAST(mainaccounts.code AS UNSIGNED) asc')
            ->orderByRaw('CAST(analyticalaccounts.code AS UNSIGNED) asc')
            ->paginate($perpage_analyticalaccounts);
        $accountclass = new Accountclass();
        $accountgroup = new Accountgroup();
        $accountsubgroup = new Accountsubgroup();
        $mainaccount = new Mainaccount();
        $analyticalaccount = new Analyticalaccount();
        $all_accountclasses = Accountclass::where("status", true)->orderBy('code', 'asc')->get();
        $all_accountgroups = Accountgroup::join('accountclasses', 'accountgroups.accountclass_uuid', '=', 'accountclasses.accountclass_uuid')
            ->where("accountgroups.status", true)
            ->select('accountgroups.*')
            ->orderBy('accountclasses.code', 'asc')
            ->orderBy('accountgroups.code', 'asc')
            ->get();
        $all_accountsubgroups = Accountsubgroup::join('accountgroups', 'accountsubgroups.accountgroup_uuid', '=', 'accountgroups.accountgroup_uuid')
            ->join('accountclasses', 'accountclasses.accountclass_uuid', '=', 'accountgroups.accountclass_uuid')
            ->where("accountsubgroups.status", true)
            ->select('accountsubgroups.*')
            ->orderBy('accountclasses.code', 'asc')
            ->orderBy('accountgroups.code', 'asc')
            ->orderBy('accountsubgroups.code', 'asc')
            ->get();
        $all_mainaccounts = Mainaccount::join('accountsubgroups', 'accountsubgroups.accountsubgroup_uuid', '=', 'mainaccounts.accountsubgroup_uuid')
            ->join('accountgroups', 'accountsubgroups.accountgroup_uuid', '=', 'accountgroups.accountgroup_uuid')
            ->join('accountclasses', 'accountclasses.accountclass_uuid', '=', 'accountgroups.accountclass_uuid')
            ->where("mainaccounts.status", true)
            ->select('mainaccounts.*')
            ->orderBy('accountclasses.code', 'asc')
            ->orderBy('accountgroups.code', 'asc')
            ->orderBy('accountsubgroups.code', 'asc')
            ->orderBy('mainaccounts.code', 'asc')
            ->get();
        $businesstypes = Businesstype::where('status', true)->get();
        return view("account.index", compact(
            'accountclasses', 'accountclass', 'accountgroups', 'accountgroup', 'accountsubgroups', 'accountsubgroup', 'mainaccounts', 'mainaccount', 'analyticalaccounts', 'analyticalaccount',
            'perpage_accountclasses', 'perpage_accountgroups','perpage_accountsubgroups', 'perpage_mainaccounts', 'perpage_analyticalaccounts',
            'all_accountclasses', 'all_accountgroups', 'all_accountsubgroups', 'all_mainaccounts', 'businesstypes'
        ));
    }
    public function chart()
    {
        $accounts = Accountclass::with('groups.subgroups.mainaccounts.analyticalaccounts')->orderBy('code', 'asc')->get();
        $pdf = Pdf::loadView('account.charts', ['accountclasses' => $accounts])
            ->setPaper('letter', 'portrait')
            ->setOption('isPhpEnabled', true);
        $name = __('word.account.chart');
        $date = Carbon::now()->format('Y-m-d');
        $filename = "{$name}_{$date}.pdf";
        return $pdf->stream($filename);
    }
}
