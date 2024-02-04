<?php

namespace App\Http\Controllers;

use App\Events\QueueAdded;
use App\Events\QueueUpdated;
use App\Models\Queue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QueueController extends Controller
{
    public function addQueue()
    {
        try {
            DB::beginTransaction();
            $qeueu = Queue::create();
            DB::commit();
            event(new QueueAdded($qeueu->queue_number));

            return response()->json([
                'success' => true,
                'message' => 'Nomor antrean anda: ' . $qeueu->queue_number
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'gagal menambah antrean: ' . $e->getMessage()
            ]);
        }
    }

    public function getQueue()
    {
        $qeueus = Queue::where('status', 'open')->orderBy('created_at', 'asc')->get();
        return response()->json([
            'queues' => $qeueus
        ]);
    }

    public function updateQueue(Request $request)
    {
        $action = $request->action;
        dd($request);
        if ($action == 'prev') {
            $prev = Queue::where('status', 'close')->orderBy('created_at', 'desc')->first();
            $onHandle = Queue::where('status', 'on_hanlde')->first();
            if ($prev) {
                try {
                    DB::beginTransaction();
                    if ($onHandle) {
                        $onHandle->status = 'open';
                        $onHandle->save();
                    }
                    $prev->status = 'on_handle';
                    $prev->save();
                    DB::commit();
                    event(new QueueAdded($prev->queue_number));

                    return redirect('/admin')->with('success', "Berhasil update antrean");
                } catch (\Exception $e) {
                    DB::rollBack();
                    return redirect('/admin')->with('error', "gagal update antrean");
                }
            } else {
                return redirect('/admin')->with('error', "tidak ada antrean");
            }
        } else {
        }
    }


    public function nextQueue()
    {
        $next = Queue::where('status', 'open')->orderBy('created_at', 'asc')->first();
        $onHandle = Queue::where('status', 'on_handle')->first();
        if ($next) {
            try {
                DB::beginTransaction();
                if ($onHandle) {
                    $onHandle->status = 'close';
                    $onHandle->save();
                }
                $next->status = 'on_handle';
                $next->save();
                DB::commit();
                event(new QueueUpdated($next->queue_number));
                return response()->json([
                    'success' => true,
                    'message' => 'berhasil update antrean'
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'gagal update antrean: ' . $e->getMessage()
                ]);
            }
        } else {

            return response()->json([
                'success' => false,
                'message' => 'tidak ada antrean berikutnya'
            ]);
        }
    }

    public function prevQueue()
    {
        $prev = Queue::where('status', 'close')->orderBy('created_at', 'desc')->first();
        $onHandle = Queue::where('status', 'on_handle')->first();

        if ($prev) {
            try {
                DB::beginTransaction();
                if ($onHandle) {
                    $onHandle->status = 'open';
                    $onHandle->save();
                }
                $prev->status = 'on_handle';
                $prev->save();
                DB::commit();
                event(new QueueUpdated($prev->queue_number));
                return response()->json([
                    'success' => true,
                    'message' => 'berhasil update antrean'
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'gagal update antrean: ' . $e->getMessage()
                ]);
            }
        } else {

            return response()->json([
                'success' => false,
                'message' => 'tidak ada antrean berikutnya'
            ]);
        }
    }
}
