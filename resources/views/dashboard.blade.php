@extends('layouts.main')

@section('content')

<div class="pagetitle">
  <h1>Dashboard</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.html">Home</a></li>
      <li class="breadcrumb-item active">Dashboard</li>
    </ol>
  </nav>
</div>

<section class="section dashboard">
  <div class="row">
    <div class="col-lg-12">
      <div class="row">
        <div class="col-12">
          <div class="card info-card sales-card">
            <div class="card-body">
              {{-- <h5 class="card-title">Selamat datang di Dashboard Penjualan.</h5> --}}
              <div class="col-lg-12 card-title">
                <div class="row">
                  <div class="col-xxl-4 col-md-6">
                    <div class="card info-card sales-card">
                      <div class="card-body">
                        <h5 class="card-title">Transaksi <span>| Alltime</span></h5>

                        <div class="d-flex align-items-center">
                          <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-cart"></i>
                          </div>
                          <div class="ps-3">
                            <h6>{{ $transaksi }}</h6>
                            <span class="text-muted small pt-2 ps-1">Data</span>
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>

                  <div class="col-xxl-4 col-md-6">
                    <div class="card info-card revenue-card">
                      <div class="card-body">
                        <h5 class="card-title">Jenis Barang <span>| Aktif</span></h5>

                        <div class="d-flex align-items-center">
                          <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-box"></i>
                          </div>
                          <div class="ps-3">
                            <h6>{{ $jenis_barang }}</h6>
                            <span class="text-muted small pt-2 ps-1">Data</span>
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>

                  <div class="col-xxl-4 col-xl-12">
                    <div class="card info-card customers-card">
                      <div class="card-body">
                        <h5 class="card-title">Barang <span>| Aktif</span></h5>
                        <div class="d-flex align-items-center">
                          <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-box"></i>
                          </div>
                          <div class="ps-3">
                            <h6>{{ $barang }}</h6>
                             <span class="text-muted small pt-2 ps-1">Data</span>
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>

                  <div class="col-lg-12">
                    <div class="card">
                      <div class="card-body">
                        <h5 class="card-title">Report Transaksi Per Barang</h5>

                        <canvas id="barChart" style="max-height: 300px;"></canvas>
                        <script>
                          document.addEventListener("DOMContentLoaded", () => {
                              const chartData = @json($chartData);
                  
                              new Chart(document.querySelector('#barChart'), {
                                  type: 'bar',
                                  data: {
                                      labels: chartData.labels,
                                      datasets: [{
                                          label: 'Jumlah Penjualan',
                                          data: chartData.data,
                                          backgroundColor: [
                                              'rgba(255, 99, 132, 0.2)',
                                              'rgba(255, 159, 64, 0.2)',
                                              'rgba(255, 205, 86, 0.2)',
                                              'rgba(75, 192, 192, 0.2)',
                                              'rgba(54, 162, 235, 0.2)',
                                              'rgba(153, 102, 255, 0.2)',
                                              'rgba(201, 203, 207, 0.2)'
                                          ],
                                          borderColor: [
                                              'rgb(255, 99, 132)',
                                              'rgb(255, 159, 64)',
                                              'rgb(255, 205, 86)',
                                              'rgb(75, 192, 192)',
                                              'rgb(54, 162, 235)',
                                              'rgb(153, 102, 255)',
                                              'rgb(201, 203, 207)'
                                          ],
                                          borderWidth: 1
                                      }]
                                  },
                                  options: {
                                      scales: {
                                          y: {
                                              beginAtZero: true
                                          }
                                      }
                                  }
                              });
                          });
                      </script>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>
@endsection

@push('css')
@endpush

@push('scripts')
@endpush