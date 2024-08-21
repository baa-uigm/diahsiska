<nav class="navbar navbar-expand-lg sticky-top bg-dark">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center w-100">
            <div>
                <a class="navbar-brand fw-bold fs-4 text-white" href="/">DIAHSISKA</a>
            </div>
            <div>
                <button class="navbar-toggler border-white p-1" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <i class="fa-solid fa-bars text-white px-1 fs-3"></i>
                </button>
            </div>
        </div>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Halo,
                        {{ Auth::user()->name ?? '' }}
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item fw-bold" href="/logout"><i
                                    class="fa-solid fa-door-open me-2"></i>Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
