@extends('admin.layouts.app')
@section('title', trans('student::local.add_school'))
@section('sidebar')
@include('admin.layouts.sidebars.students-sidebar')
@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{trans('student::local.add_school')}}</h3>
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{ trans('local.dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{route('schools.index')}}">{{ trans('student::local.schools') }}</a></li>
            <li class="breadcrumb-item active">{{trans('student::local.add_school')}}
            </li>
          </ol>
        </div>
      </div>
    </div>
</div>
<div class="row match-height">
    <div class="col-md-12">
      <div class="card">
        <div class="card-content collapse show">
          <div class="card-body">
            <form class="form" action="{{route('schools.store')}}" method="POST">
              @csrf
                <div class="form-body">
                    @include('student::settings.schools.includes._form')
                </div>
              <div class="form-actions">
                <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('schools.index')}}';">
                  <i class="ft-x"></i> {{ trans('local.cancel') }}
                </button>
                <button type="submit" class="btn btn-primary">
                  <i class="la la-check-square-o"></i> {{ trans('local.save') }}
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
