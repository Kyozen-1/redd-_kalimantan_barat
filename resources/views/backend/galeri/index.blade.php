@extends('backend.layouts.app')
@section('title', 'Galeri | REDD++ Kalimantan Barat')
@section('header', 'Galeri')

@section('css')
    <link href="{{ asset('/backend_template/libs/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/backend_template/libs/datatables/responsive.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/backend_template/libs/datatables/buttons.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/backend_template/libs/datatables/select.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/backend_template/libs/custombox/custombox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/backend_template/libs/dropify/dropify.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <style>
        .table th {
            text-align: center;
        }
        .table td {
            justify-content: center;
            text-align: center;
        }

        .select2-container .select2-selection--single {
            height: 38px;           /* samakan dengan input/select */
            display: flex;
            align-items: center;    /* center vertical */
            border: 1px solid #ced4da;
            border-radius: 4px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 38px;   /* samakan dengan height */
            padding-left: 10px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 38px;
            top: 0;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #0d6efd; /* biru bootstrap */
            border-color: #0d6efd;
            color: white;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card-box table-responsive">
                <div class="row mb-2">
                    <div class="col-md-6">
                        <h4 class="mt-0 header-title">Tabel Data</h4>
                    </div>
                    <div class="col-md-6 text-right">
                        <button class="btn btn-icon waves-effect waves-light btn-primary" data-toggle="modal" data-target="#createModal" id="create" name="create">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <table id="table_galeri" class="table table-bordered table-bordered dt-responsive nowrap">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="10%">Aksi</th>
                            <th>Nama</th>
                            <th>Kabupaten</th>
                            <th>Tanggal</th>
                            <th>Jenis File</th>
                            <th>File</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div> <!-- end row -->

    <div id="createModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="createModalLabel">Tambah Data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <span id="form_result"></span>
                    <form class="form-horizontal" id="form_galeri" method="POST" enctype="multipart/form-data" data-parsley-validate novalidate>
                        @csrf
                        <div class="form-group">
                            <label for="nama" class="control-label">Nama File<span class="text-danger">*</span></label>
                            <input type="text" name="nama" id="nama" parsley-trigger="change" required
                            placeholder="Masukan nama file..." class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="kabupaten_kota_id" class="control-label">Kabupaten/Kota</label>
                            <select name="kabupaten_kota_id" id="kabupaten_kota_id" class="form-control" required>
                                <option value="">Pilih</option>
                                @foreach ($kabupatenKotas as $kabupatenKota)
                                    <option value="{{$kabupatenKota['id']}}">{{$kabupatenKota['nama']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tanggal" class="control-label">Tanggal Kegiatan<span class="text-danger">*</span></label>
                            <input type="date" name="tanggal" id="tanggal" parsley-trigger="change" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="jenis_file" class="control-label">Jenis File</label>
                            <select name="jenis_file" id="jenis_file" class="form-control" required>
                                <option value="">Pilih</option>
                                <option value="gambar">Gambar</option>
                                <option value="video">Video</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="file" class="control-label">File</label>
                            <input type="file" class="dropify" id="file" name="file" data-height="150" data-allowed-file-extensions="png jpg jpeg webp mkv mp4" data-show-errors="true">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light waves-effect width-md waves-light" data-dismiss="modal">Close</button>
                    <input type="hidden" name="aksi" id="aksi" value="Save">
                    <input type="hidden" name="hidden_id" id="hidden_id">
                    <button type="submit" name="aksi_button" id="aksi_button" class="btn btn-primary waves-effect width-md waves-light">Save</button>
                </div>
            </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
@endsection

@section('js')
    <!-- third party js -->
    <script src="{{ asset('/backend_template/libs/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/backend_template/libs/datatables/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('/backend_template/libs/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('/backend_template/libs/datatables/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/backend_template/libs/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('/backend_template/libs/datatables/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/backend_template/libs/datatables/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('/backend_template/libs/datatables/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('/backend_template/libs/datatables/buttons.print.min.js') }}"></script>
    <script src="{{ asset('/backend_template/libs/datatables/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('/backend_template/libs/datatables/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('/backend_template/libs/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('/backend_template/libs/pdfmake/vfs_fonts.js') }}"></script>
    <!-- third party js ends -->

    <!-- Datatables init -->
    <script src="{{ asset('/backend_template/js/pages/datatables.init.js') }}"></script>
    <!-- Validation js (Parsleyjs) -->
    <script src="{{ asset('/backend_template/libs/parsleyjs/parsley.min.js') }}"></script>

    <!-- validation init -->
    <script src="{{ asset('/backend_template/js/pages/form-validation.init.js') }}"></script>
    <script src="{{ asset('/backend_template/libs/dropify/dropify.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script>
        $('#kabupaten_kota_id').select2();
        $('#jenis_file').select2();
        $('.dropify').dropify();
        var dataTables = $('#table_galeri').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('cms.galeri.datatable') }}",
            },
            columns:[
                {
                    data: 'DT_RowIndex'
                },
                {
                    data: 'aksi',
                    name: 'aksi',
                    orderable: false
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'kabupaten_kota_id',
                    name: 'kabupaten_kota_id'
                },
                {
                    data: 'tanggal',
                    name: 'tanggal'
                },
                {
                    data: 'jenis_file',
                    name: 'jenis_file'
                },
                {
                    data: 'file',
                    name: 'file'
                }
            ]
        });

        function reset()
        {
            $('#form_galeri')[0].reset();
            $("[name='kabupaten_kota_id']").val('').trigger('change');
            $("[name='jenis_file']").val('').trigger('change');
            $('.dropify-clear').click();
        }

        $('#create').click(function(){
            reset();
            $('#aksi_button').text('Save');
            $('#aksi_button').prop('disabled', false);
            $('.modal-title').text('Add Data');
            $('#aksi_button').val('Save');
            $('#aksi').val('Save');
            $('#form_result').html('');
        });

        $('#form_galeri').on('submit', function(e){
            e.preventDefault();
            if($('#aksi').val() == 'Save')
            {
                $.ajax({
                    url: "{{ route('cms.galeri.store') }}",
                    method: "POST",
                    data: new FormData(this),
                    dataType: "json",
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function()
                    {
                        $('#aksi_button').text('Menyimpan...');
                        $('#aksi_button').prop('disabled', true);
                    },
                    success: function(data)
                    {
                        var html = '';
                        if(data.errors)
                        {
                            html = '<div class="alert alert-danger">'+data.errors+'</div>';
                            $('#aksi_button').prop('disabled', false);
                            reset();
                            $('#aksi_button').text('Save');
                            $('#table_galeri').DataTable().ajax.reload();
                        }
                        if(data.success)
                        {
                            html = '<div class="alert alert-success">'+data.success+'</div>';
                            $('#aksi_button').prop('disabled', false);
                            reset();
                            $('#aksi_button').text('Save');
                            $('#table_galeri').DataTable().ajax.reload();
                        }

                        $('#form_result').html(html);
                    }
                });
            }
            if($('#aksi').val() == 'Edit')
            {
                $.ajax({
                    url: "{{ route('cms.dokumen-galeri.update') }}",
                    method: "POST",
                    data: new FormData(this),
                    dataType: "json",
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function(){
                        $('#aksi_button').text('Mengubah...');
                        $('#aksi_button').prop('disabled', true);
                    },
                    success: function(data)
                    {
                        var html = '';
                        if(data.errors)
                        {
                            html = '<div class="alert alert-danger">'+data.errors+'</div>';
                            $('#aksi_button').prop('disabled', true);
                            $('#aksi_button').text('Edit');
                        }
                        if(data.success)
                        {
                            reset();
                            $('#aksi_button').prop('disabled', false);
                            $('#aksi_button').text('Save');
                            $('#table_galeri').DataTable().ajax.reload();
                            $('#createModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil di ubah',
                                showConfirmButton: true
                            });
                        }

                        $('#form_result').html(html);
                    }
                });
            }
        });
    </script>
@endsection
