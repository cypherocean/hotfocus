@extends('layout.app')

@section('meta')
@endsection

@section('title')
Payments
@endsection

@section('styles')
@endsection

@section('content')
<div class="page-content fade-in-up">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-head">
                    <h1 class="ibox-title">Payments</h1>
                    <h1 class="pull-right">
                        <a class="btn btn-primary pull-right ml-2" style="margin-top: 8px;margin-bottom: 5px" href="{{ route('payment.import.file') }}">Upload new data </a>
                    </h1>
                </div>

                <div class="ibox-body">
                    <div class="row mb-5 mt-2 mx-2">
                        <div class="col-sm-3">
                            <label for="type" class="font-weight-bold">Type <span class="text-danger"></span></label>
                            <select name="type" id="type" class="form-control">
                                <option value="all">All</option>
                                <option value="assigned">Assigned</option>
                                <option value="not_assigned">Not Assigned</option>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label for="start_date" class="font-weight-bold">Start Date <span class="text-danger"></span></label>
                            <input type="date" name="start_date" id="start_date" class="form-control date">
                        </div>
                        <div class="col-sm-3">
                            <label for="end_date" class="font-weight-bold">End Date <span class="text-danger"></span></label>
                            <input type="date" name="end_date" id="end_date" class="form-control date">
                        </div>
                        <div class="col-sm-3">
                            <label for="reset"> <span class="text-danger"></span></label>
                            <button type="button" name="reset" id="reset" class="form-control btn btn-primary mt-2">Reset</button>
                        </div>
                    </div>

                    <div class="dataTables_wrapper container-fluid dt-bootstrap4">
                        <table class="table table-bordered data-table" id="data-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Party Name</th>
                                    <th>Amount</th>
                                    <th>Reminder</th>
                                    <th>Note</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="text-center"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="myModel"></div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{  asset('assets/project/payments/index.js')  }}"></script>
@endsection