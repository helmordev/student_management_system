@extends('layouts.app')

@section('title', 'Manage Announcements')

@section('content')
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Announcement Management</h1>
                <p class="text-gray-600">Create and manage system announcements</p>
            </div>
            <button type="button" onclick="document.getElementById('addAnnouncementForm').classList.toggle('hidden')"
                class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                <i class="fas fa-plus mr-2"></i> Create Announcement
            </button>
        </div>
    </div>

    <!-- Add Announcement Form -->
    <div id="addAnnouncementForm" class="hidden bg-white shadow rounded-lg mb-6">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Create New Announcement</h3>
        </div>
        <div class="px-4 py-5 sm:p-6">
            <form method="POST" action="{{ route('admin.announcements.store') }}">
                @csrf
                <div class="space-y-6">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                            Title *
                        </label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('title') border-red-500 @enderror"
                            placeholder="Enter announcement title">
                        @error('title')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Content -->
                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-1">
                            Content *
                        </label>
                        <textarea name="content" id="content" rows="6" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('content') border-red-500 @enderror"
                            placeholder="Enter announcement content">{{ old('content') }}</textarea>
                        @error('content')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Priority -->
                        <div>
                            <label for="priority" class="block text-sm font-medium text-gray-700 mb-1">
                                Priority *
                            </label>
                            <select name="priority" id="priority" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('priority') border-red-500 @enderror">
                                <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                            </select>
                            @error('priority')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Publish Date -->
                        <div>
                            <label for="publish_at" class="block text-sm font-medium text-gray-700 mb-1">
                                Schedule Publication (Optional)
                            </label>
                            <input type="datetime-local" name="publish_at" id="publish_at" value="{{ old('publish_at') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('publish_at') border-red-500 @enderror">
                            @error('publish_at')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">
                                Leave empty to publish immediately
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="document.getElementById('addAnnouncementForm').classList.add('hidden')"
                        class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                        Create Announcement
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Announcements List -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Announcements ({{ $announcements->total() }})
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title &
                            Content</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Priority
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($announcements as $announcement)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $announcement->title }}</div>
                                <div class="text-sm text-gray-500 mt-1">
                                    {{ Str::limit($announcement->content, 100) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($announcement->priority === 'high')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-exclamation-circle mr-1"></i> High
                                    </span>
                                @elseif($announcement->priority === 'medium')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Medium
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Low
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $announcement->author->full_name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($announcement->publish_at && $announcement->publish_at->isFuture())
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <i class="fas fa-clock mr-1"></i> Scheduled
                                    </span>
                                @elseif($announcement->is_active)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check mr-1"></i> Active
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-times mr-1"></i> Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div>{{ $announcement->created_at->format('M d, Y') }}</div>
                                <div>{{ $announcement->created_at->format('g:i A') }}</div>
                                @if ($announcement->publish_at)
                                    <div class="text-xs text-blue-600">
                                        Pub: {{ $announcement->publish_at->format('M d, Y') }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <button type="button" onclick="editAnnouncement({{ $announcement }})"
                                        class="text-blue-600 hover:text-blue-900 transition-colors duration-200"
                                        title="Edit Announcement">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form method="POST"
                                        action="{{ route('admin.announcements.toggle-status', $announcement) }}"
                                        class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="text-yellow-600 hover:text-yellow-900 transition-colors duration-200"
                                            title="{{ $announcement->is_active ? 'Deactivate' : 'Activate' }}">
                                            <i class="fas fa-power-off"></i>
                                        </button>
                                    </form>
                                    <form method="POST"
                                        action="{{ route('admin.announcements.delete', $announcement) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-600 hover:text-red-900 transition-colors duration-200"
                                            title="Delete Announcement"
                                            onclick="return confirm('Are you sure you want to delete this announcement?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <i class="fas fa-bullhorn text-4xl text-gray-300 mb-4"></i>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No Announcements</h3>
                                <p class="text-gray-500">No announcements have been created yet.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($announcements->hasPages())
            <div class="px-4 py-4 border-t border-gray-200">
                {{ $announcements->links() }}
            </div>
        @endif
    </div>

    <!-- Edit Announcement Modal -->
    <div id="editAnnouncementModal"
        class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="px-4 py-3 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Edit Announcement</h3>
                </div>
                <form id="editAnnouncementForm" method="POST" class="px-4 py-5">
                    @csrf
                    @method('PUT')
                    <div class="space-y-6">
                        <div>
                            <label for="edit_title" class="block text-sm font-medium text-gray-700 mb-1">
                                Title *
                            </label>
                            <input type="text" name="title" id="edit_title" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            @error('title')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="edit_content" class="block text-sm font-medium text-gray-700 mb-1">
                                Content *
                            </label>
                            <textarea name="content" id="edit_content" rows="6" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
                            @error('content')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="edit_priority" class="block text-sm font-medium text-gray-700 mb-1">
                                    Priority *
                                </label>
                                <select name="priority" id="edit_priority" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                </select>
                                @error('priority')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="edit_publish_at" class="block text-sm font-medium text-gray-700 mb-1">
                                    Schedule Publication
                                </label>
                                <input type="datetime-local" name="publish_at" id="edit_publish_at"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                @error('publish_at')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" id="edit_is_active" value="1"
                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Active</span>
                                @error('is_active')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </label>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end space-x-3">
                        <button type="button" onclick="closeEditModal()"
                            class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                            Update Announcement
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function editAnnouncement(announcement) {
            document.getElementById('editAnnouncementForm').action = `/admin/announcements/${announcement.id}`;
            document.getElementById('edit_title').value = announcement.title;
            document.getElementById('edit_content').value = announcement.content;
            document.getElementById('edit_priority').value = announcement.priority;
            document.getElementById('edit_is_active').checked = announcement.is_active;

            if (announcement.publish_at) {
                const publishDate = new Date(announcement.publish_at);
                const localDate = publishDate.toISOString().slice(0, 16);
                document.getElementById('edit_publish_at').value = localDate;
            } else {
                document.getElementById('edit_publish_at').value = '';
            }

            document.getElementById('editAnnouncementModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editAnnouncementModal').classList.add('hidden');
        }

        document.getElementById('editAnnouncementModal').addEventListener('click', function(e) {
            if (e.target.id === 'editAnnouncementModal') {
                closeEditModal();
            }
        });
    </script>
@endsection
