@extends('backend.layouts.app')
@section('title', 'Create | Berita | REDD++ Kalimantan Barat')
@section('header', 'Create | Berita')

@section('css')
    <link href="{{ asset('/backend_template/libs/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/backend_template/libs/datatables/responsive.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/backend_template/libs/datatables/buttons.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/backend_template/libs/datatables/select.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/backend_template/libs/custombox/custombox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/backend_template/libs/dropify/dropify.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <link href="https://unpkg.com/filepond@4/dist/filepond.min.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview@4/dist/filepond-plugin-image-preview.min.css" rel="stylesheet">
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
        .ck-editor__editable {
            min-height: 400px;
        }
    </style>
@endsection

@section('content')
<form class="form-horizontal" id="form_dokumen_galeri" method="POST" action="{{ route('cms.berita.store') }}" enctype="multipart/form-data" data-parsley-validate novalidate>
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="mt-0 header-title">Tambah Berita</h4>
                    </div>
                    <div class="col-md-6 text-right">
                        <a class="btn btn-icon waves-effect waves-light btn-primary" href="{{ route('cms.berita.index') }}">
                            Kembali<i class="fas fas fa-right-long"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card-box">
                <div class="row">
                    @if (session('failed'))
                        <div class="col-12">
                            <div class="alert alert-danger">{{session('failed')}}</div>
                        </div>
                    @endif
                    <div class="col-12">
                        <div class="form-group">
                            <label for="judul" class="control-label">Judul</label>
                            <input type="text" name="judul" id="judul" value="{{ old('judul') }}" parsley-trigger="change" required placeholder="Masukan judul..." class="form-control">
                            @error('judul')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="deskripsi" class="control-label">Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" id="deskripsi" rows="8" required>{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Gambar Berita</label>

                            <input
                                type="file"
                                class="filepond"
                                name="gambar[]"
                                multiple
                                accept="image/png,image/jpeg,image/jpg">

                            @error('gambar')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card-box">
                <div class="row">
                    <div class="col-12">
                        <button class="btn btn-primary waves-effect btn-block" type="submit">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end row -->
</form>
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
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
    <script src="https://unpkg.com/filepond@4/dist/filepond.min.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview@4/dist/filepond-plugin-image-preview.min.js"></script>
    <script>
        FilePond.registerPlugin(
            FilePondPluginImagePreview
        );

        const pond = FilePond.create(
            document.querySelector('.filepond'),
            {
                storeAsFile: true
            }
        );

        ClassicEditor
            .create(document.querySelector('#deskripsi'), {
                toolbar: [
                    'heading',
                    '|',
                    'bold',
                    'italic',
                    'link',
                    '|',
                    'bulletedList',
                    'numberedList',
                    '|',
                    'blockQuote',
                    '|',
                    'undo',
                    'redo'
                ],

                link: {
                    addTargetToExternalLinks: true,
                    defaultProtocol: 'https://'
                }
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
