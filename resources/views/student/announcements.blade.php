@extends('layouts.app')

@section('title', 'Announcements')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Announcements</h1>
        <p class="text-gray-600">Stay updated with the latest information</p>
    </div>

    <div class="space-y-6">
        @forelse($announcements as $announcement)
            <div class="bg-white shadow rounded-lg hover:shadow-md transition-shadow duration-200">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">
                                {{ $announcement->title }}
                            </h3>
                            <div class="flex items-center space-x-4 text-sm text-gray-500">
                                <span class="flex items-center">
                                    <i class="fas fa-user mr-1"></i>
                                    {{ $announcement->author->full_name }}
                                </span>
                                <span class="flex items-center">
                                    <i class="fas fa-calendar mr-1"></i>
                                    {{ $announcement->created_at->format('F d, Y \a\t g:i A') }}
                                </span>
                                @if ($announcement->priority === 'high')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-exclamation-circle mr-1"></i> High Priority
                                    </span>
                                @elseif($announcement->priority === 'medium')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Medium Priority
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="prose max-w-none text-gray-600">
                        {!! nl2br(e($announcement->content)) !!}
                    </div>

                    @if ($announcement->publish_at && $announcement->publish_at->isFuture())
                        <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-md">
                            <div class="flex items-center">
                                <i class="fas fa-clock text-blue-500 mr-2"></i>
                                <span class="text-sm text-blue-700">
                                    Scheduled for: {{ $announcement->publish_at->format('F d, Y \a\t g:i A') }}
                                </span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="bg-white shadow rounded-lg">
                <div class="px-4 py-12 text-center">
                    <i class="fas fa-bullhorn text-4xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Announcements</h3>
                    <p class="text-gray-500">There are no announcements at the moment. Please check back later.</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if ($announcements->hasPages())
        <div class="mt-6">
            {{ $announcements->links() }}
        </div>
    @endif
@endsection
