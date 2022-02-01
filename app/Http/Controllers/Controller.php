<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public final function setFlash(string $msg, bool $status = false): void
    {
        $type = $status ? 'success' : 'danger';
        session()->flash('type', $type);
        session()->flash('msg', $msg);
        session()->flash('status', $status);
    }

}
