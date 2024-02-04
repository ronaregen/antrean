<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Queue extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($queue) {
            $queue->queue_number = self::__generateQueueNumber();
            $queue->created_at = now();
        });
    }

    protected static function __generateQueueNumber()
    {

        $lastInvoiceNumber = DB::table('queues')
            ->where('queue_number', 'like', 'M%')
            ->orderBy('queue_number', 'desc')
            ->value('queue_number');

        // Jika tidak ada nomor sebelumnya, inisialisasi dengan 1, jika ada, tambahkan 1
        $sequenceNumber = ($lastInvoiceNumber) ? intval(substr($lastInvoiceNumber, -3)) + 1 : 1;

        // Format nomor urutan menjadi tiga digit dengan leading zeros
        $formattedSequence = str_pad($sequenceNumber, 3, '0', STR_PAD_LEFT);

        // Gabungkan tanggal dan nomor urutan untuk mendapatkan nomor tiket baru
        $newQueueNumber = 'M' . $formattedSequence;

        return $newQueueNumber;
    }
}
