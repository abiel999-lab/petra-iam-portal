@extends('layouts.setting')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Setting</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Setting</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <style>
        .img-circle {
            border-radius: 50%;
            width: 170px;
            height: 170px;
            object-fit: cover;
        }
    </style>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="image text-center mb-4">
                    <img src="https://my.petra.ac.id/img/user.png" class="img-circle elevation-2" alt="{{ $user['email'] ?? 'user' }}">
                    <h2 style="margin-top: 10px">Welcome, {{ $user['email'] ?? '-' }}</h2>
                    <p style="margin-top: 10px">Manage your profile, session, and security according to your needs.</p>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">Your Profile</div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Nama</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{ strtoupper($user['name'] ?? '-') }}" disabled>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" value="{{ $user['email'] ?? '-' }}" disabled>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Groups</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" rows="4" disabled>{{ implode(', ', $user['groups'] ?? []) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">Your Session</div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover text-center">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>#</th>
                                                <th>IP</th>
                                                <th>Device</th>
                                                <th>OS</th>
                                                <th>Browser</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($sessionRows as $index => $row)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $row['ip'] }}</td>
                                                    <td>{{ $row['device'] }}</td>
                                                    <td>{{ $row['os'] }}</td>
                                                    <td>{{ $row['browser'] }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <small class="text-muted">Versi cepat ini hanya menampilkan sesi browser saat ini.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
     </div>
</section>
@endsection
