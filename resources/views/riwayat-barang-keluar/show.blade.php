<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Riwayat Kelola Barang') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('riwayat-barang-keluar.index') }}" class="inline-block px-6 py-2.5 bg-danger text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-primary_hover hover:shadow-lg focus:bg-primary focus:shadow-lg focus:outline-none focus:ring-0 active:bg-primary active:shadow-lg transition duration-150 ease-in-out mb-4">Kembali</a>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h4>Detail Barang</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Informasi Barang -->
                                <div class="col-md-12">
                                    <div class="card border-primary">
                                        <div class="card-body row">
                                            <h5 class="card-title fs-4 font-bold">Informasi Handphone</h5>
                                            <div class="col-6 mt-4">
                                                <p><strong>IMEI</strong></p>
                                            </div>
                                            <div class="col-6 mt-4">
                                                <p>: {{ $dataKeluar->handphone->imei }}</p>
                                            </div>
                                            <div class="col-6 mt-4">
                                                <p><strong>Model</strong></p>
                                            </div>
                                            <div class="col-6 mt-4">
                                                <p>: {{ $dataKeluar->handphone->model }}</p>
                                            </div>
                                            <div class="col-6 mt-4">
                                                <p><strong>Ukuran Layar</strong></p>
                                            </div>
                                            <div class="col-6 mt-4">
                                                <p>: {{ $dataKeluar->handphone->ukuran_layar }} inch</p>
                                            </div>
                                            <div class="col-6 mt-4">
                                                <p><strong>RAM</strong></p>
                                            </div>
                                            <div class="col-6 mt-4">
                                                <p>: {{ $dataKeluar->handphone->ram->ram }}</p>
                                            </div>
                                            <div class="col-6 mt-4">
                                                <p><strong>Tipe Handphone</strong></p>
                                            </div>
                                            <div class="col-6 mt-4">
                                                <p>: {{ $dataKeluar->handphone->tipe->nama_tipe }}</p>
                                            </div>
                                            <div class="col-6 mt-4">
                                                <p><strong>Tanggal Masuk</strong></p>
                                            </div>
                                            <div class="col-6 mt-4">
                                                <p>: {{ \Carbon\Carbon::parse($dataMasuk->tanggal_masuk)->format('d-m-Y') }}</p>
                                            </div>
                                            <div class="col-6 mt-4">
                                                <p><strong>Harga Masuk</strong></p>
                                            </div>
                                            <div class="col-6 mt-4">
                                                <p>: Rp {{ number_format($dataMasuk->harga_masuk,0,',','.') }}</p>
                                            </div>
                                            <div class="col-6 mt-4">
                                                <p><strong>Kondisi Barang Masuk</strong></p>
                                            </div>
                                            <div class="col-6 mt-4">
                                                <p>: {!! $dataMasuk->getBadgeKondisi() !!}</p>
                                            </div>
                                            <div class="col-6 mt-4">
                                                <p><strong>Tanggal Keluar</strong></p>
                                            </div>
                                            <div class="col-6 mt-4">
                                                <p>: {{ \Carbon\Carbon::parse($dataKeluar->tanggal_keluar)->format('d-m-Y') }}</p>
                                            </div>
                                            <div class="col-6 mt-4">
                                                <p><strong>Harga Barang Keluar</strong></p>
                                            </div>
                                            <div class="col-6 mt-4">
                                                <p>: Rp {{ number_format($dataKeluar->harga_keluar,0,',','.') }}</p>
                                            </div>
                                            <div class="col-6 mt-4">
                                                <p><strong>Kondisi Barang Keluar</strong></p>
                                            </div>
                                            <div class="col-6 mt-4">
                                                <p>: {!! $dataKeluar->getBadgeKondisi() !!}</p>
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
    @push('scriptjs')
    <script type="text/javascript">
        $(function() {
            //
        });
    </script>
    @endpush
</x-app-layout>