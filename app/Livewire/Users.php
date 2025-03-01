<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Barryvdh\DomPDF\Facade\Pdf;
class Users extends Component
{
    public $users;
    public $roles;
    public function mount()
    {
        $this->roles = Role::all();
        $this->users=User::all();
    }
    public function render()
    {
        return view('livewire.users')->layout('layouts.app');
    }
    public function generatepdf(){
        $data = [
            'users'=>$this->users
        ];
        $pdf = Pdf::loadView('users-pdf',$data);
        return response()->streamDownload(function ()use($pdf){
            echo $pdf->stream();
        },'users.pdf');
    }
}
