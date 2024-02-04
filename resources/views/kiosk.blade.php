@extends('layout.main')

@section('content')
    <div class="h-screen flex justify-center items-center">
        <button id="registerBtn"
            class="bg-white border border-fuchsia-500 text-fuchsia-500 px-8 py-4 rounded-full text-2xl lg:text-6xl font-semibold hover:bg-fuchsia-600 hover:text-white">
            Ambil Nomor Antrean
        </button>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        function addQueue() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                method: 'POST',
                url: '/add-queue',
                success: function(response) {
                    alert(response.message);
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        }
        document.getElementById('registerBtn').addEventListener('click', addQueue);
    </script>
@endsection
