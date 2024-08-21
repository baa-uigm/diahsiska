@if (Auth::user()->fps == 'ilkom' ||
        Auth::user()->fps == 'ekonomi' ||
        Auth::user()->fps == 'teknik' ||
        Auth::user()->fps == 'fkip' ||
        Auth::user()->fps == 'fipb')
    <h3 class="text-center">Selamat Datang {{ Auth::user()->name }}</h3>
    <div class="col-md-4">
        <div class="card position-relative text-center">
            <img src="/images/nilai.webp" class="card-img-top" alt="...">
            <div class="position-absolute top-50 start-50 translate-middle">
                <a href="nilai/{{ Auth::user()->fps }}"
                    class="btn btn-primary px-3 py-2 text-decoration-none fw-bold text-white rounded-3">Nilai
                    Mahasiswa</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card position-relative text-center">
            <img src="/images/krs.webp" class="card-img-top" alt="...">
            <div class="position-absolute top-50 start-50 translate-middle">
                <a href="krs/{{ Auth::user()->fps }}"
                    class="btn btn-primary px-3 py-2 text-decoration-none fw-bold text-white rounded-3">KRS
                    Mahasiswa</a>
            </div>
        </div>
    </div>
    @if (Auth::user()->role == 'dekan')
        <div class="col-md-4">
            <div class="card position-relative text-center">
                <img src="/images/mahasiswa.jpg" class="card-img-top" alt="...">
                <div class="position-absolute top-50 start-50 translate-middle">
                    <a href="{{ Auth::user()->role }}/ipk"
                        class="btn btn-primary px-3 py-2 text-decoration-none fw-bold text-white rounded-3">Data
                        Mahasiswa IPK < 2</a>
                </div>
            </div>
        </div>
    @endif
@endif
