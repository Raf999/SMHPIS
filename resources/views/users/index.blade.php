@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-10">
        <div>
            <h1 class="text-4xl font-black text-gray-900 tracking-tight">
                {{ Auth::user()->isTeacher() ? 'Student Registry' : 'User Directory' }}
            </h1>
            <p class="text-gray-400 font-medium mt-1">
                {{ Auth::user()->isTeacher() ? 'Manage students in your department' : 'Manage system access and roles' }}
            </p>
        </div>
        <a href="{{ route('users.create') }}" class="mt-4 md:mt-0 h-12 px-8 bg-slate-900 text-white font-black rounded-2xl shadow-lg hover:scale-105 transition-transform flex items-center">
            <i class="fas fa-plus mr-3"></i> {{ Auth::user()->isTeacher() ? 'Add Student' : 'Add New' }}
        </a>
    </div>

    <div class="bg-white rounded-[3rem] shadow-sm border border-gray-50 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-dashboard-bg/50 text-[10px] uppercase font-black text-gray-400 tracking-[0.2em]">
                    <tr>
                        <th class="px-8 py-6">Member</th>
                        <th class="px-8 py-6">Role</th>
                        <th class="px-8 py-6">Credentials</th>
                        <th class="px-8 py-6">Status</th>
                        <th class="px-8 py-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($users as $user)
                    <tr class="hover:bg-dashboard-bg/30 transition-colors group">
                        <td class="px-8 py-6">
                            <div class="flex items-center">
                                <div class="h-12 w-12 bg-white rounded-2xl shadow-sm border border-gray-100 flex items-center justify-center text-gray-900 font-black uppercase transition-transform group-hover:scale-110 overflow-hidden">
                                    @if($user->profile_image)
                                        <img src="{{ Storage::disk('public')->url($user->profile_image) }}" class="h-full w-full object-cover">
                                    @else
                                        {{ substr($user->name, 0, 1) }}
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <p class="font-black text-gray-900 text-sm tracking-tight">{{ $user->name }}</p>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest {{ $user->role == 'admin' ? 'bg-purple-50 text-purple-600' : ($user->role == 'teacher' ? 'bg-blue-50 text-blue-600' : 'bg-teal-50 text-teal-600') }}">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-sm text-gray-600">
                            @if($user->isStudent())
                                <p class="font-black text-gray-900 text-xs">{{ $user->studentProfile->student_id_number ?? 'N/A' }}</p>
                                <p class="text-[10px] font-bold text-gray-400 uppercase mt-0.5">{{ $user->studentProfile->department->name ?? $user->studentProfile->department ?? 'General' }}</p>
                            @elseif($user->isTeacher())
                                <p class="font-black text-gray-900 text-xs">{{ $user->teacherProfile->staff_id ?? 'N/A' }}</p>
                                <p class="text-[10px] font-bold text-gray-400 uppercase mt-0.5">{{ $user->teacherProfile->department->name ?? $user->teacherProfile->department ?? 'General' }}</p>
                            @else
                                <span class="text-gray-300 italic text-xs">Full Access</span>
                            @endif
                        </td>
                        <td class="px-8 py-6">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-green-50 text-green-600">
                                <span class="w-1.5 h-1.5 mr-2 bg-green-500 rounded-full animate-pulse"></span>
                                Online
                            </span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <button class="h-10 w-10 bg-white rounded-xl shadow-sm border border-gray-100 text-gray-400 hover:text-teal-500 hover:border-teal-200 transition-all">
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
