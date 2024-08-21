@extends('layouts.admin')

@section('content')
    @if ($errors->any())
        <div class="toast-container position-fixed top-0 end-0 p-3" id="userError">
            @foreach ($errors->all() as $item)
                <div class="toast show bg-danger" aria-atomic="true" data-bs-delay="2000" data-bs-autohide="true"
                    data-bs-theme="dark" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header">
                        <img src="{{ asset('images/igm.png') }}" class="rounded me-2" width="50" alt="...">
                        <strong class="me-auto">DIAHSISKA</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ $item }}
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    <a href="/admin/user" class="btn btn-primary fw-bold"><i class="fa-solid fa-caret-left me-2"></i>Kembali</a>
    <div class="row p-2">
        <div class="col-md-8 bg-white rounded-3 p-4 shadow-lg">
            <form action="{{ url('admin/user/' . $data->nidn) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-5 mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control border-black" id="nidn"
                                value="{{ $data->nidn }}" name="nidn" placeholder="NIDN" maxlength="10" readonly>
                            <label for="nidn" class="text-black">NIDN</label>
                        </div>
                    </div>
                    <div class="col-md-7 mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control border-black" id="nama"
                                value="{{ $data->name }}" name="nama" placeholder="Nama" required>
                            <label for="nama" class="text-black">Nama</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 mb-3">
                        <div class="form-floating">
                            <input type="text" class="form-control border-black" id="username" name="username"
                                value="{{ $data->username }}" placeholder="Username" required>
                            <label for="username" class="text-black">Username</label>
                        </div>
                    </div>
                    <div class="col-md-7 mb-3">
                        <div class="form-floating">
                            <input type="email" class="form-control border-black" id="email"
                                value="{{ $data->email }}" name="email" placeholder="Email" required>
                            <label for="email" class="text-black">Email</label>
                        </div>
                    </div>
                </div>

                <div class="input-group mb-3" id="eye_password">
                    <div class="form-floating">
                        <input type="password" class="form-control border-black" id="password" name="password"
                            placeholder="Change Password">
                        <label for="password" class="text-black">Change Password</label>
                    </div>
                    <a href="" class="input-group-text"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <select class="form-select fw-bold border-black" name="role" id="role"
                            onchange="selectedRole()" required>
                            <option selected disabled value="">Role</option>
                            @foreach ($roles as $key => $value)
                                <option value="{{ $key }}" {{ $data->role == $key ? 'selected' : '' }}>
                                    {{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <select class="form-select fw-bold border-black" name="fps" id="fps" required>
                            <option selected disabled value="">Pilih...</option>
                            @foreach ($fps as $key => $value)
                                <option value="{{ $key }}" {{ $data->fps == $key ? 'selected' : '' }}>
                                    {{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100">Submit</button>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        const toast = document.getElementById('userError')
        window.onload = function() {
            setTimeout(function() {
                toast.style.display = 'none';
            }, 5000);
        }
    </script>
    <script>
        $(document).ready(function() {
            $("#eye_password a").on('click', function(event) {
                event.preventDefault();
                if ($('#eye_password input').attr("type") == "text") {
                    $('#eye_password input').attr('type', 'password');
                    $('#eye_password i').addClass("fa-eye-slash");
                    $('#eye_password i').removeClass("fa-eye");
                } else if ($('#eye_password input').attr("type") == "password") {
                    $('#eye_password input').attr('type', 'text');
                    $('#eye_password i').removeClass("fa-eye-slash");
                    $('#eye_password i').addClass("fa-eye");
                }
            });
        });

        function selectedRole() {
            const selectRole = document.getElementById("role");
            let roleValue = selectRole.value;
            let additionalSelect = document.getElementById("fps");
            additionalSelect.innerHTML = '<option selected disabled value="">Pilih</option>';

            if (roleValue === "warek") {
                additionalSelect.innerHTML += '<option value="warek">Wakil Rektor</option>';
            } else if (roleValue === "dekan") {
                additionalSelect.innerHTML += '<option value="ilkom">Ilmu Komputer dan Sains</option>';
                additionalSelect.innerHTML += '<option value="teknik">Teknik</option>';
                additionalSelect.innerHTML += '<option value="ekonomi">Ekonomi</option>';
                additionalSelect.innerHTML += '<option value="fipb">Ilmu Pemerintahan dan Budaya</option>';
                additionalSelect.innerHTML += '<option value="fkip">Keguruan dan Ilmu Pendidikan</option>';
            } else if (roleValue === "kaprodi") {
                additionalSelect.innerHTML += '<option value="ak">Akuntansi</option>';
                additionalSelect.innerHTML += '<option value="mm">Magister Manajemen</option>';
                additionalSelect.innerHTML += '<option value="m">Manajemen</option>';
                additionalSelect.innerHTML += '<option value="dkv">Desain Komunikasi Visual</option>';
                additionalSelect.innerHTML += '<option value="ip">Ilmu Pemerintahan</option>';
                additionalSelect.innerHTML += '<option value="pbi">Pendidikan Bahasa Inggris</option>';
                additionalSelect.innerHTML += '<option value="b">Biologi</option>';
                additionalSelect.innerHTML += '<option value="k">Kimia</option>';
                additionalSelect.innerHTML += '<option value="si">Sistem Informasi</option>';
                additionalSelect.innerHTML += '<option value="sk">Sistem Komputer</option>';
                additionalSelect.innerHTML += '<option value="ti">Teknik Informatika</option>';
                additionalSelect.innerHTML += '<option value="a">Arsitektur</option>';
                additionalSelect.innerHTML += '<option value="k3">Keselamatan dan Kesehatan Kerja</option>';
                additionalSelect.innerHTML += '<option value="sp">Survei Dan Pemetaan</option>';
                additionalSelect.innerHTML += '<option value="ts">Teknik Sipil</option>';
            }
        }
    </script>
@endpush
