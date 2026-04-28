@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-10">
        <div>
            <h1 class="text-4xl font-black text-gray-900 tracking-tight">Onboard Member</h1>
            <p class="text-gray-400 font-medium mt-1">Provision new system access credentials</p>
        </div>
    </div>

    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
        @csrf
        <input type="hidden" name="cropped_image" id="cropped_image_input">
        
        <!-- Cropping Modal -->
        <div id="cropper_modal" class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-slate-900/90 backdrop-blur-sm p-4">
            <div class="bg-white w-full max-w-2xl rounded-[3rem] overflow-hidden shadow-2xl">
                <div class="p-8 border-b border-gray-50 flex justify-between items-center">
                    <h3 class="text-xl font-black text-gray-900 uppercase tracking-tight">Adjust Your Profile Photo</h3>
                    <button type="button" onclick="closeCropper()" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times text-xl"></i></button>
                </div>
                <div class="p-8">
                    <!-- Ratio Selectors -->
                    <div class="flex space-x-3 mb-6">
                        <button type="button" id="ratio_square" onclick="setRatio(1)" class="px-6 py-2 bg-slate-900 text-white text-[10px] font-black uppercase tracking-widest rounded-xl transition-all">Square (1:1)</button>
                        <button type="button" id="ratio_free" onclick="setRatio(NaN)" class="px-6 py-2 bg-gray-100 text-gray-400 text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-gray-200 transition-all">Flexible</button>
                    </div>
                    
                    <div class="max-h-[50vh] overflow-hidden rounded-2xl bg-dashboard-bg">
                        <img id="cropper_image" class="max-w-full">
                    </div>
                </div>
                <div class="p-8 bg-gray-50 flex justify-end space-x-4">
                    <button type="button" onclick="closeCropper()" class="px-8 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-gray-600 transition-colors">Discard</button>
                    <button type="button" onclick="applyCrop()" class="px-10 py-4 bg-gradient-to-r from-accent-blue to-accent-purple text-white text-[10px] font-black uppercase tracking-widest rounded-2xl shadow-lg shadow-blue-500/20 hover:scale-105 transition-transform">Apply Crop</button>
                </div>
            </div>
        </div>
        
        <!-- Section: Credentials -->
        <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-gray-50">
            <h3 class="text-xs font-black text-gray-300 uppercase tracking-widest mb-8 flex items-center">
                <span class="h-1 w-8 bg-accent-teal mr-3 rounded-full"></span>
                Account Security
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Profile Photo</label>
                    <div class="flex items-center space-x-6">
                        <div class="h-24 w-24 bg-dashboard-bg rounded-[2rem] border-2 border-dashed border-gray-200 flex items-center justify-center text-gray-300 relative overflow-hidden group hover:border-accent-teal transition-colors">
                            <i class="fas fa-camera text-2xl group-hover:scale-110 transition-transform"></i>
                            <input type="file" id="file_input" class="absolute inset-0 opacity-0 cursor-pointer" accept="image/*" onchange="initCropper(this)">
                            <img id="image_preview" class="absolute inset-0 w-full h-full object-cover hidden">
                        </div>
                        <div class="text-[10px] font-bold text-gray-400 uppercase leading-relaxed">
                            Click to upload & crop<br>JPG, PNG (Max 2MB)
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Full Name</label>
                    <input type="text" name="name" required class="w-full h-14 px-6 bg-dashboard-bg rounded-2xl border-none focus:ring-2 focus:ring-accent-teal font-bold text-gray-900" placeholder="e.g. John Doe">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Email Address</label>
                    <input type="email" name="email" required class="w-full h-14 px-6 bg-dashboard-bg rounded-2xl border-none focus:ring-2 focus:ring-accent-teal font-bold text-gray-900" placeholder="john@university.edu">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Password</label>
                    <input type="password" name="password" required class="w-full h-14 px-6 bg-dashboard-bg rounded-2xl border-none focus:ring-2 focus:ring-accent-teal font-bold text-gray-900">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Member Role</label>
                    <select name="role" id="role_select" required class="w-full h-14 px-6 bg-dashboard-bg rounded-2xl border-none focus:ring-2 focus:ring-accent-teal font-bold text-gray-900 appearance-none">
                        <option value="student">Student</option>
                        @if(Auth::user()->isAdmin())
                            <option value="teacher">Faculty / Teacher</option>
                        @endif
                    </select>
                </div>
            </div>
        </div>

        <!-- Section: Profile Details -->
        <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-gray-50">
            <h3 class="text-xs font-black text-gray-300 uppercase tracking-widest mb-8 flex items-center">
                <span class="h-1 w-8 bg-accent-orange mr-3 rounded-full"></span>
                Profile Specifications
            </h3>

            <!-- Student Only -->
            <div id="student_specific_fields" class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Student ID Number</label>
                    <input type="text" name="student_id_number" class="w-full h-14 px-6 bg-dashboard-bg rounded-2xl border-none focus:ring-2 focus:ring-accent-teal font-bold text-gray-900">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Date of Birth</label>
                    <input type="date" name="date_of_birth" class="w-full h-14 px-6 bg-dashboard-bg rounded-2xl border-none focus:ring-2 focus:ring-accent-teal font-bold text-gray-900">
                </div>
            </div>

            <!-- Teacher Only -->
            <div id="teacher_specific_fields" class="hidden grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Staff ID</label>
                    <input type="text" name="staff_id" class="w-full h-14 px-6 bg-dashboard-bg rounded-2xl border-none focus:ring-2 focus:ring-accent-teal font-bold text-gray-900">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Gender</label>
                    <select name="gender" class="w-full h-14 px-6 bg-dashboard-bg rounded-2xl border-none focus:ring-2 focus:ring-accent-teal font-bold text-gray-900">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
            </div>

            <!-- Shared: Department & Courses -->
            <div class="space-y-8">
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Primary Department</label>
                    @if(Auth::user()->isTeacher())
                        <div class="h-14 px-6 bg-dashboard-bg rounded-2xl flex items-center border-2 border-accent-teal/20">
                            @if($departments->first())
                                <span class="text-accent-teal font-black uppercase tracking-widest text-xs">{{ $departments->first()->name }}</span>
                                <input type="hidden" name="department_id" id="dept_select" value="{{ $teacherDeptId }}">
                            @else
                                <span class="text-accent-orange font-black uppercase tracking-widest text-xs">No Department Assigned</span>
                                <input type="hidden" name="department_id" id="dept_select" value="">
                            @endif
                        </div>
                    @else
                        <select name="department_id" id="dept_select" required class="w-full h-14 px-6 bg-dashboard-bg rounded-2xl border-none focus:ring-2 focus:ring-accent-teal font-bold text-gray-900">
                            <option value="">Select Department</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Course Enrollments</label>
                    <div id="course_grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-8 bg-dashboard-bg rounded-[2.5rem]">
                        <p class="text-gray-400 text-xs italic font-bold">Please select a department to see available courses</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end space-x-4">
            <a href="{{ route('users.index') }}" class="h-16 px-10 flex items-center justify-center text-gray-400 font-black uppercase tracking-widest text-[10px]">Cancel</a>
            <button type="submit" class="h-16 px-12 bg-slate-900 text-white font-black rounded-2xl shadow-xl hover:scale-105 transition-transform uppercase tracking-widest text-[10px]">Complete Enrollment</button>
        </div>
    </form>
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
                
                if (cropper) cropper.destroy();
                
                cropper = new Cropper(image, {
                    aspectRatio: 1,
                    viewMode: 1,
                    background: false,
                    responsive: true
                });
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function setRatio(ratio) {
        if (cropper) {
            cropper.setAspectRatio(ratio);
            
            // Toggle button styles
            const btnSquare = document.getElementById('ratio_square');
            const btnFree = document.getElementById('ratio_free');
            
            if (isNaN(ratio)) {
                btnFree.className = 'px-6 py-2 bg-slate-900 text-white text-[10px] font-black uppercase tracking-widest rounded-xl transition-all';
                btnSquare.className = 'px-6 py-2 bg-gray-100 text-gray-400 text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-gray-200 transition-all';
            } else {
                btnSquare.className = 'px-6 py-2 bg-slate-900 text-white text-[10px] font-black uppercase tracking-widest rounded-xl transition-all';
                btnFree.className = 'px-6 py-2 bg-gray-100 text-gray-400 text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-gray-200 transition-all';
            }
        }
    }

    function closeCropper() {
        document.getElementById('cropper_modal').classList.add('hidden');
        if (cropper) cropper.destroy();
        document.getElementById('file_input').value = '';
    }

    function applyCrop() {
        const canvas = cropper.getCroppedCanvas({
            width: 500,
            height: 500
        });

        const dataUrl = canvas.toDataURL('image/jpeg');
        document.getElementById('image_preview').src = dataUrl;
        document.getElementById('image_preview').classList.remove('hidden');
        
        document.getElementById('cropped_image_input').value = dataUrl;
        document.getElementById('cropper_modal').classList.add('hidden');
    }

    const departments = @json($departments);

    function loadCourses(deptId) {
        const grid = document.getElementById('course_grid');
        grid.innerHTML = '';

        if (!deptId) {
            grid.innerHTML = '<p class="text-gray-400 text-xs italic font-bold">Please select a department to see available courses</p>';
            return;
        }

        const dept = departments.find(d => d.id == deptId);
        if (dept && dept.courses.length > 0) {
            dept.courses.forEach(course => {
                const item = document.createElement('label');
                item.className = 'flex items-center p-5 bg-white rounded-2xl shadow-sm border border-gray-50 cursor-pointer hover:border-accent-teal transition-colors group';
                item.innerHTML = `
                    <input type="checkbox" name="courses[]" value="${course.id}" class="h-5 w-5 text-accent-teal border-none bg-dashboard-bg rounded-lg focus:ring-0">
                    <div class="ml-4">
                        <p class="text-[10px] font-black text-gray-900 uppercase tracking-tight">${course.name}</p>
                        <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mt-0.5">${course.code}</p>
                    </div>
                `;
                grid.appendChild(item);
            });
        } else {
            grid.innerHTML = '<p class="text-gray-400 text-xs italic font-bold">No courses assigned to this department yet</p>';
        }
    }

    document.getElementById('role_select').addEventListener('change', function() {
        const isStudent = this.value === 'student';
        document.getElementById('student_specific_fields').classList.toggle('hidden', !isStudent);
        document.getElementById('teacher_specific_fields').classList.toggle('hidden', isStudent);
    });

    const deptSelect = document.getElementById('dept_select');
    if (deptSelect.tagName === 'SELECT') {
        deptSelect.addEventListener('change', function() {
            loadCourses(this.value);
        });
    } else {
        // It's a hidden input for teachers, auto-load on page load
        window.addEventListener('DOMContentLoaded', () => {
            loadCourses(deptSelect.value);
        });
    }
</script>
@endsection
