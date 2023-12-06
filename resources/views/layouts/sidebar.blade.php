<div class="sidebar">
        <div class="user-profile">
          <div class="display-avatar animated-avatar">
            <img class="profile-img img-lg rounded-circle" src="{{ asset('images/profile/male/image_1.png') }}" alt="profile image">
          </div>
          <div class="info-wrapper">
            <p class="user-name">{{ Auth::user()->name }}</p>
            <h6 class="display-income">$3,400,00</h6>
          </div>
        </div>
        <ul class="navigation-menu">
          <li class="nav-category-divider">MAIN</li>
          <li>
            <a href="{{ route('dashboard') }}">
              <span class="link-title">Dashboard</span>
              <i class="mdi mdi-gauge link-icon"></i>
            </a>
          </li>
          <li>
            <a href="#sample-pages" data-toggle="collapse" aria-expanded="false">
              <span class="link-title">Yuk Jadwalkan</span>
              <i class="mdi mdi-flask link-icon"></i>
            </a>
            <ul class="collapse navigation-submenu" id="sample-pages">
              <li>
                <a href="{{ route('mahasiswa.jadwaldosen') }}">Jadwal Dosen</a>
              </li>
              <li>
                <a href="{{ route('mahasiswa.bikinjadwal') }}">Yuk Konseling</a>
              </li>
            </ul>
          </li>
          <li>
            <a href="{{ route('mahasiswa.pembayaranukt') }}">
              <span class="link-title">Pembayaran UKT</span>
              <i class="mdi mdi-gauge link-icon"></i>
            </a>
          </li>
          <li>
            <a href="{{ route('mahasiswa.konsultasi') }}">
              <span class="link-title">Konseling</span>
              <i class="mdi mdi-gauge link-icon"></i>
            </a>
          </li>
          <li>
            <a href="{{ route('mahasiswa.riwayatkonseling') }}">
              <span class="link-title">Riwayat Konseling</span>
              <i class="mdi mdi-gauge link-icon"></i>
            </a>
          </li>
          <li>
            <a href="pages/charts/chartjs.html">
              <span class="link-title">Charts</span>
              <i class="mdi mdi-chart-donut link-icon"></i>
            </a>
          </li>
          <li>
            <a href="pages/icons/material-icons.html">
              <span class="link-title">Icons</span>
              <i class="mdi mdi-flower-tulip-outline link-icon"></i>
            </a>
          </li>
          <li class="nav-category-divider">DOCS</li>
          <li>
            <a href="../docs/docs.html">
              <span class="link-title">Documentation</span>
              <i class="mdi mdi-asterisk link-icon"></i>
            </a>
          </li>
        </ul>
        <div class="sidebar-upgrade-banner">
          <p class="text-gray">Upgrade to <b class="text-primary">PRO</b> for more exciting features</p>
          <a class="btn upgrade-btn" target="_blank" href="http://www.uxcandy.co/product/label-pro-admin-template/">Upgrade to PRO</a>
        </div>
      </div>