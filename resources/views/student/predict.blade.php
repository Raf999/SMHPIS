@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">

    <div class="page-header">
        <h1 class="page-title">New Mental Health Analysis</h1>
        <p class="page-subtitle">Complete the form below and our AI model will assess your wellbeing.</p>
    </div>

    @if($errors->any())
    <div class="alert-danger mb-6">
        <i class="fas fa-exclamation-circle text-red-500 text-sm shrink-0 mt-0.5"></i>
        <p class="text-sm text-red-700">{{ $errors->first() }}</p>
    </div>
    @endif

    <form action="{{ route('student.predict.submit') }}" method="POST">
        @csrf

        <div class="space-y-5">

            {{-- Student selector (admin/teacher) --}}
            @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
            <div class="card p-5">
                <h2 class="text-sm font-medium text-slate-700 mb-4">Select student</h2>
                <div>
                    <label class="form-label">Student</label>
                    <select name="student_id" id="student_id" required class="form-select">
                        <option value="">Choose a student…</option>
                        @foreach($students as $s)
                            <option value="{{ $s->id }}" data-age="{{ $s->age }}" data-gender="{{ $s->gender }}">
                                {{ $s->user->name }} ({{ $s->student_id_number }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- Personal metrics --}}
                <div class="card p-5 space-y-4">
                    <h2 class="text-sm font-medium text-slate-700">Personal metrics</h2>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="form-label">Age</label>
                            <input type="number" name="age" id="age" min="16" max="60" required
                                   class="form-input"
                                   value="{{ Auth::user()->isStudent() ? Auth::user()->studentProfile->age : '' }}"
                                   placeholder="22">
                        </div>
                        <div>
                            <label class="form-label">GPA</label>
                            <input type="number" step="0.01" name="gpa" min="0" max="4" required
                                   class="form-input" placeholder="3.50">
                        </div>
                    </div>

                    <div>
                        <label class="form-label">Daily sleep (hours)</label>
                        <input type="number" name="sleep" min="0" max="24" required
                               class="form-input" placeholder="7">
                    </div>

                    <div>
                        <label class="form-label">Mood (1 = very low · 5 = great)</label>
                        <div class="flex items-center justify-between gap-2 mt-1">
                            @for($i = 1; $i <= 5; $i++)
                            <label class="flex-1 flex flex-col items-center cursor-pointer">
                                <input type="radio" name="mood" value="{{ $i }}"
                                       class="sr-only peer" {{ $i == 3 ? 'checked' : '' }}>
                                <span class="w-full text-center py-2 rounded-lg border border-slate-200 text-sm font-medium text-slate-500
                                             peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-600
                                             hover:bg-slate-50 transition-colors cursor-pointer">
                                    {{ $i }}
                                </span>
                            </label>
                            @endfor
                        </div>
                    </div>
                </div>

                {{-- Self-assessment --}}
                <div class="card p-5 space-y-4">
                    <h2 class="text-sm font-medium text-slate-700">Self-assessment</h2>

                    <div>
                        <div class="flex justify-between mb-2">
                            <label class="form-label mb-0">Stress level</label>
                            <span id="stress-val" class="text-xs font-medium text-blue-600">5 / 10</span>
                        </div>
                        <input type="range" name="stress" min="0" max="10" value="5"
                               class="w-full h-1.5 bg-slate-200 rounded-full appearance-none accent-blue-600 cursor-pointer"
                               oninput="document.getElementById('stress-val').textContent = this.value + ' / 10'">
                        <div class="flex justify-between text-[11px] text-slate-400 mt-1"><span>0</span><span>10</span></div>
                    </div>

                    <div>
                        <div class="flex justify-between mb-2">
                            <label class="form-label mb-0">Anxiety score</label>
                            <span id="anxiety-val" class="text-xs font-medium text-blue-600">5 / 10</span>
                        </div>
                        <input type="range" name="anxiety" min="0" max="10" value="5"
                               class="w-full h-1.5 bg-slate-200 rounded-full appearance-none accent-blue-600 cursor-pointer"
                               oninput="document.getElementById('anxiety-val').textContent = this.value + ' / 10'">
                        <div class="flex justify-between text-[11px] text-slate-400 mt-1"><span>0</span><span>10</span></div>
                    </div>

                    <div>
                        <label class="form-label">Daily reflection <span class="text-slate-400 font-normal">(optional)</span></label>
                        <textarea name="reflection" rows="4" placeholder="How was your day? A short summary helps the AI give better advice…"
                                  class="form-textarea w-full"></textarea>
                    </div>
                </div>

            </div>

            <div class="flex justify-end">
                <button type="submit" class="btn-primary gap-2 px-6 py-2.5">
                    <i class="fas fa-microchip text-xs"></i>
                    Run AI analysis
                </button>
            </div>

        </div>
    </form>
</div>

<script>
    document.getElementById('student_id')?.addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];
        if (selected.value) {
            document.getElementById('age').value = selected.getAttribute('data-age');
        }
    });
</script>
@endsection
