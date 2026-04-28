@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-12">
    <div class="mb-12">
        <h1 class="text-4xl font-black text-gray-900 tracking-tight">Account Settings</h1>
        <p class="text-gray-400 font-medium mt-1">Manage your personal information and profile appearance</p>
    </div>

    @if(session('status'))
        <div class="mb-8 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 font-bold rounded-r-xl">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-12">
        @csrf
        <input type="hidden" name="cropped_image" id="cropped_image_input">
        
        <!-- Profile Picture Section -->
        <div class="bg-white rounded-[3rem] p-10 shadow-sm border border-gray-50 flex flex-col md:flex-row items-center space-y-6 md:space-y-0 md:space-x-10">
            <div class="relative group">
                <div class="h-32 w-32 bg-gradient-to-br from-teal-400 to-blue-400 rounded-[2.5rem] flex items-center justify-center text-white text-3xl font-black shadow-2xl overflow-hidden transition-transform group-hover:scale-105">
                    @if($user->profile_image)
                        <img id="image_preview" src="{{ Storage::disk('public')->url($user->profile_image) }}" class="h-full w-full object-cover">
                    @else
                        <div id="initial_display" class="flex items-center justify-center h-full w-full">{{ substr($user->name, 0, 1) }}</div>
                        <img id="image_preview" class="h-full w-full object-cover hidden">
                    @endif
                </div>
                <label class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer rounded-[2.5rem]">
                    <i class="fas fa-camera text-white text-xl"></i>
                    <input type="file" id="file_input" class="hidden" accept="image/*" onchange="initCropper(this)">
                </label>
            </div>
            <div class="flex-1 text-center md:text-left">
                <h4 class="text-xl font-black text-gray-900 uppercase tracking-tight mb-2">Profile Photo</h4>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] leading-relaxed">
                    Click the photo to upload and crop.<br>
                    Standard square format (1:1) is applied automatically.
                </p>
            </div>
        </div>

        <!-- Cropping Modal -->
        <div id="cropper_modal" class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-slate-900/90 backdrop-blur-sm p-4">
            <div class="bg-white w-full max-w-2xl rounded-[3rem] overflow-hidden shadow-2xl">
                <div class="p-8 border-b border-gray-50 flex justify-between items-center">
                    <h3 class="text-xl font-black text-gray-900 uppercase tracking-tight">Adjust Your Photo</h3>
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

        <!-- Personal Info Section -->
        <div class="bg-white rounded-[3rem] p-10 shadow-sm border border-gray-50 space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 px-1">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full h-14 px-6 bg-dashboard-bg rounded-2xl border-none focus:ring-2 focus:ring-accent-teal font-bold text-gray-900 transition-all">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 px-1">Email Address</label>
                    <input type="email" value="{{ $user->email }}" disabled class="w-full h-14 px-6 bg-gray-50 rounded-2xl border-none font-bold text-gray-400 cursor-not-allowed">
                    <p class="text-[9px] font-bold text-gray-300 mt-2 ml-1">Email cannot be changed</p>
                </div>
            </div>

            <hr class="border-gray-50">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 px-1">New Password</label>
                    <input type="password" name="password" class="w-full h-14 px-6 bg-dashboard-bg rounded-2xl border-none focus:ring-2 focus:ring-accent-teal font-bold text-gray-900 transition-all" placeholder="••••••••">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3 px-1">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="w-full h-14 px-6 bg-dashboard-bg rounded-2xl border-none focus:ring-2 focus:ring-accent-teal font-bold text-gray-900 transition-all" placeholder="••••••••">
                </div>
            </div>
            <p class="text-[10px] font-bold text-gray-400 italic">Leave password fields empty to keep your current password</p>
        </div>

        <div class="flex justify-end pt-4">
            <button type="submit" class="h-16 px-12 bg-slate-900 text-white font-black rounded-2xl shadow-xl hover:scale-105 active:scale-95 transition-all uppercase tracking-widest text-[10px]">
                Save Changes
            </button>
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
        if (document.getElementById('initial_display')) {
            document.getElementById('initial_display').classList.add('hidden');
        }
        
        document.getElementById('cropped_image_input').value = dataUrl;
        document.getElementById('cropper_modal').classList.add('hidden');
    }
</script>
@endsection
