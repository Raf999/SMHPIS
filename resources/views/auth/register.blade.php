@extends('layouts.guest')

@section('content')
<div class="min-h-screen bg-gray-50 bg-pattern flex items-center justify-center relative overflow-hidden p-6">
    <!-- Decorative background elements -->
    <div class="absolute top-[-10%] right-[-10%] w-96 h-96 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
    <div class="absolute bottom-[-10%] left-[-10%] w-96 h-96 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse" style="animation-delay: 2s;"></div>

    <div class="relative z-10 w-full max-w-[1000px] bg-white/80 backdrop-blur-xl rounded-[3rem] shadow-2xl shadow-blue-500/10 p-12 sm:p-16 border border-white/50 overflow-hidden">
        <div class="mb-12 text-center">
            <a href="/" class="inline-flex items-center text-xs font-black uppercase tracking-widest text-gray-400 hover:text-blue-600 transition-colors mb-8 group">
                <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i>
                Back to Home
            </a>
            <h2 class="text-3xl font-bold text-slate-900 mb-2 tracking-tight">SMHPIS</h2>
            <p class="text-slate-500 font-medium">Create your account to start tracking your wellbeing.</p>
        </div>

        @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-5 rounded-2xl mb-10">
                <ul class="list-disc list-inside text-sm font-bold">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="/register" class="space-y-12">
            @csrf

            <!-- Role Selection -->
            <div class="flex justify-center mb-10">
                <div class="inline-flex p-1.5 bg-gray-100 rounded-2xl">
                    <button type="button" onclick="setRole('student')" id="btn-student" class="px-8 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition-all role-btn bg-white shadow-sm text-blue-600">I am a Student</button>
                    <button type="button" onclick="setRole('teacher')" id="btn-teacher" class="px-8 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition-all role-btn text-gray-400 hover:text-gray-600">I am Faculty</button>
                </div>
                <input type="hidden" name="role" id="role_input" value="student">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <!-- Left Side: Basic Info -->
                <div class="space-y-6">
                    <h3 class="text-xs font-black text-gray-300 uppercase tracking-[0.2em] mb-6 flex items-center">
                        <span class="h-1 w-6 bg-blue-500 mr-3 rounded-full"></span>
                        Login Credentials
                    </h3>
                    
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 ml-1">Full Name</label>
                        <input type="text" name="name" required value="{{ old('name') }}"
                               class="w-full h-14 px-6 bg-gray-50 rounded-2xl border-2 border-gray-100 focus:border-blue-500 focus:bg-white focus:ring-0 transition-all font-bold text-gray-900"
                               placeholder="John Doe">
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 ml-1">Email Address</label>
                        <input type="email" name="email" required value="{{ old('email') }}"
                               class="w-full h-14 px-6 bg-gray-50 rounded-2xl border-2 border-gray-100 focus:border-blue-500 focus:bg-white focus:ring-0 transition-all font-bold text-gray-900"
                               placeholder="john@university.edu">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 ml-1">Password</label>
                            <input type="password" name="password" required
                                   class="w-full h-14 px-6 bg-gray-50 rounded-2xl border-2 border-gray-100 focus:border-blue-500 focus:bg-white focus:ring-0 transition-all font-bold text-gray-900"
                                   placeholder="••••••••">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 ml-1">Confirm</label>
                            <input type="password" name="password_confirmation" required
                                   class="w-full h-14 px-6 bg-gray-50 rounded-2xl border-2 border-gray-100 focus:border-blue-500 focus:bg-white focus:ring-0 transition-all font-bold text-gray-900"
                                   placeholder="••••••••">
                        </div>
                    </div>
                </div>

                <!-- Right Side: Profile Info -->
                <div class="space-y-6">
                    <h3 class="text-xs font-black text-gray-300 uppercase tracking-[0.2em] mb-6 flex items-center">
                        <span class="h-1 w-6 bg-purple-500 mr-3 rounded-full"></span>
                        Profile Details
                    </h3>

                    <!-- Student Fields -->
                    <div id="student_fields" class="space-y-6">
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 ml-1">Student ID</label>
                            <input type="text" name="student_id_number" value="{{ old('student_id_number') }}"
                                   class="w-full h-14 px-6 bg-gray-50 rounded-2xl border-2 border-gray-100 focus:border-blue-500 focus:bg-white focus:ring-0 transition-all font-bold text-gray-900"
                                   placeholder="e.g. 2024-001">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 ml-1">Age</label>
                                <input type="number" name="age" value="{{ old('age') }}"
                                       class="w-full h-14 px-6 bg-gray-50 rounded-2xl border-2 border-gray-100 focus:border-blue-500 focus:bg-white focus:ring-0 transition-all font-bold text-gray-900">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 ml-1">Level</label>
                                <input type="text" name="level" value="{{ old('level') }}"
                                       class="w-full h-14 px-6 bg-gray-50 rounded-2xl border-2 border-gray-100 focus:border-blue-500 focus:bg-white focus:ring-0 transition-all font-bold text-gray-900"
                                       placeholder="300">
                            </div>
                        </div>
                    </div>

                    <!-- Teacher Fields -->
                    <div id="teacher_fields" class="space-y-6 hidden">
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 ml-1">Staff ID</label>
                            <input type="text" name="staff_id" value="{{ old('staff_id') }}"
                                   class="w-full h-14 px-6 bg-gray-50 rounded-2xl border-2 border-gray-100 focus:border-blue-500 focus:bg-white focus:ring-0 transition-all font-bold text-gray-900"
                                   placeholder="FAC-2024">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 ml-1">Specialization</label>
                            <input type="text" name="specialization" value="{{ old('specialization') }}"
                                   class="w-full h-14 px-6 bg-gray-50 rounded-2xl border-2 border-gray-100 focus:border-blue-500 focus:bg-white focus:ring-0 transition-all font-bold text-gray-900"
                                   placeholder="Counseling Psychology">
                        </div>
                    </div>

                    <!-- Photo Upload -->
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 ml-1">Profile Photo</label>
                        <div class="flex items-center space-x-6 bg-gray-50 p-4 rounded-2xl border-2 border-gray-100 border-dashed hover:border-blue-500 transition-colors cursor-pointer group relative">
                            <div class="h-16 w-16 bg-white rounded-xl flex items-center justify-center text-gray-300 shadow-sm overflow-hidden relative">
                                <i class="fas fa-camera text-xl group-hover:scale-110 transition-transform"></i>
                                <img id="register_preview" class="absolute inset-0 w-full h-full object-cover hidden">
                            </div>
                            <div class="flex-1">
                                <p class="text-[10px] font-bold text-gray-400 uppercase leading-tight">Upload & Crop<br><span class="text-blue-500">JPG or PNG</span></p>
                            </div>
                            <input type="file" id="file_input" class="absolute inset-0 opacity-0 cursor-pointer" accept="image/*" onchange="initCropper(this)">
                        </div>
                        <input type="hidden" name="cropped_image" id="cropped_image_input">
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 ml-1">Department</label>
                        <input type="text" name="department" value="{{ old('department') }}"
                               class="w-full h-14 px-6 bg-gray-50 rounded-2xl border-2 border-gray-100 focus:border-blue-500 focus:bg-white focus:ring-0 transition-all font-bold text-gray-900"
                               placeholder="Computer Science">
                    </div>
                </div>
            </div>

            <!-- Cropping Modal -->
            <div id="cropper_modal" class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-slate-900/90 backdrop-blur-sm p-4">
                <div class="bg-white w-full max-w-2xl rounded-[3rem] overflow-hidden shadow-2xl">
                    <div class="p-8 border-b border-gray-50 flex justify-between items-center">
                        <h3 class="text-xl font-black text-gray-900 uppercase tracking-tight">Adjust Photo</h3>
                        <button type="button" onclick="closeCropper()" class="text-gray-400 hover:text-gray-600"><i class="fas fa-times text-xl"></i></button>
                    </div>
                    <div class="p-8">
                        <div class="flex space-x-3 mb-6">
                            <button type="button" id="ratio_square" onclick="setRatio(1)" class="px-6 py-2 bg-slate-900 text-white text-[10px] font-black uppercase tracking-widest rounded-xl transition-all">Square (1:1)</button>
                            <button type="button" id="ratio_free" onclick="setRatio(NaN)" class="px-6 py-2 bg-gray-100 text-gray-400 text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-gray-200 transition-all">Flexible</button>
                        </div>
                        <div class="max-h-[50vh] overflow-hidden rounded-2xl bg-gray-100">
                            <img id="cropper_image" class="max-w-full">
                        </div>
                    </div>
                    <div class="p-8 bg-gray-50 flex justify-end space-x-4">
                        <button type="button" onclick="closeCropper()" class="px-8 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400">Discard</button>
                        <button type="button" onclick="applyCrop()" class="px-10 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white text-[10px] font-black uppercase tracking-widest rounded-2xl shadow-lg">Apply</button>
                    </div>
                </div>
            </div>

            <div class="flex justify-center pt-6">
                <button type="submit" class="w-full md:w-[400px] h-16 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-2xl shadow-xl shadow-blue-500/20 hover:-translate-y-0.5 transition-all uppercase tracking-widest text-xs">
                    Create My Account
                </button>
            </div>
        </form>

        <div class="mt-12 text-center border-t border-gray-50 pt-10">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">
                Already have an account? 
                <a href="{{ route('login') }}" class="text-blue-600 hover:text-purple-600 ml-2 transition-colors">Sign in here</a>
            </p>
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
        const canvas = cropper.getCroppedCanvas({ width: 500, height: 500 });
        const dataUrl = canvas.toDataURL('image/jpeg');
        document.getElementById('register_preview').src = dataUrl;
        document.getElementById('register_preview').classList.remove('hidden');
        document.getElementById('cropped_image_input').value = dataUrl;
        document.getElementById('cropper_modal').classList.add('hidden');
    }

    function setRole(role) {
        document.getElementById('role_input').value = role;
        
        const isStudent = role === 'student';
        document.getElementById('student_fields').classList.toggle('hidden', !isStudent);
        document.getElementById('teacher_fields').classList.toggle('hidden', isStudent);
        
        // Toggle buttons
        const btnS = document.getElementById('btn-student');
        const btnT = document.getElementById('btn-teacher');
        
        if(isStudent) {
            btnS.classList.add('bg-white', 'shadow-sm', 'text-blue-600');
            btnS.classList.remove('text-gray-400', 'hover:text-gray-600');
            btnT.classList.remove('bg-white', 'shadow-sm', 'text-blue-600');
            btnT.classList.add('text-gray-400', 'hover:text-gray-600');
        } else {
            btnT.classList.add('bg-white', 'shadow-sm', 'text-blue-600');
            btnT.classList.remove('text-gray-400', 'hover:text-gray-600');
            btnS.classList.remove('bg-white', 'shadow-sm', 'text-blue-600');
            btnS.classList.add('text-gray-400', 'hover:text-gray-600');
        }
    }
</script>
@endsection
