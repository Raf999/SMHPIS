@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">

    <div class="page-header">
        <h1 class="page-title">Onboard member</h1>
        <p class="page-subtitle">Provision new system access credentials.</p>
    </div>

    <input type="hidden" name="cropped_image" id="cropped_image_input">

    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf
        <input type="hidden" name="cropped_image" id="cropped_image_input_form">

        {{-- Account credentials --}}
        <div class="card p-6 space-y-5">
            <h2 class="text-sm font-semibold text-slate-900">Account credentials</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                {{-- Photo --}}
                <div class="md:col-span-2">
                    <label class="form-label">Profile photo <span class="text-slate-400 font-normal">(optional)</span></label>
                    <div class="flex items-center gap-4">
                        <div class="h-14 w-14 rounded-xl bg-slate-100 border-2 border-dashed border-slate-200 flex items-center justify-center relative overflow-hidden group hover:border-blue-400 transition-colors cursor-pointer">
                            <i class="fas fa-camera text-slate-400 text-sm group-hover:text-blue-500 transition-colors" id="camera-icon"></i>
                            <input type="file" id="file_input" class="absolute inset-0 opacity-0 cursor-pointer" accept="image/*" onchange="initCropper(this)">
                            <img id="image_preview" class="absolute inset-0 w-full h-full object-cover hidden rounded-xl">
                        </div>
                        <p class="text-xs text-slate-400">Click to upload and crop. JPG or PNG, max 2MB.</p>
                    </div>
                </div>

                <div>
                    <label class="form-label">Full name</label>
                    <input type="text" name="name" required class="form-input" placeholder="John Doe">
                </div>
                <div>
                    <label class="form-label">Email address</label>
                    <input type="email" name="email" required class="form-input" placeholder="john@university.edu">
                </div>
                <div>
                    <label class="form-label">Password</label>
                    <input type="password" name="password" required class="form-input">
                </div>
                <div>
                    <label class="form-label">Member role</label>
                    <select name="role" id="role_select" required class="form-select">
                        <option value="student">Student</option>
                        @if(Auth::user()->isAdmin())
                            <option value="teacher">Faculty / Teacher</option>
                        @endif
                    </select>
                </div>
            </div>
        </div>

        {{-- Profile details --}}
        <div class="card p-6 space-y-5">
            <h2 class="text-sm font-semibold text-slate-900">Profile details</h2>

            {{-- Student fields --}}
            <div id="student_specific_fields" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Student ID number</label>
                    <input type="text" name="student_id_number" class="form-input" placeholder="2024-001">
                </div>
                <div>
                    <label class="form-label">Date of birth</label>
                    <input type="date" name="date_of_birth" class="form-input">
                </div>
            </div>

            {{-- Teacher fields --}}
            <div id="teacher_specific_fields" class="hidden grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Staff ID</label>
                    <input type="text" name="staff_id" class="form-input" placeholder="FAC-2024">
                </div>
                <div>
                    <label class="form-label">Gender</label>
                    <select name="gender" class="form-select">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
            </div>

            {{-- Department --}}
            <div>
                <label class="form-label">Primary department</label>
                @if(Auth::user()->isTeacher())
                    <div class="form-input bg-slate-50 flex items-center text-slate-500">
                        @if($departments->first())
                            {{ $departments->first()->name }}
                            <input type="hidden" name="department_id" id="dept_select" value="{{ $teacherDeptId }}">
                        @else
                            No department assigned
                            <input type="hidden" name="department_id" id="dept_select" value="">
                        @endif
                    </div>
                @else
                    <select name="department_id" id="dept_select" required class="form-select">
                        <option value="">Select department…</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                        @endforeach
                    </select>
                @endif
            </div>

            {{-- Courses --}}
            <div>
                <label class="form-label">Course enrollments</label>
                <div id="course_grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 p-4 bg-slate-50 rounded-xl border border-slate-100">
                    <p class="text-xs text-slate-400 italic col-span-full">Select a department to see available courses.</p>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('users.index') }}" class="btn-secondary">Cancel</a>
            <button type="submit" class="btn-primary px-6">Complete enrollment</button>
        </div>

    </form>
</div>

{{-- Cropper modal --}}
<div id="cropper_modal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4">
    <div class="bg-white w-full max-w-lg rounded-2xl overflow-hidden shadow-xl">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-sm font-semibold text-slate-900">Crop photo</h3>
            <button type="button" onclick="closeCropper()" class="btn-ghost p-1.5"><i class="fas fa-times text-sm"></i></button>
        </div>
        <div class="p-6">
            <div class="flex gap-2 mb-4">
                <button type="button" id="ratio_square" onclick="setRatio(1)"
                        class="btn-secondary text-xs px-3 py-1.5 !bg-slate-900 !text-white !border-slate-900">Square (1:1)</button>
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
                : 'btn-secondary text-xs px-3 py-1.5 !bg-slate-900 !text-white !border-slate-900';
            document.getElementById('ratio_free').className = isNaN(ratio)
                ? 'btn-secondary text-xs px-3 py-1.5 !bg-slate-900 !text-white !border-slate-900'
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
        document.getElementById('image_preview').src = dataUrl;
        document.getElementById('image_preview').classList.remove('hidden');
        document.getElementById('camera-icon').classList.add('hidden');
        document.getElementById('cropped_image_input_form').value = dataUrl;
        const modal = document.getElementById('cropper_modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    const departments = @json($departments);

    function loadCourses(deptId) {
        const grid = document.getElementById('course_grid');
        grid.innerHTML = '';
        if (!deptId) {
            grid.innerHTML = '<p class="text-xs text-slate-400 italic col-span-full">Select a department to see available courses.</p>';
            return;
        }
        const dept = departments.find(d => d.id == deptId);
        if (dept && dept.courses.length > 0) {
            dept.courses.forEach(course => {
                const item = document.createElement('label');
                item.className = 'flex items-center gap-3 p-3 bg-white rounded-lg border border-slate-200 cursor-pointer hover:border-blue-400 transition-colors';
                item.innerHTML = `
                    <input type="checkbox" name="courses[]" value="${course.id}"
                           class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    <div>
                        <p class="text-xs font-medium text-slate-800">${course.name}</p>
                        <p class="text-[11px] text-slate-400">${course.code}</p>
                    </div>
                `;
                grid.appendChild(item);
            });
        } else {
            grid.innerHTML = '<p class="text-xs text-slate-400 italic col-span-full">No courses assigned to this department yet.</p>';
        }
    }

    document.getElementById('role_select').addEventListener('change', function() {
        const isStudent = this.value === 'student';
        document.getElementById('student_specific_fields').classList.toggle('hidden', !isStudent);
        document.getElementById('teacher_specific_fields').classList.toggle('hidden', isStudent);
    });

    const deptSelect = document.getElementById('dept_select');
    if (deptSelect.tagName === 'SELECT') {
        deptSelect.addEventListener('change', function() { loadCourses(this.value); });
    } else {
        window.addEventListener('DOMContentLoaded', () => { loadCourses(deptSelect.value); });
    }
</script>
@endsection
