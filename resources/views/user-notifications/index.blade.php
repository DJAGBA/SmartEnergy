@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4">
    <h2 class="text-xl font-semibold mb-6 text-indigo-700">Mes notifications</h2>

    {{-- Notifications fictives --}}
    @php
        $notifications = [
            [
                'message' => 'Le poste P001 est hors service.',
                'poste_id' => 1,
                'created_at' => now()->subMinutes(30),
            ],
            [
                'message' => 'Le poste P010 est hors service.',
                'poste_id' => 64,
                'created_at' => now()->subHours(2),
            ],
            [
                'message' => 'Le poste P011 présente une anomalie électrique.',
                'poste_id' => 65,
                'created_at' => now()->subHours(5),
            ],
            [
                'message' => 'Le poste P012 est inaccessible depuis la zone 3.',
                'poste_id' => 66,
                'created_at' => now()->subDay(),
            ],
        ];
    @endphp

    @forelse($notifications as $notification)
        <div class="mb-4 p-4 bg-white shadow rounded border border-gray-200">
            <p class="text-sm text-gray-700">
                {{ $notification['message'] }}
                <a href="{{ route('postes.show', $notification['poste_id']) }}"
                   class="text-indigo-600 hover:underline ml-2">Voir le poste</a>
            </p>
            <p class="text-xs text-gray-500 mt-1">
                Reçue {{ \Carbon\Carbon::parse($notification['created_at'])->diffForHumans() }}
            </p>
        </div>
    @empty
        <p class="text-gray-500">Aucune notification pour le moment.</p>
    @endforelse
</div>
@endsection