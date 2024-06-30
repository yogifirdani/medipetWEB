@extends('layouts.app-cust')

@section('title', 'Profile Page')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Diri</h1>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>Informasi Data Diri</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fullName">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="fullName" value="{{ $user->name }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone">Nomor Telepon</label>
                                        <input type="text" class="form-control" id="phone" value="{{ $user->phone }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" value="{{ $user->email }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="address">Alamat Rumah</label>
                                        <input type="text" class="form-control" id="address" value="{{ $user->address }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <a href="{{ route('profile.edit') }}" class="btn btn-primary mt-5">Sunting</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
