@extends('layouts.app')
<style>
        .input-large { width: 210px;  }
</style>
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Select Alumni</div>

                <div class="card-body">
                    <form name="createNewMember" id="createNewMember" method="POST" action="{{route('select.tenant.store')}}">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label for="selectedTenant" class="col-md-2 col-form-label">Select Alumni<span class="required">*</span></label>
        
                                    <div class="col-md-10">
                                        <select id="selectedTenant" name="selectedTenant" class="col-md-12 form-control{{ $errors->has('selectedTenant') ? ' is-invalid' : '' }}">
                                            @foreach($tenantUsers as $tenantUser)
                                                <option value="{{ $tenantUser->tenant->tenant_uid }}">{{ $tenantUser->tenant->company_name }} - {{ $tenantUser->tenant->year }}</option>
                                            @endforeach
                                        </select>
        
                                        @if ($errors->has('selectedTenant'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('selectedTenant') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12" style="display: flex; align-self: flex-end; justify-content: flex-end;">
                                        <button type="submit" class="btn btn-primary btn-lg" style="width: 10em;">Select</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
