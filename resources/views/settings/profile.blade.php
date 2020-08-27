@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        User Profile
        <small>User Profile</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><i class="fa fa-gear"></i> User profile</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row">
        <div class="col-md-12">
          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img src="{{ Auth::user()->foto() }}" class="profile-user-img img-responsive img-circle" alt="User profile picture">
              
              {{-- <h3 class="profile-username text-center">{{ Auth::user()->name }}</h3> --}}
              <p class="text-muted text-center"></p>
              <table class="table table-striped" cellspacing="0" width="100%">
        				<tbody>
        					<tr>
        						<td class="text-muted" style="width: 10%;">Nama</td>
        						<td style="width: 1%;">:</td>
                    @if (strlen(Auth::user()->username) > 4)
                      @if (!empty(Auth::user()->nm_supp))
                        <td>{{ auth()->user()->name }} ({{ auth()->user()->nm_supp }})</td>
                      @else
                        <td>{{ auth()->user()->name }}</td>
                      @endif
                    @else
                      <td>{{ auth()->user()->name }}</td>
                    @endif
        					</tr>
        					<tr>
        						<td class="text-muted" style="width: 10%;">Username</td>
        						<td style="width: 1%;">:</td>
        						<td>{{ auth()->user()->username }}</td>
        					</tr>
        					<tr>
        						<td class="text-muted" style="width: 10%;">Email</td>
        						<td style="width: 1%;">:</td>
        						<td>{{ auth()->user()->email }}</td>
        					</tr>
                  <tr>
                    <td class="text-muted" style="width: 10%;">Init</td>
                    <td style="width: 1%;">:</td>
                    <td>{{ auth()->user()->init_supp }}</td>
                  </tr>
                  <tr>
                    <td class="text-muted" style="width: 10%;">No. HP</td>
                    <td style="width: 1%;">:</td>
                    <td>{{ auth()->user()->no_hp }}</td>
                  </tr>
                  <tr>
                    <td class="text-muted" style="width: 10%;">ID Telegram</td>
                    <td style="width: 1%;">:</td>
                    <td>{{ auth()->user()->telegram_id }}</td>
                  </tr>
        					<tr>
        						<td class="text-muted" style="width: 10%;">Role</td>
        						<td style="width: 1%;">:</td>
        						<td>{{ auth()->user()->rolename_desc }}</td>
        					</tr>
        					{{-- <tr>
        						<td class="text-muted" style="width: 10%;">Login terakhir</td>
        						<td style="width: 1%;">:</td>
        						<td>{{ auth()->user()->last_login }}</td>
        					</tr> --}}
                  {{-- <tr>
                    <td class="text-muted" style="width: 10%;">IP Address</td>
                    <td style="width: 1%;">:</td>
                    <td>{!! Form::label('last_login_ip', auth()->user()->last_login_ip, ['id'=>'last_login_ip']) !!}</td>
                  </tr> --}}
                  <tr>
                    <td class="text-muted" style="width: 10%;">Your IP Address</td>
                    <td style="width: 1%;">:</td>
                    <td>{!! Form::label('label_ip', auth()->user()->getIp(), ['id'=>'label_ip']) !!}</td>
                  </tr>
        					<tr>
        						<td class="text-muted" style="width: 10%;" colspan="2"><a href="{{ url('/settings/profile/edit') }}" class="btn btn-primary btn-block"><b>Update Profile</b></td>
        					</tr>
        				</tbody>
        			</table>
             </a>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection