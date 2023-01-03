@extends('layouts.app', [
    'class' => '',
    'elementActive' => 'home'
])

@push('styles')
    <style>
        .timeline {
            list-style: none;
            padding: 20px 0 20px;
            position: relative;
        }
        .timeline:before {
            top: 0;
            bottom: 0;
            position: absolute;
            content: " ";
            width: 3px;
            background-color: #ccc;
            left: 25px;
            margin-left: -1.5px;
        }
        .timeline > li {
            margin-bottom: 20px;
            position: relative;
        }
        .timeline > li:before,
        .timeline > li:after {
            content: " ";
            display: table;
        }
        .timeline > li:after {
            clear: both;
        }
        .timeline > li:before,
        .timeline > li:after {
            content: " ";
            display: table;
        }
        .timeline > li:after {
            clear: both;
        }
        .timeline > li > .timeline-panel {
            width: calc( 100% - 75px );
            float: right;
            border: 1px solid #d4d4d4;
            border-radius: 2px;
            padding: 20px;
            position: relative;
            -webkit-box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);
            box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);
            background-color: white;
        }
        .timeline > li > .timeline-panel:before {
            position: absolute;
            top: 26px;
            left: -15px;
            display: inline-block;
            border-top: 15px solid transparent;
            border-right: 15px solid #ccc;
            border-left: 0 solid #ccc;
            border-bottom: 15px solid transparent;
            content: " ";
        }
        .timeline > li > .timeline-panel:after {
            position: absolute;
            top: 27px;
            left: -14px;
            display: inline-block;
            border-top: 14px solid transparent;
            border-right: 14px solid #fff;
            border-left: 0 solid #fff;
            border-bottom: 14px solid transparent;
            content: " ";
        }
        .timeline > li > .timeline-badge {
            color: #fff;
            width: 50px;
            height: 50px;
            line-height: 50px;
            font-size: 1.4em;
            text-align: center;
            position: absolute;
            top: 16px;
            left: 0px;
            margin-right: -25px;
            background-color: #999999;
            z-index: 100;
            border-top-right-radius: 50%;
            border-top-left-radius: 50%;
            border-bottom-right-radius: 50%;
            border-bottom-left-radius: 50%;
        }
        .timeline > li.timeline-inverted > .timeline-panel {
            float: left;
        }
        .timeline > li.timeline-inverted > .timeline-panel:before {
            border-right-width: 0;
            border-left-width: 15px;
            right: -15px;
            left: auto;
        }
        .timeline > li.timeline-inverted > .timeline-panel:after {
            border-right-width: 0;
            border-left-width: 14px;
            right: -14px;
            left: auto;
        }
        .timeline-badge.primary {
            background-color: #2e6da4 !important;
        }
        .timeline-badge.success {
            background-color: #6bd098 !important;
        }
        .timeline-badge.warning {
            background-color: #fbc658 !important;
        }
        .timeline-badge.danger {
            background-color: #ef8157 !important;
        }
        .timeline-badge.info {
            background-color: #51bcda !important;
        }
        .border-primary {
            border-color: #2e6da4 !important;
        }
        .border-success {
            border-color: #6bd098 !important;
        }
        .border-warning {
            border-color: #fbc658 !important;
        }
        .border-danger {
            border-color: #ef8157 !important;
        }
        .border-info {
            border-color: #51bcda !important;
        }
        .timeline-title {
            margin-top: 0;
            color: inherit;
            border-bottom: 2px solid;
            font-weight: 400;
            padding-bottom: 0.25rem;
            font-size: 1.25rem;
        }
        .timeline-body > p,
        .timeline-body > ul {
            margin-bottom: 0;
        }
        .timeline-body > p + p {
            margin-top: 5px;
        }
    </style>
@endpush

@section('content')
<div class="content">
    <div class="row">
        <!-- Start timeline -->
        <div class="col-md-5">
            <h5 class="text-center">ACTION TIMELINE</h5>
            <ul class="timeline">
                @foreach ($actions->where('status', '!=', 3) as $action)
                <li>
                    <div class="timeline-badge {{ $action->status_color }}">
                    @switch($action->status)
                        @case(0)
                            <i class="fa-solid fa-xmark"></i>
                            @break
                        @case(1)
                            <i class="fa-solid fa-check"></i>
                            @break
                        @case(2)
                            <i class="fa-solid fa-spinner"></i>
                            @break
                        @endswitch
                    </div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4 class="timeline-title border-{{ $action->status_color}}">{{ $action->name }}</h4>
                        </div>
                        <div class="timeline-body">
                            <p class="d-flex justify-content-between my-2">
                                    @php
                                        if (is_null($action->end_time)) {
                                            $minute = $action->start_time->diffInMinutes(now());
                                        } else {
                                            $minute = $action->start_time->diffInMinutes($action->end_time);
                                        }
                                    @endphp
                                <font>
                                    <i class="fa-regular fa-clock"></i>
                                    {{ $minute }} minutes
                                </font>
                                <font>Score: {{ $action->score }}</font>
                            </p>
                            <div class="text-right" data-toggle="modal" data-target="#modal" data-id="{{ $action->id }}" data-name="{{ $action->name }}" data-duration="{{ $minute }}" data-score="{{ $action->score }}" data-tags="{{ json_encode($action->tags->pluck('name')) }}" data-color="{{ $action->status_color }}">
                                <small class="text-muted">Click read more</small>
                            </div>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
        <!-- End timeline -->

        <!-- Start timeline modal -->
        <div class="modal" id="modal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Action</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h6 id="name"></h6>
                        <div class="d-flex justify-content-between my-3">
                            <span>
                                <font class="text-muted">Duration: </font>
                                <font id="duration"></font> minutes
                            </span>
                            <span>
                                <font class="text-muted">Score: </font>
                                <font id="score"></font> pts
                            </span>
                            <span id="tags"></span>
                        </div>
                        <p>A IP with offensive actions has success login on Portal，please find out which account was compromised. Also providing the login time，attacker&#39;s IP.</p>
                        <form>
                            <input type="hidden" id="id">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="ip">Attacker's IP</label>
                                    <input type="text" class="form-control" id="ip">
                                    <span class="text-danger error error-ip"></span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" id="username">
                                    <span class="text-danger error error-username"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="time">Login Time</label>
                                <input type="text" class="form-control" id="time" placeholder="YYYY/MM/DD HH:ii:ss">
                                <span class="text-danger error error-time"></span>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="submit">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End timeline modal -->

        <!-- Start ticket -->
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">Ticket</h5>
                </div>

                <div class="card-body">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <div class="nav-link active" id="nav-home-tab" data-toggle="tab" data-target="#nav-all" role="tab" aria-controls="nav-all" aria-selected="true">
                                All
                                <span class="badge badge-pill badge-light">{{ $actions->count() }}</span>
                            </div>
                            <div class="nav-link" id="nav-profile-tab" data-toggle="tab" data-target="#nav-queued" role="tab" aria-controls="nav-queued" aria-selected="false">
                                Queued
                                <span class="badge badge-pill badge-light">{{ $actions->whereIn('status', [2, 3])->count() }}</span>
                            </div>
                            <div class="nav-link" id="nav-contact-tab" data-toggle="tab" data-target="#nav-resolved" role="tab" aria-controls="nav-resolved" aria-selected="false">
                                Resolved
                                <span class="badge badge-pill badge-light">{{ $actions->where('status', 0)->count() }}</span>
                            </div>
                            <div class="nav-link" id="nav-contact-tab" data-toggle="tab" data-target="#nav-rejected" role="tab" aria-controls="nav-rejected" aria-selected="false">
                                Rejected
                                <span class="badge badge-pill badge-light">{{ $actions->where('status', 1)->count() }}</span>
                            </div>
                        </div>
                    </nav>
                    <div class="tab-content">
                        @foreach ([
                            'all' => [0, 1, 2, 3],
                            'queued' => [2, 3],
                            'rejected' => [0],
                            'resolved' => [1]
                        ] as $key => $array)
                        <div class="tab-pane fade @if($key == 'all') active show @endif" id="nav-{{ $key }}" role="tabpanel" aria-labelledby="nav-{{ $key }}-tab">
                            <table class="table">
                                <tbody>
                                    @foreach ($actions->whereIn('status', $array) as $action)
                                    <tr>
                                        <td>
                                            <span class="px-2 py-1 text-white rounded
                                                @switch ($action->status)
                                                    @case(0)
                                                        btn-danger
                                                        @break
                                                    @case(1)
                                                        btn-success
                                                        @break
                                                    @case(2)
                                                        btn-warning
                                                        @break
                                                    @case(3)
                                                        btn-primary
                                                        @break
                                                @endswitch
                                            ">{{ $action->ticket_status }}</span>
                                        </td>
                                        <td>
                                            {{ $action->name }}
                                            <br>
                                            <small>
                                                @foreach ($action->tags as $tag)
                                                <span>{{ $tag->name }}</span>
                                                @endforeach
                                                <span class="text-success">+{{ $action->score }} pts</span>
                                            </small>
                                        </td>
                                        <td width="20%">
                                            @if ($action->status == 2)
                                            <div class="progress" style="height: 10px;">
                                                <div class="progress-bar bg-secondary" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="text-center text-muted">
                                                @php $second = $action->start_time->diffInMinutes(now()) @endphp
                                                <span>{{ $action->start_time->diff(now())->format('%DD %H:%I:%S') }} remain</span>
                                            </div>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    Change Status
                                                </button>
                                                <div class="dropdown-menu status-items" data-id="{{ $action->id }}">
                                                    <button type="button" class="dropdown-item status-item @if($action->status == 2) disabled text-black-50 @endif" data-status="2">Processing</button>
                                                    <button type="button" class="dropdown-item status-item @if($action->status == 3) disabled text-black-50 @endif" data-status="3">Pending</button>
                                                    <button type="button" class="dropdown-item status-item @if($action->status == 0) disabled text-black-50 @endif" data-status="0">Rejected</button>
                                                    <button type="button" class="dropdown-item status-item @if($action->status == 1) disabled text-black-50 @endif" data-status="1">Resolved</button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- End ticket -->
    </div>
</div>
@endsection

@push('scripts')
<script>
    // 顯示 Action Data
    $('#modal').on('show.bs.modal', function (event) {
        let self = $(event.relatedTarget)
        $('#id').val(self.data('id'))
        $('#name').text(self.data('name')).attr('class' ,'text-' + self.data('color'))
        $('#duration').text(self.data('duration'))
        $('#score').text(self.data('score'))
        $.each(self.data('tags'), function (key, name) {
            $('#tags').append(
                '<span class="badge badge-info mr-1">' + name + '</span>'
            )
        })
    })

    // 還原
    $('#modal').on('hidden.bs.modal', function () {
        $('#modal input').val('')
        $('#tags').empty()
    })

    // 資料紀錄
    $('#modal #submit').on('click', function () {
        axios.put('/action/' + $('#modal #id').val() , {
            ip: (Math.floor(Math.random() * 255) + 1)+"."+(Math.floor(Math.random() * 255))+"."+(Math.floor(Math.random() * 255))+"."+(Math.floor(Math.random() * 255)),
            username: (Math.random() + 1).toString(36).substring(7),
            time: new Date(new Date() - Math.random()*(1e+12)).toLocaleString(undefined, {year: 'numeric', month: '2-digit', day: '2-digit', hour: '2-digit', hour12: false, minute:'2-digit', second:'2-digit'}),
        }).then(function (response) {
            alert('Success!')
        }).catch(function (error) {
            if (error.response.status == 422) {
                $.each(error.response.data.errors, function (field, message) {
                    $('.error-' + field).text(message)
                })
            }
        })
    })

    // 狀態異動
    $('.status-items .status-item').on('click', function () {
        if (!$(this).hasClass('disabled')) {
            axios.put('/action/' + $(this).parent().attr('data-id') + '/changeStatus', {
                status: $(this).attr('data-status')
            }).then(function (response) {
                alert('Changed!')
            }).catch(function (error) {
                if (error.response.status == 422 && error.response.data.errors.status !== undefined) {
                    alert(error.response.data.errors.status[0])
                }
            })
        }
    })
</script>
@endpush
