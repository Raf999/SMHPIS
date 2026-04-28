@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">

    <div class="page-header">
        <h1 class="page-title">Account settings</h1>
        <p class="page-subtitle">Manage your personal information and security.</p>
    </div>

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-5">
        @csrf
        <input type="hidden" name="cropped_image" id="cropped_image_input">

        {{-- Profile photo --}}
        <div class="card p-6">
            <h2 class="text-sm font-semibold text-slate-900 mb-4">Profile photo</h2>
            <div class="flex items-center gap-5">
                <div class="relative group cursor-pointer">
                    <div class="h-16 w-16 rounded-xl overflow-hidden bg-blue-100 flex items-center justify-center">
                        @if($user->profile_image_url)
                            <img id="image_preview" src="{{ $user->profile_image_url }}" class="h-full w-full object-cover">
                        @else
                            <span id="initial_display" class="text-lg font-semibold text-blue-700">{{ substr($user->name, 0, 1) }}</span>
                            <img id="image_preview" class="h-full w-full object-cover hidden">
                        @endif
                    </div>
                    <label class="absolute inset-0 bg-black/30 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer rounded-xl">
                        <i class="fas fa-camera text-white text-sm"></i>
                        <input type="file" id="file_input" class="hidden" accept="image/*" onchange="initCropper(this)">
                    </label>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-800">{{ $user->name }}</p>
                    <p class="text-xs text-slate-400 mt-0.5 capitalize">{{ $user->role }}</p>
                    <p class="text-xs text-slate-400 mt-2">Hover the photo to change it. JPG or PNG, max 2MB.</p>
                </div>
            </div>
        </div>

        {{-- Personal info --}}
        <div class="card p-6 space-y-5">
            <h2 class="text-sm font-semibold text-slate-900">Personal information</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="form-label">Full name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="form-input">
                </div>
                <div>
                    <label class="form-label">Email address</label>
                    <input type="email" value="{{ $user->email }}" disabled
                           class="form-input bg-slate-50 text-slate-400 cursor-not-allowed">
                    <p class="text-[11px] text-slate-400 mt-1">Email cannot be changed</p>
                </div>
            </div>

            <div class="border-t border-slate-100 pt-5">
                <h3 class="text-sm font-medium text-slate-700 mb-4">Change password</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">New password</label>
                        <input type="password" name="password" class="form-input" placeholder="••••••••">
                    </div>
                    <div>
                        <label class="form-label">Confirm password</label>
                        <input type="password" name="password_confirmation" class="form-input" placeholder="••••••••">
                    </div>
                </div>
                <p class="text-xs text-slate-400 mt-2">Leave empty to keep your current password.</p>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="btn-primary px-6 py-2.5">Save changes</button>
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
        const initial = document.getElementById('initial_display');
        if (initial) initial.classList.add('hidden');
        document.getElementById('cropped_image_input').value = dataUrl;
        const modal = document.getElementById('cropper_modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
@endsection
