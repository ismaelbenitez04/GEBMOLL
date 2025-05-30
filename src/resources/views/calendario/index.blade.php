@extends('layouts.user')

@section('title', 'Calendario')

@section('content')
<div class="container">
    <h2>Mi Calendario</h2>
    
    <div id="calendar"></div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/main.min.css" rel="stylesheet" />
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/main.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es',
                events: @json($events),
                eventClick: function (info) {
                    alert(info.event.title + "\n\n" + (info.event.extendedProps.description || 'Sin descripción'));
                }
            });
            calendar.render();
        });
    </script>
@endpush