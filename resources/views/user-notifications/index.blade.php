@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4">
    <h2 class="text-xl font-semibold mb-6 text-indigo-700">Mes notifications</h2>

    @forelse($notifications as $notification)
        <div class="mb-4 p-4 bg-white shadow rounded border border-gray-200">
            <p class="text-sm text-gray-700">
                {{ $notification->data['message'] ?? 'Notification sans message.' }}
                @if(isset($notification->data['poste_id']))
                    <a href="{{ route('postes.show', $notification->data['poste_id']) }}"
                       class="text-indigo-600 hover:underline ml-2">Voir le poste</a>
                @endif
            </p>
            <p class="text-xs text-gray-500 mt-1">
                Reçue {{ $notification->created_at->diffForHumans() }}
            </p>
        </div>
    @empty
        <p class="text-gray-500">Aucune notification pour le moment.</p>
    @endforelse
</div>
@endsection