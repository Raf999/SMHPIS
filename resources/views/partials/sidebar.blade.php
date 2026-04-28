<div class="fixed inset-y-0 left-0 w-64 bg-transparent transition-all duration-300 transform -translate-x-full md:translate-x-0 z-50 p-4" id="sidebar">
    <div class="h-full bg-white rounded-3xl shadow-soft overflow-y-auto flex flex-col border border-slate-100">
        <!-- Logo Section -->
        <div class="p-8 text-center border-b border-slate-50">
            <span class="text-xl font-black bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent uppercase tracking-tight">SMHPIS</span>
        </div>

        <!-- User Profile Section -->
        <a href="{{ route('profile.edit') }}" class="block px-6 py-8 text-center group border-b border-slate-50">
            <div class="relative inline-block mb-4">
                <div class="h-16 w-16 bg-gradient-to-br from-primary to-secondary rounded-2xl flex items-center justify-center text-white text-xl font-black shadow-lg overflow-hidden group-hover:scale-105 transition-transform duration-300">
                    @if(Auth::user()->profile_image)
                        <img src="{{ Storage::disk('public')->url(Auth::user()->profile_image) }}" class="h-full w-full object-cover">
                    @else
                        {{ substr(Auth::user()->name, 0, 1) }}
                    @endif
                </div>
                <div class="absolute -bottom-1 -right-1 h-5 w-5 bg-green-500 border-2 border-white rounded-full"></div>
            </div>
            <h3 class="text-sm font-bold text-slate-900 group-hover:text-primary transition-colors">{{ Auth::user()->name }}</h3>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">{{ Auth::user()->role }}</p>
        </a>
        
        <nav class="mt-6 px-4 space-y-2 flex-1">
            @php
                $dashboardRoute = match(Auth::user()->role) {
                    'admin' => route('admin.dashboard'),
                    'teacher' => route('teacher.dashboard'),
                    default => route('student.dashboard'),
                };
            @endphp
            
            <div class="pb-2 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] px-4">Main Menu</div>

            <a href="{{ $dashboardRoute }}" class="flex items-center px-4 py-3 rounded-2xl transition-all duration-200 {{ request()->is('*/dashboard') ? 'sidebar-active text-slate-900' : 'hover:bg-slate-50 text-slate-500' }}">
                <div class="icon-box {{ request()->is('*/dashboard') ? '' : 'opacity-70 grayscale' }}">
                    <i class="fas fa-th-large"></i>
                </div>
                <span class="ml-3 text-sm font-bold">Dashboard</span>
            </a>

            @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
                <a href="{{ route('users.index') }}" class="flex items-center px-4 py-3 rounded-2xl transition-all duration-200 {{ request()->is('users*') ? 'sidebar-active text-slate-900' : 'hover:bg-slate-50 text-slate-500' }}">
                    <div class="icon-box {{ request()->is('users*') ? '' : 'opacity-70 grayscale' }}">
                        <i class="fas fa-users"></i>
                    </div>
                    <span class="ml-3 text-sm font-bold">{{ Auth::user()->isTeacher() ? 'Students' : 'Directory' }}</span>
                </a>
            @endif

            <a href="{{ route('student.predict') }}" class="flex items-center px-4 py-3 rounded-2xl transition-all duration-200 {{ request()->is('*/predict') ? 'sidebar-active text-slate-900' : 'hover:bg-slate-50 text-slate-500' }}">
                <div class="icon-box {{ request()->is('*/predict') ? '' : 'opacity-70 grayscale' }}">
                    <i class="fas fa-chart-line"></i>
                </div>
                <span class="ml-3 text-sm font-bold">Analysis</span>
            </a>

            <a href="{{ route('predictions.index') }}" class="flex items-center px-4 py-3 rounded-2xl transition-all duration-200 {{ request()->is('logs') ? 'sidebar-active text-slate-900' : 'hover:bg-slate-50 text-slate-500' }}">
                <div class="icon-box {{ request()->is('logs') ? '' : 'opacity-70 grayscale' }}">
                    <i class="fas fa-folder-open"></i>
                </div>
                <span class="ml-3 text-sm font-bold">Reports</span>
            </a>
        </nav>

        <!-- Bottom Section -->
        <div class="p-6">
            <a href="{{ route('logout') }}" class="flex items-center px-4 py-3 rounded-2xl text-slate-400 hover:text-red-500 hover:bg-red-50 transition-all group">
                <div class="h-8 w-8 flex items-center justify-center rounded-lg bg-slate-50 group-hover:bg-red-100 group-hover:text-red-500 transition-colors mr-3">
                    <i class="fas fa-power-off text-xs"></i>
                </div>
                <span class="text-xs font-bold uppercase tracking-widest">Log out</span>
            </a>
        </div>
    </div>
</div>
