@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">

    <div class="page-header flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="page-title">
                {{ Auth::user()->isTeacher() ? 'Student Registry' : 'User Directory' }}
            </h1>
            <p class="page-subtitle">
                {{ Auth::user()->isTeacher() ? 'Manage students in your department' : 'Manage system access and roles' }}
            </p>
        </div>
        <a href="{{ route('users.create') }}" class="btn-primary self-start">
            <i class="fas fa-plus text-xs"></i>
            {{ Auth::user()->isTeacher() ? 'Add student' : 'Add member' }}
        </a>
    </div>

    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Member</th>
                        <th>Role</th>
                        <th>Credentials</th>
                        <th>Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="h-9 w-9 rounded-lg overflow-hidden bg-blue-100 flex items-center justify-center shrink-0">
                                    @if($user->profile_image_url)
                                        <img src="{{ $user->profile_image_url }}" class="h-full w-full object-cover">
                                    @else
                                        <span class="text-xs font-semibold text-blue-700">{{ substr($user->name, 0, 1) }}</span>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-slate-900">{{ $user->name }}</p>
                                    <p class="text-xs text-slate-400">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge-role
                                {{ $user->role === 'admin' ? 'bg-purple-50 text-purple-700' : ($user->role === 'teacher' ? 'bg-blue-50 text-blue-700' : 'bg-teal-50 text-teal-700') }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>
                            @if($user->isStudent())
                                <p class="text-sm text-slate-700">{{ $user->studentProfile->student_id_number ?? 'N/A' }}</p>
                                <p class="text-xs text-slate-400">{{ $user->studentProfile->department->name ?? $user->studentProfile->department ?? 'General' }}</p>
                            @elseif($user->isTeacher())
                                <p class="text-sm text-slate-700">{{ $user->teacherProfile->staff_id ?? 'N/A' }}</p>
                                <p class="text-xs text-slate-400">{{ $user->teacherProfile->department->name ?? $user->teacherProfile->department ?? 'General' }}</p>
                            @else
                                <span class="text-xs text-slate-400 italic">Full access</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge-healthy">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                Active
                            </span>
                        </td>
                        <td class="text-right">
                            <button class="btn-ghost px-2.5 py-1.5 text-xs">
                                <i class="fas fa-pen text-xs"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
