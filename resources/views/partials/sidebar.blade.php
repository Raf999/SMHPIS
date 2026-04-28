<div class="fixed inset-y-0 left-0 w-72 bg-transparent transition-all duration-300 transform -translate-x-full md:translate-x-0 z-50 p-6" id="sidebar">
    <div class="h-full bg-white rounded-[2.5rem] shadow-soft overflow-y-auto flex flex-col border border-slate-50">
        <!-- Logo Section -->
        <div class="px-10 py-10 flex items-center space-x-3">
            <div class="h-10 w-10 bg-primary rounded-xl flex items-center justify-center text-white shadow-lg shadow-blue-500/20">
                <i class="fas fa-brain text-lg"></i>
            </div>
            <span class="text-xl font-black text-slate-900 tracking-tight">SMHPIS</span>
        </div>

        <!-- User Profile Section -->
        <div class="px-8 mb-8">
            <a href="{{ route('profile.edit') }}" class="flex items-center p-4 bg-slate-50 rounded-3xl hover:bg-slate-100 transition-colors group">
                <div class="h-12 w-12 rounded-2xl overflow-hidden shadow-sm border border-white">
                    @if(Auth::user()->profile_image_url)
                        <img src="{{ Auth::user()->profile_image_url }}" class="h-full w-full object-cover">
                    @else
                        <div class="h-full w-full bg-gradient-to-br from-primary to-blue-400 flex items-center justify-center text-white font-black">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    @endif
                </div>
                <div class="ml-3 overflow-hidden">
                    <p class="text-xs font-black text-slate-900 truncate">{{ Auth::user()->name }}</p>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">{{ Auth::user()->role }}</p>
                </div>
            </a>
        </div>
        
        <nav class="flex-1 px-6 space-y-8">
            <!-- Platform Section -->
            <div>
                <div class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] px-4 mb-4">Platform</div>
                <div class="space-y-1">
                    @php
                        $dashboardRoute = match(Auth::user()->role) {
                            'admin' => route('admin.dashboard'),
                            'teacher' => route('teacher.dashboard'),
                            default => route('student.dashboard'),
                        };
                    @endphp
                    
                    <a href="{{ $dashboardRoute }}" class="sidebar-link flex items-center px-4 py-3 rounded-2xl transition-all duration-200 {{ request()->is('*/dashboard') ? 'sidebar-active shadow-sm' : 'text-slate-400 hover:text-slate-600' }}">
                        <div class="icon-box {{ request()->is('*/dashboard') ? 'bg-primary text-white shadow-lg shadow-blue-500/20' : '' }}">
                            <i class="fas fa-th-large text-xs"></i>
                        </div>
                        <span class="ml-4 text-sm font-bold">Dashboard</span>
                    </a>

                    @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
                        <a href="{{ route('users.index') }}" class="sidebar-link flex items-center px-4 py-3 rounded-2xl transition-all duration-200 {{ request()->is('users*') ? 'sidebar-active shadow-sm' : 'text-slate-400 hover:text-slate-600' }}">
                            <div class="icon-box {{ request()->is('users*') ? 'bg-primary text-white shadow-lg shadow-blue-500/20' : '' }}">
                                <i class="fas fa-users text-xs"></i>
                            </div>
                            <span class="ml-4 text-sm font-bold">{{ Auth::user()->isTeacher() ? 'Students' : 'Directory' }}</span>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Analysis Section -->
            <div>
                <div class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em] px-4 mb-4">Mental Health</div>
                <div class="space-y-1">
                    <a href="{{ route('student.predict') }}" class="sidebar-link flex items-center px-4 py-3 rounded-2xl transition-all duration-200 {{ request()->is('*/predict') ? 'sidebar-active shadow-sm' : 'text-slate-400 hover:text-slate-600' }}">
                        <div class="icon-box {{ request()->is('*/predict') ? 'bg-primary text-white shadow-lg shadow-blue-500/20' : '' }}">
                            <i class="fas fa-chart-line text-xs"></i>
                        </div>
                        <span class="ml-4 text-sm font-bold">New Analysis</span>
                    </a>

                    <a href="{{ route('predictions.index') }}" class="sidebar-link flex items-center px-4 py-3 rounded-2xl transition-all duration-200 {{ request()->is('logs') ? 'sidebar-active shadow-sm' : 'text-slate-400 hover:text-slate-600' }}">
                        <div class="icon-box {{ request()->is('logs') ? 'bg-primary text-white shadow-lg shadow-blue-500/20' : '' }}">
                            <i class="fas fa-folder-open text-xs"></i>
                        </div>
                        <span class="ml-4 text-sm font-bold">History Logs</span>
                    </a>
                </div>
            </div>
        </nav>

        <!-- Bottom Section -->
        <div class="p-8 border-t border-slate-50">
            <a href="{{ route('logout') }}" class="flex items-center px-4 py-4 rounded-2xl text-slate-400 hover:text-red-600 hover:bg-red-50 transition-all group">
                <div class="h-10 w-10 flex items-center justify-center rounded-xl bg-slate-50 group-hover:bg-red-100 transition-colors mr-4">
                    <i class="fas fa-power-off text-xs"></i>
                </div>
                <span class="text-sm font-bold">Log out</span>
            </a>
        </div>
    </div>
</div>
