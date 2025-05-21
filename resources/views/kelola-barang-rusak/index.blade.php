<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Semua Barang Rusak') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#modalTambah" class="kelola mb-6 btn btn-danger" class="btn btn-danger" id="barangRusakButton">Tambah Data Barang Rusak</button>
                    <table class="table table-bordered data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Foto</th>
                                <th>IMEI</th>
                                <th>Model</th>
                                <th>tanggal</th>
                                <th>deskripsi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Barang Rusak</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formBarangRusak">
                        <div class="mb-3">
                            <label for="id_handphone" class="form-label">IMEI</label>
                            <select id="id_handphone" name="id_handphone" style="width: 100%; height: 100%" required>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" aria-describedby="tanggal" required>
                        </div>
                        <div class="mb-3">
                            <label for="bukti_barang_rusak" class="form-label">Bukti Barang Rusak</label>
                            <input class="form-control" type="file" id="bukti_barang_rusak" name="bukti_barang_rusak" required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi_kerusakan" class="form-label">Deskripsi Kerusakan</label>
                            <textarea type="text" class="form-control" id="deskripsi_kerusakan" name="deskripsi_kerusakan" required></textarea>
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
                ajax: "{{ route('kelola-barang-rusak.index') }}",
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'bukti_barang_rusak',
                        name: 'bukti_barang_rusak',
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
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'deskripsi_kerusakan',
                        name: 'deskripsi_kerusakan'
                    }
                ],
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian.json' // CDN Bahasa Indonesia
                }
            });
            $('#id_handphone').select2({
                dropdownParent: $('#modalTambah'),
                minimumInputLength: 2,
                placeholder: 'pilih imei',
                allowClear: true,
                width: 'resolve',
                language: "id",
                ajax: {
                    url: route('search.handphone'),
                    dataType: 'json',
                    processResults: data => {
                        return {
                            results: data.map(res => {
                                return {
                                    text: res.imei,
                                    id: res.id
                                }
                            })
                        }
                    }
                }
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#saveChanges').click(function(e) {
                // Panggil fungsi dari ajax-handler.js
                handleSaveChanges('#formBarangRusak', '#saveChanges', "{{ route('kelola-barang-rusak.store') }}");
            });
        });
    </script>
    @endpush
</x-app-layout>