@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
        <div class="px-8 py-6 bg-slate-900 text-white">
            <h2 class="text-2xl font-bold">New Mental Health Analysis</h2>
            <p class="text-slate-400 text-sm">Fill in the clinical and academic data for processing.</p>
        </div>

        @if($errors->any())
        <div class="mx-8 mt-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-xl flex items-center">
            <i class="fas fa-exclamation-circle text-red-500 mr-3 text-lg"></i>
            <div>
                <p class="text-sm font-bold text-red-800">{{ $errors->first() }}</p>
            </div>
        </div>
        @endif

        <form action="{{ route('student.predict.submit') }}" method="POST" class="p-8 space-y-8">
            @csrf

            <!-- Student Selection (For Admin/Teacher) -->
            @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
            <div class="pb-6 border-b border-gray-100">
                <label class="block text-sm font-bold text-gray-700 mb-2">Select Student</label>
                <select name="student_id" id="student_id" required class="w-full rounded-xl border-gray-200 focus:border-teal-500 focus:ring-teal-500">
                    <option value="">-- Choose a Student --</option>
                    @foreach($students as $s)
                        <option value="{{ $s->id }}" data-age="{{ $s->age }}" data-gender="{{ $s->gender }}">
                            {{ $s->user->name }} ({{ $s->student_id_number }})
                        </option>
                    @endforeach
                </select>
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Bio Data (Auto-filled or manual) -->
                <div class="space-y-6">
                    <h3 class="text-sm font-black text-slate-400 uppercase tracking-widest">Personal Metrics</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Age</label>
                            <input type="number" name="age" id="age" min="16" max="60" required
                                   class="w-full rounded-xl border-gray-200 focus:border-teal-500 focus:ring-teal-500" 
                                   value="{{ Auth::user()->isStudent() ? Auth::user()->studentProfile->age : '' }}" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Current GPA</label>
                            <input type="number" step="0.01" name="gpa" min="0" max="4" required
                                   class="w-full rounded-xl border-gray-200 focus:border-teal-500 focus:ring-teal-500" placeholder="0.00" />
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Daily Sleep (Hours)</label>
                        <input type="number" name="sleep" min="0" max="24" required
                               class="w-full rounded-xl border-gray-200 focus:border-teal-500 focus:ring-teal-500" placeholder="7" />
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Mood Description (1-5)</label>
                        <div class="flex justify-between items-center bg-slate-50 p-3 rounded-xl">
                            @for ($i = 1; $i <= 5; $i++)
                                <label class="flex flex-col items-center cursor-pointer">
                                    <input type="radio" name="mood" value="{{ $i }}" class="text-teal-600 focus:ring-teal-500" {{ $i == 3 ? 'checked' : '' }}>
                                    <span class="text-xs mt-1 text-gray-500">{{ $i }}</span>
                                </label>
                            @endfor
                        </div>
                    </div>
                </div>

                <!-- Psychological Data -->
                <div class="space-y-6">
                    <h3 class="text-sm font-black text-slate-400 uppercase tracking-widest">Self-Assessment</h3>
                    
                    <div>
                        <div class="flex justify-between mb-2">
                            <label class="text-xs font-bold text-gray-500 uppercase">Stress Level</label>
                            <span id="stress-val" class="text-xs font-bold text-teal-600">5/10</span>
                        </div>
                        <input type="range" name="stress" min="0" max="10" value="5"
                               class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-teal-600" 
                               oninput="document.getElementById('stress-val').innerText = this.value + '/10'" />
                    </div>

                    <div>
                        <div class="flex justify-between mb-2">
                            <label class="text-xs font-bold text-gray-500 uppercase">Anxiety Score</label>
                            <span id="anxiety-val" class="text-xs font-bold text-teal-600">5/10</span>
                        </div>
                        <input type="range" name="anxiety" min="0" max="10" value="5"
                               class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-teal-600"
                               oninput="document.getElementById('anxiety-val').innerText = this.value + '/10'" />
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Daily Reflection</label>
                        <textarea name="reflection" rows="4" placeholder="How was your day? Write a short summary..."
                                  class="w-full rounded-xl border-gray-200 focus:border-teal-500 focus:ring-teal-500 text-sm"></textarea>
                    </div>
                </div>
            </div>

            <div class="pt-6">
                <button type="submit"
                        class="w-full py-4 bg-gradient-to-r from-teal-600 to-blue-600 hover:from-teal-700 hover:to-blue-700 text-white font-extrabold rounded-xl shadow-lg transform hover:scale-[1.01] transition-all">
                    Run AI Analysis <i class="fas fa-magic ml-2"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Auto-fill logic for Admin/Teachers
    document.getElementById('student_id')?.addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];
        if (selected.value) {
            document.getElementById('age').value = selected.getAttribute('data-age');
        }
    });
</script>
@endsection
