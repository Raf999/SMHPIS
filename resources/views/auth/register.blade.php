@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex items-start justify-center py-10 px-4">
    <div class="w-full max-w-2xl">

        {{-- Header --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center gap-2.5 mb-5">
                <div class="h-8 w-8 bg-blue-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-brain text-white text-xs"></i>
                </div>
                <span class="text-sm font-semibold text-slate-900">SMHPIS</span>
            </div>
            <h1 class="text-2xl font-semibold text-slate-900">Create your account</h1>
            <p class="text-sm text-slate-500 mt-1">Start tracking your wellbeing today.</p>
        </div>

        {{-- Errors --}}
        @if($errors->any())
            <div class="alert-danger mb-6">
                <i class="fas fa-exclamation-circle text-red-500 text-sm shrink-0 mt-0.5"></i>
                <ul class="text-sm text-red-700 space-y-0.5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card-lg p-8">

            <form method="POST" action="/register" class="space-y-8">
                @csrf

                {{-- Role toggle --}}
                <div class="flex justify-center">
                    <div class="inline-flex p-1 bg-slate-100 rounded-lg gap-1">
                        <button type="button" onclick="setRole('student')" id="btn-student"
                                class="px-5 py-2 rounded-md text-sm font-medium transition-all bg-white text-slate-900 shadow-sm">
                            Student
                        </button>
                        <button type="button" onclick="setRole('teacher')" id="btn-teacher"
                                class="px-5 py-2 rounded-md text-sm font-medium transition-all text-slate-500 hover:text-slate-700">
                            Faculty
                        </button>
                    </div>
                    <input type="hidden" name="role" id="role_input" value="student">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    {{-- Left: Credentials --}}
                    <div class="space-y-4">
                        <p class="text-xs font-medium text-slate-400 uppercase tracking-wider mb-4">Login credentials</p>

                        <div>
                            <label class="form-label">Full name</label>
                            <input type="text" name="name" required value="{{ old('name') }}"
                                   class="form-input" placeholder="John Doe">
                        </div>
                        <div>
                            <label class="form-label">Email address</label>
                            <input type="email" name="email" required value="{{ old('email') }}"
                                   class="form-input" placeholder="john@university.edu">
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="form-label">Password</label>
                                <input type="password" name="password" required
                                       class="form-input" placeholder="••••••••">
                            </div>
                            <div>
                                <label class="form-label">Confirm</label>
                                <input type="password" name="password_confirmation" required
                                       class="form-input" placeholder="••••••••">
                            </div>
                        </div>
                    </div>

                    {{-- Right: Profile --}}
                    <div class="space-y-4">
                        <p class="text-xs font-medium text-slate-400 uppercase tracking-wider mb-4">Profile details</p>

                        {{-- Student fields --}}
                        <div id="student_fields" class="space-y-4">
                            <div>
                                <label class="form-label">Student ID</label>
                                <input type="text" name="student_id_number" value="{{ old('student_id_number') }}"
                                       class="form-input" placeholder="2024-001">
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="form-label">Age</label>
                                    <input type="number" name="age" value="{{ old('age') }}"
                                           class="form-input" min="16" max="60">
                                </div>
                                <div>
                                    <label class="form-label">Level</label>
                                    <input type="text" name="level" value="{{ old('level') }}"
                                           class="form-input" placeholder="300">
                                </div>
                            </div>
                        </div>

                        {{-- Teacher fields --}}
                        <div id="teacher_fields" class="space-y-4 hidden">
                            <div>
                                <label class="form-label">Staff ID</label>
                                <input type="text" name="staff_id" value="{{ old('staff_id') }}"
                                       class="form-input" placeholder="FAC-2024">
                            </div>
                            <div>
                                <label class="form-label">Specialization</label>
                                <input type="text" name="specialization" value="{{ old('specialization') }}"
                                       class="form-input" placeholder="Counseling Psychology">
                            </div>
                        </div>

                        <div>
                            <label class="form-label">Department</label>
                            <input type="text" name="department" value="{{ old('department') }}"
                                   class="form-input" placeholder="Computer Science">
                        </div>

                        {{-- Photo upload --}}
                        <div>
                            <label class="form-label">Profile photo <span class="text-slate-400 font-normal">(optional)</span></label>
                            <div class="flex items-center gap-4 p-3 border border-dashed border-slate-200 rounded-lg hover:border-blue-400 transition-colors cursor-pointer relative group">
                                <div class="h-12 w-12 rounded-lg bg-slate-100 flex items-center justify-center overflow-hidden shrink-0">
                                    <i class="fas fa-camera text-slate-400 text-sm group-hover:text-blue-500 transition-colors" id="camera-icon"></i>
                                    <img id="register_preview" class="absolute inset-0 w-full h-full object-cover hidden rounded-lg" style="position:relative;">
                                </div>
                                <span class="text-sm text-slate-400">Click to upload JPG or PNG</span>
                                <input type="file" id="file_input" class="absolute inset-0 opacity-0 cursor-pointer" accept="image/*" onchange="initCropper(this)">
                            </div>
                            <input type="hidden" name="cropped_image" id="cropped_image_input">
                        </div>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="btn-primary w-full h-10">
                        Create account
                    </button>
                </div>
            </form>
        </div>

        <p class="mt-6 text-center text-sm text-slate-500">
            Already have an account?
            <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 font-medium">Sign in</a>
        </p>
    </div>
</div>

{{-- Cropper modal --}}
<div id="cropper_modal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4">
    <div class="bg-white w-full max-w-lg rounded-2xl overflow-hidden shadow-xl">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-sm font-semibold text-slate-900">Crop photo</h3>
            <button type="button" onclick="closeCropper()" class="btn-ghost p-1.5">
                <i class="fas fa-times text-sm"></i>
            </button>
        </div>
        <div class="p-6">
            <div class="flex gap-2 mb-4">
                <button type="button" id="ratio_square" onclick="setRatio(1)"
                        class="btn-secondary text-xs px-3 py-1.5 bg-slate-900 text-white border-slate-900">Square (1:1)</button>
                <button type="button" id="ratio_free" onclick="setRatio(NaN)"
                        class="btn-secondary text-xs px-3 py-1.5">Flexible</button>
            </div>
            <div class="max-h-[50vh] overflow-hidden rounded-xl bg-slate-100">
                <img id="cropper_image" class="max-w-full">
            </div>
        </div>
        <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
            <button type="button" onclick="closeCropper()" class="btn-secondary text-xs">Discard</button>
            <button type="button" onclick="applyCrop()" class="btn-primary text-xs">Apply crop</button>
        </div>
    </div>
</div>

<script>
    let cropper;

    function initCropper(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const modal = document.getElementById('cropper_modal');
                const image = document.getElementById('cropper_image');
                image.src = e.target.result;
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                if (cropper) cropper.destroy();
                cropper = new Cropper(image, { aspectRatio: 1, viewMode: 1, background: false, responsive: true });
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function setRatio(ratio) {
        if (cropper) {
            cropper.setAspectRatio(ratio);
            document.getElementById('ratio_square').className = isNaN(ratio)
                ? 'btn-secondary text-xs px-3 py-1.5'
                : 'btn-secondary text-xs px-3 py-1.5 bg-slate-900 text-white border-slate-900';
            document.getElementById('ratio_free').className = isNaN(ratio)
                ? 'btn-secondary text-xs px-3 py-1.5 bg-slate-900 text-white border-slate-900'
                : 'btn-secondary text-xs px-3 py-1.5';
        }
    }

    function closeCropper() {
        const modal = document.getElementById('cropper_modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        if (cropper) cropper.destroy();
        document.getElementById('file_input').value = '';
    }

    function applyCrop() {
        const canvas = cropper.getCroppedCanvas({ width: 500, height: 500 });
        const dataUrl = canvas.toDataURL('image/jpeg');
        const preview = document.getElementById('register_preview');
        preview.src = dataUrl;
        preview.classList.remove('hidden');
        document.getElementById('camera-icon').classList.add('hidden');
        document.getElementById('cropped_image_input').value = dataUrl;
        const modal = document.getElementById('cropper_modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function setRole(role) {
        document.getElementById('role_input').value = role;
        const isStudent = role === 'student';
        document.getElementById('student_fields').classList.toggle('hidden', !isStudent);
        document.getElementById('teacher_fields').classList.toggle('hidden', isStudent);

        const btnS = document.getElementById('btn-student');
        const btnT = document.getElementById('btn-teacher');
        if (isStudent) {
            btnS.className = 'px-5 py-2 rounded-md text-sm font-medium transition-all bg-white text-slate-900 shadow-sm';
            btnT.className = 'px-5 py-2 rounded-md text-sm font-medium transition-all text-slate-500 hover:text-slate-700';
        } else {
            btnT.className = 'px-5 py-2 rounded-md text-sm font-medium transition-all bg-white text-slate-900 shadow-sm';
            btnS.className = 'px-5 py-2 rounded-md text-sm font-medium transition-all text-slate-500 hover:text-slate-700';
        }
    }
</script>
@endsection
