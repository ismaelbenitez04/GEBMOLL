@extends('layouts.user')

@section('title', 'Calendario')

@push('styles')
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css' rel='stylesheet' />
    <style>
        #calendar {
            max-width: 1000px;
            margin: 0 auto;
        }
    </style>
@endpush

@section('content')
    <h1 class="mb-4">Calendario</h1>
    <div id='calendar'></div>
@endsection

@push('scripts')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es',
                events: @json($events),
                eventClick: function (info) {
                    alert(info.event.title + "\n\n" + info.event.extendedProps.description);
                }
            });
            calendar.render();
        });
    </script>
@endpush
