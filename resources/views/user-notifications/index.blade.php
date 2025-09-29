@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4">
    <h2 class="text-xl font-semibold mb-6">Mes notifications</h2>

    @forelse($notifications as $notification)
        <div class="mb-4 p-4 bg-white shadow rounded border border-gray-200">
            <p class="text-sm text-gray-700">{{ $notification->data['message'] ?? 'Notification' }}</p>
            <p class="text-xs text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
        </div>
    @empty
        <p class="text-gray-500">Aucune notification pour le moment.</p>
    @endforelse
</div>
@endsection