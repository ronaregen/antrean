@extends('layout.main')

@section('content')
    <div class="w-full bg-white p-3">
        <img src="{{ asset('image/logo.png') }}" class="h-16" alt="">
    </div>
    <div class="mx-auto p-8 2xl:m-14  flex gap-3 flex-col lg:flex-row content-start ">
        <div class="bg-white p-8 rounded-lg shadow-md text-gray-800 max-w-1/3 h-56">
            <h2 class="text-2xl font-semibold mb-2 text-center">Sedang dilayani:</h2>
            <p id="on-handling-queue" class="text-8xl lg:text-9xl text-center">{{ $onHandle->queue_number ?? '----' }}</p>
        </div>
        <div class="bg-white p-8 rounded-lg shadow-md text-gray-800 w-sm lg:w-2/3 max-w-lg ">
            <h2 class="text-2xl font-semibold mb-2 text-start">antrean berikutnya:</h2>
            <div class="grid grid-cols-1 divide-y text-4xl text-end divide-slate-500 " id="list-queue">
                @foreach ($queues as $queue)
                    <div>{{ $queue->queue_number }}</div>
                @endforeach
            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script type="module">
        function updateListQueue() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                method: 'GET',
                url: '/get-queue',
                success: function(response) {

                    var listHTML = '';
                    var i = 1;
                    response.queues.forEach(function(item) {
                        listHTML += ' <div>' + item.queue_number + '</div>';

                    });

                    // Update tbody
                    $('#list-queue').html(listHTML);
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        }


        var channel = Echo.channel('public');
        channel.listen('.queue', function(data) {
            document.getElementById('on-handling-queue').innerText = data.number;
            updateListQueue();
        });

        channel.listen('.new-queue', function(data) {
            updateListQueue()
        })
    </script>
@endsection
