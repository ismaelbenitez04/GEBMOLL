@extends('layouts.user')

@section('title', 'Calendario')

@push('styles')
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css' rel='stylesheet' />
    <style>
        #calendar-container {
            max-width: 1000px;
            margin: 0 auto;
        }

        #calendar {
            background-color: white;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.05);
            padding: 1rem;
        }

        .fc-toolbar-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1E293B;
        }

        .fc-button-primary {
            background-color: #0d6efd;
            border: none;
            border-radius: 0.5rem;
        }

        .fc-button-primary:hover {
            background-color: #0b5ed7;
        }
    </style>
@endpush

@section('content')
    <div class="mb-4 text-center">
        <h1 class="fw-semibold text-primary">Calendario</h1>
        <p class="text-muted">Consulta tus eventos, clases, entregas y más.</p>
    </div>

    <div id="calendar-container">
        <div id='calendar'></div>
    </div>
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
                height: 'auto',
                eventClick: function (info) {
                    alert(info.event.title + "\n\n" + info.event.extendedProps.description);
                }
            });
            calendar.render();
        });
    </script>
@endpush
