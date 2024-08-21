<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DIAHSISKA - UIGM</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    @if ($errors->all())
        <div class="toast-container position-fixed top-0 end-0 p-3">
            @foreach ($errors->all() as $item)
                <div class="toast show text-bg-danger" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="bi bi-exclamation-triangle-fill mx-2"></i> {{ $item }}
                        </div>
                        <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"
                            aria-label="Close"></button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <main class="form-signin w-100 m-auto">
        <img src="{{ asset('images/igm.png') }}" alt="" class="w-50 mt-5 mb-3 d-flex m-auto">
        <h1 class="text-center fw-bold">DIAHSISKA UIGM</h1>
        <p class="text-center mb-5">Dashboard Informasi dan Analisis <br> Sistem Informasi Akademik</p>
        <form action="" method="POST">
            @csrf
            <h5 class="mb-3">Please Sign-in</h5>

            <div class="form-floating">
                <input type="text" class="form-control border-black" name="identity" id="identity"
                    value="{{ old('identity') }}" placeholder="Username">
                <label for="identity" class="text-black">Username</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control border-black" name="password" id="password"
                    placeholder="Password">
                <label for="password" class="text-black">Password</label>
            </div>
            <button class="btn btn-primary w-100 py-2 fw-bold" type="submit">Sign in</button>
            <p class="mt-3 mb-3 text-body-secondary text-center">&copy; DIAHSISKA - UIGM</p>
        </form>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

</body>

</html>
