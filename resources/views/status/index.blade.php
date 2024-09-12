<x-app-layout>
  <x-container>
    <h1 class="font-bold text-xl">Make a Status</h1>
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
    <x-status-card class="p-4 bg-white shadow-md rounded-lg">
      <form action="{{ route('status.store') }}" method="post" enctype="multipart/form-data" id="statusForm">
        @csrf
        <div class="flex flex-col gap-4">
          <div class="flex justify-between items-start">
            <div class="flex flex-col items-start">
              <label for="images" class="cursor-pointer px-4 py-2 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600 transition duration-200">
                Choose Images
              </label>
              <input type="file" name="images[]" id="images" multiple accept="image/*" class="hidden">
            </div>
            <div class="flex items-center space-x-3">
              <input type="checkbox" name="visibility" id="visibility" class="form-checkbox h-5 w-5 text-indigo-600 rounded focus:ring-indigo-500 border-gray-300 transition duration-150 ease-in-out">
              <label for="visibility" class="select-none font-medium text-gray-700 cursor-pointer">Keep   Private</label>
            </div>
          </div>
          <div>
            <label for="content" class="block mb-2">Content:</label>
            <textarea name="content" id="content" rows="4" class="w-full p-2 rounded-lg border-indigo-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 transition duration-200 resize-none"></textarea>
          </div>  
          <div id="imagePreviewContainer" class="mt-4 hidden">
            <h3 class="font-semibold mb-2">Image Preview:</h3>
            <div id="imagePreview" class="flex flex-wrap gap-2"></div>
          </div>
        </div>
        <div class="flex justify-end mt-4">
          <x-primary-button class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition duration-200">
            Send
          </x-primary-button>
        </div>
      </form>
    </x-status-card>
  </x-container>
</x-app-layout>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const imageInput = document.getElementById('images');
  const imagePreviewContainer = document.getElementById('imagePreviewContainer');
  const imagePreview = document.getElementById('imagePreview');
  let selectedFiles = []; // Array to store selected files

  // Create modal elements
  const modal = document.createElement('div');
  modal.classList.add('fixed', 'inset-0', 'bg-black', 'bg-opacity-50', 'flex', 'items-center', 'justify-center', 'z-50', 'hidden');
  const modalContent = document.createElement('div');
  modalContent.classList.add('bg-white', 'p-4', 'rounded-lg', 'max-w-[90vw]', 'max-h-[90vh]', 'w-auto', 'h-auto', 'flex', 'flex-col', 'items-center');
  const modalImage = document.createElement('img');
  modalImage.classList.add('max-w-full', 'max-h-[calc(90vh-100px)]', 'object-contain');
  const closeButton = document.createElement('button');
  closeButton.textContent = 'Close';
  closeButton.classList.add('mt-4', 'px-4', 'py-2', 'bg-red-500', 'text-white', 'rounded-lg', 'hover:bg-red-600', 'transition', 'duration-200');

  modalContent.appendChild(modalImage);
  modalContent.appendChild(closeButton);
  modal.appendChild(modalContent);
  document.body.appendChild(modal);

  function closeModal() {
    modal.classList.add('hidden');
  }

  closeButton.onclick = closeModal;

  // Close modal when clicking outside the image
  modal.addEventListener('click', function(event) {
    if (event.target === modal) {
      closeModal();
    }
  });

  imageInput.addEventListener('change', function(event) {
    const newFiles = Array.from(event.target.files);
    
    newFiles.forEach(file => {
      if (!selectedFiles.some(selectedFile => selectedFile.name === file.name)) {
        selectedFiles.push(file);
        createImagePreview(file);
      }
    });

    if (selectedFiles.length > 0) {
      imagePreviewContainer.classList.remove('hidden');
    }

    // Reset the file input
    event.target.value = '';
  });

  function createImagePreview(file) {
    const reader = new FileReader();

    reader.onload = function(e) {
      const div = document.createElement('div');
      div.classList.add('relative');

      const img = document.createElement('img');
      img.src = e.target.result;
      img.classList.add('w-24', 'h-24', 'object-cover', 'rounded-lg', 'cursor-pointer', 'border', 'border-indigo-600');
      
      // Add click event to show modal
      img.onclick = function() {
        modalImage.src = e.target.result;
        modal.classList.remove('hidden');
      };

      const removeButton = document.createElement('button');
      removeButton.innerHTML = '&times;';
      removeButton.classList.add('absolute', 'top-0', 'right-0', 'bg-red-500', 'text-white', 'rounded-full', 'w-5', 'h-5', 'flex', 'items-center', 'justify-center');
      removeButton.onclick = function() {
        div.remove();
        selectedFiles = selectedFiles.filter(selectedFile => selectedFile !== file);
        if (selectedFiles.length === 0) {
          imagePreviewContainer.classList.add('hidden');
        }
      };

      div.appendChild(img);
      div.appendChild(removeButton);
      imagePreview.appendChild(div);
    };

    reader.readAsDataURL(file);
  }

  // Handle form submission
  // document.getElementById('statusForm').addEventListener('submit', function(e) {
  //   e.preventDefault();
    
  //   const formData = new FormData(this);
    
  //   // Remove any existing file inputs
  //   formData.delete('images[]');
    
  //   // Append selected files to formData
  //   selectedFiles.forEach(file => {
  //     formData.append('images[]', file);
  //   });

  //   // Here you would typically send the formData to your server
  //   // For example, using fetch:
  //   // fetch(this.action, {
  //   //   method: 'POST',
  //   //   body: formData
  //   // }).then(response => {
  //   //   // Handle the response
  //   // });

  //   // For now, let's just log the formData
  //   console.log('Form submitted with files:', selectedFiles);
  // });
});    
</script>