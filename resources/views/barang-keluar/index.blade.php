<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Barang Keluar') }}
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
                                <th>IMEI</th>
                                <th>Model</th>
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

    <div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Kelola Barang Keluar</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formBarangKeluar">
                        <div class="mb-3">
                            <label for="tanggal_keluar" class="form-label">Tanggal Barang Keluar</label>
                            <input type="date" class="form-control" id="tanggal_keluar" name="tanggal_keluar" aria-describedby="tanggal_keluar">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="harga_keluar" class="form-label">Harga Barang Keluar</label>
                            <input type="number" class="form-control" id="harga_keluar" name="harga_keluar">
                        </div>
                        <div class="mb-3">
                            <label for="harga_keluar" class="form-label">Kondisi Barang</label>
                            <select class="form-select" id="id_kondisi" name="id_kondisi" aria-label="Default select example">
                                <option selected>Pilih Kondisi</option>
                                @foreach($refKondisi as $k)
                                <option value="{{ $k->id }}">{{ $k->kondisi_barang }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="bukti_barang_keluar" class="form-label">Bukti Barang Keluar</label>
                            <input class="form-control" type="file" id="bukti_barang_keluar" name="bukti_barang_keluar">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveChanges">Save changes</button>
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
                ajax: "{{ route('barang-keluar.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'imei',
                        name: 'imei'
                    },
                    {
                        data: 'model',
                        name: 'model'
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
            $(document).on('click', '.kelola', function() {
                var id = $(this).data('id');
                $('#saveChanges').data('id', id);
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#saveChanges').click(function(e) {
                // Panggil fungsi dari ajax-handler.js
                handleSaveChanges('#formBarangKeluar', '#saveChanges', "{{ route('barang-keluar.store') }}");
            });
            // $('#saveChanges').click(function(e) {
            //     var id = $(this).data('id');
            //     if (!id) {
            //         alert("ID tidak ditemukan!");
            //         return;
            //     }
            //     var formData = new FormData($('#formBarangKeluar')[0]);
            //     formData.append('id', id);

            //     $.ajax({
            //         url: "{{ route('barang-keluar.store')}}",
            //         type: 'POST',
            //         data: formData,
            //         contentType: false,
            //         processData: false,
            //         success: function(response) {
            //             Swal.fire({
            //                 icon: 'success',
            //                 title: `${response.message}`,
            //                 showConfirmButton: false,
            //                 timer: 2000
            //             })
            //             // .then(() => {
            //             //     location.reload(); // Pastikan tabel di-refresh setelah SweetAlert selesai
            //             // });
            //             $('.btn-close').click();
            //         },
            //         error: function(xhr, status, error) {
            //             Swal.fire({
            //                 icon: 'success',
            //                 title: 'Failed to save data: ' + error,
            //                 showConfirmButton: false,
            //                 timer: 2000
            //             })
            //              $('.btn-close').click();
            //         }
            //     });
            // });
        });
    </script>
    @endpush
</x-app-layout>