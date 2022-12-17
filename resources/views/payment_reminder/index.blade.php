@extends('layout.app')

@section('meta')
@endsection

@section('title')
Payments Reminders
@endsection

@section('styles')
<style>
    .followup_details {
        margin: 0px 5px;
        padding: 8px 10px !important;
        border-left: 4px solid #4CAF50;
        word-wrap: break-word;
        box-shadow: 0px 0px 6px 3px silver;
        margin-bottom: 20px;
    }
</style>
@endsection

@section('content')
<div class="page-content fade-in-up">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-head">
                    <div class="ibox-title">Payments Reminders</div>
                    <h1 class="pull-right">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#report">Report </button>
                    </h1>
                </div>

                <div class="ibox-body">
                    <ul class="nav nav-tabs tabs-line">
                        <li class="nav-item">
                            <a class="nav-link active" href="#todayTab" data-id="today" id="today" data-toggle="todayTab" aria-expanded="true">Today</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#futureTab" data-id="future" id="future" data-toggle="futureTab" aria-expanded="false">Upcoming</a>
                        </li>
                    </ul>
                    <div class="row mb-5 mt-2 mx-2">
                        <div class="col-sm-3 d-none radioParent">
                            <label class="ui-radio ui-radio-inline">
                                <input type="radio" value="all_payment" id="uiRadio" name="testRadio" checked>
                                <span class="input-span"></span>All</label>
                            <label class="ui-radio ui-radio-inline">
                                <input type="radio" value="due_payment" id="uiRadio" name="testRadio">
                                <span class="input-span"></span>Payment Due</label>
                            <label class="ui-radio ui-radio-inline">
                                <input type="radio" value="future_payment" id="uiRadio" name="testRadio">
                                <span class="input-span"></span>Future Payment</label>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane active" id="todayTab" aria-expanded="false">
                            <div class="dataTables_wrapper container-fluid dt-bootstrap4">
                                <table class="table table-bordered data-table" id="today-data-table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Date</th>
                                            <th>User Name</th>
                                            <th>Party Name</th>
                                            <th>Mobile No</th>
                                            <th>Note</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="text-center"></div>
                        </div>
                        <div class="tab-pane" id="futureTab" aria-expanded="false">
                            <div class="dataTables_wrapper container-fluid dt-bootstrap4">
                                <table class="table table-bordered data-table" id="future-data-table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Date</th>
                                            <th>User Name</th>
                                            <th>Party Name</th>
                                            <th>Mobile No</th>
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
    </div>
</div>

<div class="modal fade" id="report" tabindex="-1" role="dialog" aria-labelledby="reportTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Report</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%">Sr.No</th>
                                    <th width="25%">User Name</th>
                                    <th width="25%">Party Name</th>
                                    <th width="15%">Next Date</th>
                                    <th width="30%">Note</th>
                                </tr>
                            </thead>
                            <tbody id="report_datatable"></tbody>
                        </table>
                        <div id="report_pagination"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div id="myModel">
</div>

@endsection

@section('scripts')
<script type="text/javascript" src="{{  asset('assets/project/payment_reminders/index.js')  }}"></script>
@endsection