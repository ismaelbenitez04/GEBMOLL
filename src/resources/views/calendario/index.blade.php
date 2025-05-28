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
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: @json($events), // Esto se genera desde el controlador
            locale: 'es',
        });

        calendar.render();
    });
</script>
@endpush