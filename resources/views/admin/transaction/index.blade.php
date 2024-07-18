@extends('layouts.admin')
@section('header', 'Tranasction')
@section('content')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endSection

@section('content')
    <div id="controller">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header row">
                        <div class="col-md-8">
                            <a href="#" @click="addData()" data-target="#modal-default" data-toggle="modal"
                                class="btn-sm btn-primary pull-right">Create New Transaction</a>
                        </div>
                        <div class="col-md-2">
                            <select name="status" class="form-control">
                                <option value="3">Filter Status</option>
                                <option value="1">Sudah Dikembalikan</option>
                                <option value="0">Belum Dikembalikan</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="date" name="date_start">
                            <button type="button" id="filter-btn">Filter Tanggal Pinjam</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="datatable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th class="text-center">Nama Peminjam</th>
                                    <th class="text-center">Tanggal Pinjam</th>
                                    <th class="text-center">Tanggal Kembali</th>
                                    <th class="text-center">Lama Pinjam (hari)</th>
                                    <th class="text-center">Total Buku</th>
                                    <th class="text-center">Total Bayar</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                    <div class="modal fade" id="modal-default">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form :action="actionUrl" method="post" autocomplete="off"
                                    @submit="submitForm($event, data.id)">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Transaction</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        @csrf
                                        <input type="hidden" name="_method" value="PUT" v-if="editStatus">
                                        <div class="form-group">
                                            <label for="member_id">Nama Peminjam</label>
                                            <select name="member_id" class="form-control" required="">
                                                @foreach ($members as $member)
                                                    <option value="{{ $member->id }}">{{ $member->name }}</option>
                                                @endforeach
                                            </select>
                                            <label for="date_start">Tanggal Pinjam</label>
                                            <input type="date" name="date_start" class="form-control"
                                                placeholder="Enter Tanggal Pinjam" :value="data.date_start" required="">
                                            <label for="date_end">Tanggal Kembali</label>
                                            <input type="date" name="date_end" class="form-control"
                                                placeholder="Enter Tanggal Kembali" :value="data.date_end" required="">
                                            <div class="form-group">
                                                <label for="books">Buku yang Dipinjam</label>
                                                <div v-if="editStatus==false">
                                                    <select name="books[]" class="select2"
                                                        multiple="multiple" data-placeholder="Select Buku"
                                                        :value="data.books" style="width: 100%;">
                                                        @foreach ($books as $book)
                                                            <option value="{{ $book->id }}">{{ $book->title }} (Rp
                                                                {{ $book->price }})</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div>
                                                    <textarea name="books[]" name="message" rows="5" cols="30" :value="data.books" v-if="editStatus">{{ $book->title }}
                                                    </textarea>
                                                </div>       
                                            </div>
                                            <div v-if="editStatus">
                                                <label for="status">Status</label>
                                                <select name="status" id="">
                                                    <option value="1">Sudah Dikembalikan</option>
                                                    <option value="0">Belum Dikembalikan</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default"
                                            data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endSection
@section('js')
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script> <!-- Added Bootstrap JS -->
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script type="text/javascript">
        var actionUrl = '{{ url('transactions') }}';
        var apiUrl = '{{ url('api/transactions') }}';
        var columns = [{
                data: 'DT_RowIndex',
                class: 'text-center',
                orderable: true
            },
            {
                data: 'member_id',
                class: 'text-center',
                orderable: true
            },
            {
                data: 'date_start',
                class: 'text-center',
                orderable: true
            },
            {
                data: 'date_end',
                class: 'text-center',
                orderable: true
            },
            {
                data: 'lama_pinjam',
                class: 'text-center',
                orderable: true
            },
            {
                data: 'total_buku',
                class: 'text-center',
                orderable: true
            },
            {
                data: 'total_bayar',
                class: 'text-center',
                orderable: true
            },
            {
                data: 'status',
                class: 'text-center',
                orderable: true
            },
            {
                render: function(index, row, data, meta) {
                    return `
                <a href="#" class="btn btn-sm btn-warning" onclick="controller.editData(event, ${meta.row})">Edit</a>
                <a href="#" class="btn btn-sm btn-danger" onclick="controller.deleteData(event, ${data.id})">Delete</a>
            `;
                },
                orderable: false,
                width: '200px',
                class: 'text-center'
            }
        ];
    </script>
    <script>
        var controller = new Vue({
            el: '#controller',
            data: {
                datas: [],
                data: {
                    books: []
                },
                actionUrl,
                apiUrl,
                editStatus: false,
            },
            mounted: function() {
                this.datatable();
            },
            methods: {
                datatable() {
                    const _this = this;
                    _this.table = $('#datatable').DataTable({
                        ajax: {
                            url: _this.apiUrl,
                            type: 'GET',
                        },
                        columns
                    }).on('xhr', function() {
                        _this.datas = _this.table.ajax.json().data;
                    });
                },
                addData() {
                    this.data = {
                        books: []
                    };
                    this.editStatus = false;
                    $('#modal-default').modal();
                },
                editData(event, row) {
                    const selectedData = this.datas[row];
                    this.data = {
                        ...selectedData,
                        books: selectedData.books.map(book =>  book.id)
                    };
                    this.editStatus = true;
                    $('#modal-default').modal();
                },
                deleteData(event, id) {
                    if (confirm('Are you sure?')) {
                        $(event.target).parents('tr').remove();
                        axios.post(this.actionUrl + '/' + id, {
                            _method: 'DELETE'
                        }).then(response => {
                            alert('Data has been deleted');
                            this.table.ajax.reload();
                        });
                    }
                },
                submitForm(event, id) {
                    event.preventDefault();
                    const _this = this;
                    var actionUrl = !this.editStatus ? this.actionUrl : this.actionUrl + '/' + id;
                    axios.post(actionUrl, new FormData($(event.target)[0])).then(response => {
                        $('#modal-default').modal('hide');
                        $('.modal-backdrop').remove();
                        _this.table.ajax.reload();
                    });
                }
            }
        });
    </script>
    <script type="text/javascript">
        $('select[name=status]').on('change', function() {
            status = $('select[name=status]').val();
            if (status == 3) {
                controller.table.ajax.url(actionUrl).load();
            } else {
                controller.table.ajax.url(actionUrl + '?status=' + status).load();
            }
        });
        $('#filter-btn').on('click', function() {
            date_start = $('input[name=date_start]').val();
            if (date_start === '') {
                controller.table.ajax.url(actionUrl).load()
                alert('Tanggal Pinjam Harus Diisi');
            } else {
                controller.table.ajax.url(actionUrl + '?date_start=' + date_start).load();
            }
        });
    </script>
    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

        })
    </script>
@endSection
