<?php

namespace App\Http\Controllers;

use App\Models\Queue;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $queues = Queue::where('status', 'open')->orderBy('created_at', 'asc')->get();
        $onHandle = Queue::where('status', 'on_handle')->first();

        $data['queues'] = $queues;
        $data['onHandle'] = $onHandle;
        return view('home', $data);
    }

    public function kiosk()
    {
        return view('kiosk');
    }

    public function admin()
    {
        $queues = Queue::where('status', 'open')->orderBy('created_at', 'asc')->get();
        $onHandle = Queue::where('status', 'on_handle')->first();

        $data['queues'] = $queues;
        $data['onHandle'] = $onHandle;
        return view('admin', $data);
    }
}
