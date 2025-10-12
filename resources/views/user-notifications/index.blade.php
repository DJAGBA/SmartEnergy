@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto mt-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Notifications reçues</h2>

        @forelse(auth()->user()->notifications as $notif)
            <div class="border-b border-gray-200 py-3">
                <p class="font-semibold text-gray-800">
                    {{ $notif->data['code_poste'] ?? 'Poste inconnu' }}
                </p>

                @if(!empty($notif->data['message']))
                    <p class="text-sm text-red-600 italic">
                        {{ $notif->data['message'] }}
                    </p>
                @endif

                <p class="text-xs text-gray-500 mt-1">
                    Signalé par {{ $notif->data['signalé_par'] ?? 'N/A' }}
                    le {{ \Carbon\Carbon::parse($notif->data['created_at'] ?? $notif->created_at)->format('d/m/Y à H:i') }}
                </p>
            </div>
        @empty
            <div class="text-center text-gray-500 py-6">
                Aucune notification pour le moment.
            </div>
        @endforelse
    </div>
@endsection
