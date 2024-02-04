@extends('layout.main')

@section('content')
    <header class="bg-white border-b">
        <div class="flex items-center justify-between p-4">
            <img src="{{ asset('image/logo.png') }}" class="h-8" alt="">
            <a href="#" class="text-blue-500 hover:underline">Logout</a>
        </div>
    </header>
    <div class="mx-auto p-8 2xl:m-14  flex gap-3 flex-col items-center ">
        <div class="bg-white p-8 rounded-lg shadow-md text-gray-800 max-w-sm">
            <h2 class="text-2xl font-semibold mb-2 text-center">Sedang dilayani:</h2>
            <p id="on-handling-queue" class="text-8xl lg:text-9xl font-bold text-center">
                {{ $onHandle->queue_number ?? '----' }}
            </p>
        </div>
        <div class="flex space-x-4">
            <button id="prevBtn" class="bg-red-500 text-white px-4 py-2 rounded">Prev</button>
            <button id="nextBtn" class="bg-blue-500 text-white px-4 py-2 rounded">Next</button>
        </div>
        <div class="bg-white p-8 rounded-lg shadow-md text-gray-800 w-full ">
            <table class="table-auto w-full border-collapse border border-slate-500">
                <thead>
                    <tr>
                        <th class="border border-slate-600">No urut</th>
                        <th class="border border-slate-600">Nomor Antrean</th>
                        <th class="border border-slate-600">Waktu Registrasi</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @foreach ($queues as $queue)
                        <tr>
                            <td class="border border-slate-600 p-2 text-center">{{ $loop->iteration }}</td>
                            <td class="border border-slate-600 p-2 text-center">{{ $queue->queue_number }}</td>
                            <td class="border border-slate-600 p-2 text-right">{{ $queue->created_at }}</td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script type="module">
        function convertDateFormat(inputDateTime) {
            var dateTime = new Date(inputDateTime);

            var year = dateTime.getFullYear();
            var month = ('0' + (dateTime.getMonth() + 1)).slice(-2);
            var day = ('0' + dateTime.getDate()).slice(-2);

            // Ambil jam, menit, dan detik
            var hours = ('0' + dateTime.getHours()).slice(-2);
            var minutes = ('0' + dateTime.getMinutes()).slice(-2);
            var seconds = ('0' + dateTime.getSeconds()).slice(-2);

            // Gabungkan menjadi format yyyy-mm-dd HH:mm:ss
            var formattedDateTime = year + '-' + month + '-' + day + ' ' + hours + ':' + minutes + ':' + seconds;

            return formattedDateTime;
        }

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

                    var tbodyHTML = '';
                    var i = 1;
                    response.queues.forEach(function(item) {
                        tbodyHTML += '<tr>';
                        tbodyHTML += '<td class="border border-slate-600 p-2 text-center">' + i++ +
                            '</td>';
                        tbodyHTML += '<td class="border border-slate-600 p-2 text-center">' + item
                            .queue_number + '</td>';
                        tbodyHTML += '<td class="border border-slate-600 p-2 text-right">' +
                            convertDateFormat(item
                                .created_at) + '</td>';
                        tbodyHTML += '</tr>';
                    });

                    // Update tbody
                    $('#tableBody').html(tbodyHTML);
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        }

        function nextQueue() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                method: 'POST',
                url: '/next-queue',
                success: function(response) {
                    alert(response.message);
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        }
        document.getElementById('nextBtn').addEventListener('click', nextQueue);

        function prevQueue() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                method: 'POST',
                url: '/prev-queue',
                success: function(response) {
                    alert(response.message);
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        }
        document.getElementById('prevBtn').addEventListener('click', prevQueue);


        var channel = Echo.channel('public');
        channel.listen('.new-queue', function(data) {
            updateListQueue();
        })
        channel.listen('.queue', function(data) {
            document.getElementById('on-handling-queue').innerText = data.number;
            updateListQueue();
        });
    </script>
@endsection
