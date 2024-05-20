@extends('layouts.app')

@section('title', 'Calendar')

@push('styles')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/fullcalendar/dist/fullcalendar.min.css') }}">
@endpush

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Calendar</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Modules</a></div>
                    <div class="breadcrumb-item">Calendar</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Calendar</h2>
                <p class="section-lead">
                    We use 'Full Calendar' made by <a href="https://fullcalendar.io/" target="_blank">@fullcalendar</a>.
                    You can check the full documentation <a href="https://fullcalendar.io/" target="_blank">here</a>.
                </p>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Calendar</h4>
                            </div>
                            <div class="card-body">
                                <div class="fc-overflow">
                                    <div id="myEvent"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script src="{{ asset('library/fullcalendar/dist/fullcalendar.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('myEvent');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: [
                    @foreach ($ordersLayanans as $ordersLayanan)
                        {
                            title: '{{ $ordersLayanan->layanan->nama }}',
                            start: '{{ $ordersLayanan->tanggal_order }}',
                            url: '{{ route('order-layanan.show', $ordersLayanan->id) }}'
                        },
                    @endforeach
                ]
            });
            calendar.render();
        });
    </script>
@endpush
