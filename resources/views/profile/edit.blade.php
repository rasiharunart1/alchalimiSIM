@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto animate-fade-in-up">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-chalimi-900">Edit Profil saya</h2>
        <p class="text-chalimi-600">Perbarui informasi akun dan foto profil Anda.</p>
    </div>

    <div class="glass-panel p-8">
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Photo Section -->
            <div class="flex flex-col md:flex-row gap-8 items-start">
                <div class="w-full md:w-1/3 flex flex-col items-center gap-4">
                    <div class="relative group">
                        <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-white shadow-lg bg-chalimi-100">
                            @if(auth()->user()->photo)
                                <img src="{{ auth()->user()->photo_url }}" id="preview-image" class="w-full h-full object-cover">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=009b77&color=fff" id="preview-image" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <label for="photo_input" class="absolute bottom-0 right-0 bg-chalimi-600 text-white p-2 rounded-full cursor-pointer hover:bg-chalimi-700 shadow-md transition transform hover:scale-110">
                            <i class="fa-solid fa-camera"></i>
                        </label>
                        <input type="file" id="photo_input" name="photo" class="hidden" accept="image/*">
                        <input type="hidden" name="cropped_photo" id="cropped_photo">
                    </div>
                    <p class="text-xs text-chalimi-500 text-center">Klik ikon kamera untuk mengganti foto.</p>
                </div>

                <div class="w-full md:w-2/3 space-y-4">
                     <!-- Name -->
                    <div>
                        <label class="block text-sm font-medium text-chalimi-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full glass-input text-chalimi-900 bg-white/20 border-chalimi-200 focus:border-chalimi-500">
                        @error('name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-chalimi-700 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full glass-input text-chalimi-900 bg-white/20 border-chalimi-200 focus:border-chalimi-500">
                        @error('email') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="border-t border-chalimi-100 my-4 pt-4">
                        <h4 class="font-bold text-chalimi-800 mb-2">Ganti Password (Opsional)</h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-chalimi-700 mb-1">Password Baru</label>
                                <input type="password" name="password" class="w-full glass-input text-chalimi-900 bg-white/20 border-chalimi-200 focus:border-chalimi-500">
                                @error('password') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-chalimi-700 mb-1">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="w-full glass-input text-chalimi-900 bg-white/20 border-chalimi-200 focus:border-chalimi-500">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <button type="submit" class="btn-chalimi shadow-lg shadow-emerald-500/30">
                    💾 Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Crop -->
<div id="crop-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/80 backdrop-blur-sm">
    <div class="bg-white rounded-xl p-6 w-full max-w-lg mx-4">
        <h3 class="text-lg font-bold mb-4 text-chalimi-900">Sesuaikan Foto</h3>
        <div class="h-64 bg-gray-100 rounded-lg overflow-hidden mb-4 relative">
            <img id="image-to-crop" class="max-w-full">
        </div>
        <div class="flex justify-end gap-3 pt-4 border-t border-gray-100 mt-4">
            <button type="button" id="cancel-crop" class="px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-100 font-medium transition">
                Batal
            </button>
            <button type="button" id="crop-btn" class="btn-chalimi text-white shadow-lg bg-chalimi-600 hover:bg-chalimi-700 flex items-center gap-2">
                <i class="fa-solid fa-check"></i> Potong & Simpan
            </button>
        </div>
    </div>
</div>

<!-- Styles & Scripts for Cropper -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

<script>
    const photoInput = document.getElementById('photo_input');
    const cropModal = document.getElementById('crop-modal');
    const imageToCrop = document.getElementById('image-to-crop');
    const cropBtn = document.getElementById('crop-btn');
    const cancelCropBtn = document.getElementById('cancel-crop');
    const previewImage = document.getElementById('preview-image');
    const croppedPhotoInput = document.getElementById('cropped_photo');
    
    let cropper;

    photoInput.addEventListener('change', function(e) {
        const files = e.target.files;
        if (files && files.length > 0) {
            const file = files[0];
            const reader = new FileReader();
            
            reader.onload = function(e) {
                imageToCrop.src = e.target.result;
                cropModal.classList.remove('hidden');
                
                if (cropper) {
                    cropper.destroy();
                }
                
                cropper = new Cropper(imageToCrop, {
                    aspectRatio: 1,
                    viewMode: 1,
                });
            };
            
            reader.readAsDataURL(file);
        }
        // Reset input so same file selection triggers change again if cancelled
        this.value = null; 
    });

    cropBtn.addEventListener('click', function() {
        if (!cropper) return;

        const canvas = cropper.getCroppedCanvas({
            width: 300,
            height: 300,
        });

        const croppedDataUrl = canvas.toDataURL('image/jpeg');
        
        // Update preview
        previewImage.src = croppedDataUrl;
        
        // Build base64 for input
        croppedPhotoInput.value = croppedDataUrl;

        // Hide modal
        cropModal.classList.add('hidden');
    });

    cancelCropBtn.addEventListener('click', function() {
        cropModal.classList.add('hidden');
        if (cropper) {
            cropper.destroy();
        }
    });

    // Close modal on outside click
    cropModal.addEventListener('click', function(e) {
        if (e.target === cropModal) {
            cancelCropBtn.click();
        }
    });
</script>
@endsection
