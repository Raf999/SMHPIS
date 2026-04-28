<aside id="sidebar" class="fixed inset-y-0 left-0 w-60 bg-white border-r border-slate-200 flex flex-col z-50 transform -translate-x-full md:translate-x-0 transition-transform duration-300">

    {{-- Logo --}}
    <div class="h-14 flex items-center gap-2.5 px-5 border-b border-slate-100">
        <div class="h-7 w-7 bg-blue-600 rounded-lg flex items-center justify-center shrink-0">
            <i class="fas fa-brain text-white text-[11px]"></i>
        </div>
        <span class="text-sm font-semibold text-slate-900">SMHPIS</span>
    </div>

    {{-- User --}}
    <div class="px-3 py-4 border-b border-slate-100">
        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-2 py-2 rounded-lg hover:bg-slate-50 transition-colors group">
            <div class="h-8 w-8 rounded-lg overflow-hidden shrink-0 bg-blue-100 flex items-center justify-center">
                @if(Auth::user()->profile_image_url)
                    <img src="{{ Auth::user()->profile_image_url }}" class="h-full w-full object-cover">
                @else
                    <span class="text-xs font-semibold text-blue-700">{{ substr(Auth::user()->name, 0, 1) }}</span>
                @endif
            </div>
            <div class="min-w-0">
                <p class="text-xs font-semibold text-slate-800 truncate">{{ Auth::user()->name }}</p>
                <p class="text-[11px] text-slate-400 capitalize">{{ Auth::user()->role }}</p>
            </div>
        </a>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto">

        @php
            $dashboardRoute = match(Auth::user()->role) {
                'admin'   => route('admin.dashboard'),
                'teacher' => route('teacher.dashboard'),
                default   => route('student.dashboard'),
            };
            $isDashboard = request()->is('*/dashboard');
        @endphp

        <p class="section-label px-2 pb-2">Navigation</p>

        <a href="{{ $dashboardRoute }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors
                  {{ $isDashboard ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
            <i class="fas fa-th-large text-xs w-4 text-center {{ $isDashboard ? 'text-blue-600' : 'text-slate-400' }}"></i>
            Dashboard
        </a>

        @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
            @php $isUsers = request()->is('users*'); @endphp
            <a href="{{ route('users.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors
                      {{ $isUsers ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                <i class="fas fa-users text-xs w-4 text-center {{ $isUsers ? 'text-blue-600' : 'text-slate-400' }}"></i>
                {{ Auth::user()->isTeacher() ? 'Students' : 'Directory' }}
            </a>
        @endif

        <p class="section-label px-2 pt-4 pb-2">Mental Health</p>

        @php $isPredict = request()->is('*/predict'); @endphp
        <a href="{{ route('student.predict') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors
                  {{ $isPredict ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
            <i class="fas fa-chart-line text-xs w-4 text-center {{ $isPredict ? 'text-blue-600' : 'text-slate-400' }}"></i>
            New Analysis
        </a>

        @php $isLogs = request()->is('logs*'); @endphp
        <a href="{{ route('predictions.index') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors
                  {{ $isLogs ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
            <i class="fas fa-folder-open text-xs w-4 text-center {{ $isLogs ? 'text-blue-600' : 'text-slate-400' }}"></i>
            History Logs
        </a>

    </nav>

    {{-- Footer --}}
    <div class="px-3 py-4 border-t border-slate-100">
        <a href="{{ route('logout') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium text-slate-500 hover:bg-red-50 hover:text-red-700 transition-colors">
            <i class="fas fa-arrow-right-from-bracket text-xs w-4 text-center"></i>
            Log out
        </a>
    </div>

</aside>
