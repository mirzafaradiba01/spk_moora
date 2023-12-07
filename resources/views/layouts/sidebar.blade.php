<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('assets/img/logo.png') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a class="d-block">SPK-MOORA</a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ url('dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Home
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('kriteriabobot') }}" class="nav-link">
                        <i class="nav-icon fas fa-balance-scale"></i>
                        <p>
                            Kriteria & Bobot
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('alternatif') }}" class="nav-link">
                        <i class="nav-icon fas fa-list-alt"></i>
                        <p>
                            Alternatif & Skor
                        </p>
                    </a>
                </li>
                
                <li class="nav-header">Hasil</li>
                <li class="nav-item">
                    <a href="{{ url('decisionmatrix') }}" class="nav-link">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            Matriks Keputusan
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('normalization') }}" class="nav-link">
                        <i class="nav-icon far fa-chart-bar"></i>
                        <p>
                            Perhitungan MOORA
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('ranking') }}" class="nav-link">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>
                            Ranking
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>