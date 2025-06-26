<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Slideshow with Navbar</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">My Slideshow</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarNav" aria-controls="navbarNav"
            aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link active" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Gallery</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contact</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Slideshow -->
<div class="container mt-4">
  <div id="mainCarousel" class="carousel slide" data-bs-ride="carousel">
    <!-- Indicators -->
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
      <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="3" aria-label="Slide 4"></button>
    </div>

    <!-- Slides -->
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="{{ asset('images/slide1.jpg') }}" class="d-block w-100" alt="Slide 1">
      </div>
      <div class="carousel-item">
        <img src="{{ asset('images/slide2.jpg') }}" class="d-block w-100" alt="Slide 2">
      </div>
      <div class="carousel-item">
        <img src="{{ asset('images/slide3.jpg') }}" class="d-block w-100" alt="Slide 3">
      </div>
      <div class="carousel-item">
        <img src="{{ asset('images/slide4.jpg') }}" class="d-block w-100" alt="Slide 4">
      </div>
    </div>

    <!-- Controls -->
    <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
</div>

<!-- Visual Search Section -->
<div class="container mt-5">
  <h2>Search Products by Image</h2>
  <input type="file" id="homeImageUpload" class="form-control my-3" />
  <button class="btn btn-primary mb-3" onclick="searchByImage('homeImageUpload', 'homeResults')">Search</button>
  <div id="homeResults" class="d-flex flex-wrap gap-3"></div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
async function searchByImage(inputId, resultsDivId) {
  const input = document.getElementById(inputId);
  if (input.files.length === 0) {
    alert("Please select an image");
    return;
  }
  const file = input.files[0];
  const formData = new FormData();
  formData.append('image', file);

  try {
    const response = await fetch('http://127.0.0.1:5000/visual-search', {
      method: 'POST',
      body: formData
    });
    if (!response.ok) throw new Error('API error');
    const suggestions = await response.json();

    const resultsDiv = document.getElementById(resultsDivId);
    resultsDiv.innerHTML = '';
    suggestions.forEach(filename => {
      const img = document.createElement('img');
      img.src = `/static/products/${filename}`; // Adjust path to your actual product images
      img.alt = filename;
      img.style.width = '150px';
      img.style.cursor = 'pointer';
      resultsDiv.appendChild(img);
    });
  } catch (err) {
    alert('Failed to get suggestions: ' + err.message);
  }
}
</script>

</body>
<a href="{{ route('cache.clear') }}" class="btn btn-warning">Clear Cache</a>
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

</html>
