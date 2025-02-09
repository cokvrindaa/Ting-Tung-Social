function previewImage(event) {
  const preview = document.getElementById("preview");
  const file = event.target.files[0];

  if (file) {
    const reader = new FileReader();

    reader.onload = function (imglink) {
      preview.src = imglink.target.result;
      preview.style.display = "block"; // Tampilkan gambar setelah dipilih
    };

    reader.readAsDataURL(file);
  } else {
    preview.style.display = "none"; // Sembunyikan jika tidak ada file
  }
}
