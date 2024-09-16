@component('mail::message')
{{-- Greeting --}}
# Prispel je nov kontakt!

{{-- Intro Lines --}}
Ime: {{$contact_name}}<br>
Predmet: {{$contact_subject}}<br>
E-mail: <a href="mailto:{{$contact_email}}">{{$contact_email}}</a><br>
Sporočilo: {{$contact_message}}
 
@endcomponent