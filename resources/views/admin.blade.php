@extends('layouts.main')


@section('content')
    @if (Auth::user()->fps == 'ilkom' ||
            Auth::user()->fps == 'ekonomi' ||
            Auth::user()->fps == 'teknik' ||
            Auth::user()->fps == 'fkip' ||
            Auth::user()->fps == 'fipb' ||
            Auth::user()->fps == 'k3' ||
            Auth::user()->fps == 'sk' ||
            Auth::user()->fps == 'ti' ||
            Auth::user()->fps == 'si' ||
            Auth::user()->fps == 'pwk' ||
            Auth::user()->fps == 'manajemen' ||
            Auth::user()->fps == 'mm' ||
            Auth::user()->fps == 'arsitektur' ||
            Auth::user()->fps == 'survei' ||
            Auth::user()->fps == 'dkv' ||
            Auth::user()->fps == 'pbi' ||
            Auth::user()->fps == 'sipil' ||
            Auth::user()->fps == 'akuntansi' ||
            Auth::user()->role == 'warek')
        <div class="row justify-content-center my-4 p-5">
            <h3 class="text-center mb-5">Selamat Datang, <br> {{ Auth::user()->name }}</h3>
            <div class="col-md-4 p-2">
                <div class="card border-none">
                    <img src="{{ asset('images/nilai.webp') }}" class="card-img" alt="Gambar UIGM">
                    <div class="card-img-overlay text-center align-items-center d-flex">
                        <a class="p-2 rounded-0 text-white fw-bold btn btn-dark w-100"
                            href="/nilai/{{ Auth::user()->role }}/{{ Auth::user()->fps }}">Nilai
                            Mahasiswa</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 p-2">
                <div class="card border-none">
                    <img src="{{ asset('images/nilai.webp') }}" class="card-img" alt="Gambar UIGM">
                    <div class="card-img-overlay text-center align-items-center d-flex">
                        <a class="p-2 rounded-0 text-white fw-bold btn btn-dark w-100"
                            href="/graduate/{{ Auth::user()->role }}/{{ Auth::user()->fps }}">Yudisium</a>
                    </div>
                </div>
            </div>
            @if (Auth::user()->role == 'warek' || Auth::user()->role == 'dekan')
                <div class="col-md-4 p-2">
                    <div class="card border-none">
                        <img src="{{ asset('images/krs.webp') }}" class="card-img" alt="Gambar UIGM">
                        <div class="card-img-overlay text-center align-items-center d-flex">
                            <a class="p-2 rounded-0 text-white fw-bold btn btn-dark w-100"
                                href="/krs/{{ Auth::user()->role }}/{{ Auth::user()->fps }}">KRS
                                Mahasiswa</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @endif
@endsection
