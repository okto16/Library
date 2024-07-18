@extends('layouts.admin')
@section('header', 'Book')
@section('content')
    <div id="controller">
        <div class="row">
            <div class="col-md-5 offset">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                    <input type="text" class="form-control" autocomplete="off" placeholder="Search from title"
                        :value="search">
                </div>
            </div>

            <div class="col-md-2">
                <button class="btn btn-primary" @click="addData()"> Create New Book</button>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12" v-for="book in filterlist" :key="book.id">
                <div class="info-box" @click="editData(book)">
                    <div class="info-box-content">
                        <span class="info-box-text h3">@{{ book.title }} (@{{ book.qty }})</span>
                        <span class="info-box-number">Rp.@{{ formatNumber(book.price) }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-default">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form :action="actionUrl" method="post" autocomplete="off" @submit="submitForm($event, book.id)">
                        @csrf
                        <input type="hidden" name="_method" value="PUT" v-if="editStatus">
                        <div class="modal-header">
                            <h4 class="modal-title">Book</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">ISBN</label>
                                <input type="number" name="isbn" class="form-control" placeholder="Enter ISBN"
                                    required="" :value="book.isbn">
                            </div>
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" name="title" class="form-control" placeholder="Enter Title"
                                    required="" :value="book.title">
                            </div>
                            <div class="form-group">
                                <label for="year">Year</label>
                                <input type="text" name="year" class="form-control" placeholder="Enter Year"
                                    required="" :value="book.year">
                            </div>
                            <div class="form-group">
                                <label>Publisher</label>
                                <select name="publisher_id" class="form-control" :value="book.publisher_id">
                                    @foreach ($publishers as $publisher)
                                        <option value="{{ $publisher->id }}">{{ $publisher->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Author</label>
                                <select name="author_id" class="form-control" :value="book.author_id">
                                    @foreach ($authors as $author)
                                        <option value="{{ $author->id }}">{{ $author->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Katalog</label>
                                <select name="catalog_id" class="form-control" :value="book.catalog_id">
                                    @foreach ($catalogs as $catalog)
                                        <option value="{{ $catalog->id }}">{{ $catalog->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Qty Stock</label>
                                <input type="number" class="form-control" name="qty" required=""
                                    :value="book.qty">
                            </div>
                            <div class="form-group">
                                <label>Harga Pinjam</label>
                                <input type="number" class="form-control" name="price" required=""
                                    :value="book.price">
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-danger" v-if="editStatus"
                                @click="deleteData(book.id)">Delete</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endSection

@section('js')
    <script type="text/javascript">
        var actionUrl = '{{ url('books') }}';
        var apiUrl = '{{ url('api/books') }}';
        var app = new Vue({
            el: '#controller',
            data: {
                books: [],
                search: '',
                book: {},
                actionUrl,
                apiUrl,
                editStatus: false
            },
            mounted: function() {
                this.get_books();
            },
            methods: {
                get_books() {
                    const _this = this;
                    $.ajax({
                        url: apiUrl,
                        method: 'GET',
                        success: function(data) {
                            _this.books = JSON.parse(data);
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                },
                addData() {
                    this.book = {};
                    this.editStatus = false;
                    $('#modal-default').modal();
                },
                editData(book) {
                    this.book = book;
                    this.editStatus = true;
                    $('#modal-default').modal();
                },
                deleteData(id) {
                    if (confirm('Are you sure?')) {
                        axios.post(this.actionUrl + '/' + id, {
                            _method: 'DELETE'
                        }).then(response => {
                            $('#modal-default').modal('hide');
                            alert('Data has been deleted');
                            this.get_books();
                        });
                    }
                },
                formatNumber(number) {
                    return number.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
                },
                submitForm(event, id) {
        event.preventDefault();
        const _this = this;
        var actionUrl = !this.editStatus ? this.actionUrl : this.actionUrl + '/' + id;
        axios.post(actionUrl, new FormData($(event.target)[0])).then(response => {
            $('#modal-default').modal('hide');
            $('.modal-backdrop').remove();
            _this.get_books();
        }).catch(error => {
            console.error(error);
        });
                },
            },
            computed: {
                filterlist() {
                    return this.books.filter(book => {
                        return book.title.toLowerCase().includes(this.search.toLowerCase())
                    })
                }
            }
        });
    </script>
@endSection
