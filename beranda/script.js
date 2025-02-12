function previewImage(event) {
  const imagePreview = document.getElementById("previewImage");
  const file = event.target.files[0];

  if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
          imagePreview.src = e.target.result;
          imagePreview.style.display = "block"; // Tampilkan gambar setelah dipilih
      };
      reader.readAsDataURL(file);
  } else {
      imagePreview.style.display = "none"; // Sembunyikan jika tidak ada file
  }
}


