<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Appointment</title>
</head>
<body>
<h1>New Appointment Booked</h1>
<p>Doctor: {{ $appointment->doctor->name }}</p>
<p>Patient: {{ $appointment->patient->name }}</p>
<p>Scheduled at: {{ $appointment->scheduled_at->format('Y-m-d H:i') }}</p>
@if($appointment->notes)
    <p>Notes: {{ $appointment->notes }}</p>
@endif
</body>
</html>
