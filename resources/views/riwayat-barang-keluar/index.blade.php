<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Barang Keluar') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="table table-bordered data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <!-- <th>Foto</th> -->
                                <th>IMEI</th>
                                <th>Model</th>
                                <th>Kondisi Barang</th>
                                <th>Tanggal Keluar</th>
                                <th>Harga</th>
                                <th width="150px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @push('scriptjs')
    <script type="text/javascript">
        $(function() {
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('riwayat-barang-keluar.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    // {
                    //     data: 'bukti_barang_keluar',
                    //     name: 'bukti_barang_keluar',
                    //     render: function(data, type, row) {
                    //         // Cek apakah data gambar ada
                    //         if (data) {
                    //             // Jika ada, tampilkan gambar
                    //             return `<img src="/storage/${data}" width="100" height="100" class="img-thumbnail" />`;
                    //         } else {
                    //             // Jika tidak ada, tampilkan placeholder atau string kosong
                    //             return `<span>No image</span>`;
                    //         }
                    //     },
                    //     orderable: false,
                    //     searchable: false
                    // },
                    {
                        data: 'handphone.imei',
                        name: 'handphone.imei'
                    },
                    {
                        data: 'handphone.model',
                        name: 'handphone.model'
                    },
                    {
                        data: 'id_kondisi',
                        name: 'id_kondisi',
                        render: function(data, type, row) {
                            if (row.kondisi) { // Pastikan relasi kondisi sudah dimuat
                                switch (data) {
                                    case 1:
                                        return '<span class="badge text-bg-primary">' + row.kondisi.kondisi_barang + '</span>';
                                    case 2:
                                        return '<span class="badge text-bg-warning">' + row.kondisi.kondisi_barang + '</span>';
                                    case 3:
                                        return '<span class="badge text-bg-danger">' + row.kondisi.kondisi_barang + '</span>';
                                    case 4:
                                        return '<span class="badge text-bg-secondary">' + row.kondisi.kondisi_barang + '</span>';
                                    default:
                                        return '<span class="badge text-bg-secondary">tidak tersedia</span>';
                                }
                            } else {
                                return '<span class="badge text-bg-secondary">tidak tersedia</span>';
                            }
                        }
                    },
                    {
                        data: 'tanggal_keluar',
                        name: 'tanggal_keluar',
                        render: function(data, type, row) {
                            // Pastikan format data tanggal sesuai dengan yang diharapkan
                            if (data) {
                                return moment(data).format('DD MMMM YYYY');
                            } else {
                                return 'Tanggal tidak tersedia'; // jika data tidak ada
                            }
                        }
                    },
                    {
                        data: 'harga_keluar',
                        name: 'harga_keluar',
                        render: function(data, type, row) {
                            if (data) {
                                // Format harga sebagai mata uang (IDR)
                                return new Intl.NumberFormat('id-ID', {
                                    style: 'currency',
                                    currency: 'IDR'
                                }).format(data);
                            } else {
                                return 'Harga tidak tersedia';
                            }
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian.json' // CDN Bahasa Indonesia
                }
            });
        });
    </script>
    @endpush
</x-app-layout>