@extends('guest.layout.layout')
@section('main-content')
    @php
        $section = request('section', 'home');
    @endphp


    @if ($section === 'register')
        @include('guest.partials.register')
    @elseif ($section === 'login')
        @include('guest.partials.login')
    @elseif ($section === 'contact')
        @include('guest.partials.contact')
    @elseif ($section === 'about')
        @include('guest.partials.about')
    @elseif ($section === 'notification')
        @include('guest.partials.notification')
    @elseif ($section === 'noti')
        @include('guest.partials.noti')
    @elseif ($section === 'conferences')
        @include('guest.partials.conferences')
    @elseif ($section === 'conferencesedit')
        @include('guest.partials.conferenceedit')
    @elseif ($section === 'journals')
        @include('guest.partials.journals')
    @elseif ($section === 'journal')
        @include('guest.partials.journal')
    @elseif ($section === 'conference')
        @include('guest.partials.conference')
    @elseif ($section === 'edit')
        @include('guest.partials.journaledit')
    @elseif ($section === 'home')
        @include('guest.partials.home')
    @elseif ($section === 'eventview')
        @include('guest.partials.eventview')
    @else
        @include('guest.partials.events')
    @endif
@endsection
