<a name="view_timeline"></a>
<div class="col-12 col-sm-6 col-md-12">
    <div class="card card-purple">
        <div class="card-header">
            <h3 class="card-title">View {{$element_name}}'s Timeline</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <div class="card-body">
            <div class="timeline">
                @php $currentDate = ''; @endphp
                @foreach($timeLines as $timeLine)
                @php $showTime = false; @endphp
                @if($currentDate != $timeLine->created_at_date)
                @php 
                    $currentDateObj = \Carbon\Carbon::parse($timeLine->created_at);
                    $currentDate = $timeLine->created_at_date;
                    $showTime = true;
                @endphp
                @endif

                @if($showTime === true)
                <div class="time-label">
                    <span class="bg-gradient-purple">{{$currentDateObj->format('jS F - Y, l')}}</span>
                </div>
                @endif

                <div>
                    <i class="{{$timeLine->icon}} {{$timeLine->icon_color}}"></i>
                    <div class="timeline-item">
                        <span class="time"><i class="fas fa-clock"></i> {{$timeLine->event_time}}</span>
                        <h3 class="timeline-header"><img src="{{$timeLine->users->user_image}}" class="img-circle elevation-2 timeline-user-image" alt="User Image" /><a href="#">{{$timeLine->users->name}}</a> {{$timeLine->min_text}}</h3>
                        <div class="timeline-body">
                            {{str_replace("_", " ", $timeLine->log)}}
                        </div>
                    </div>
                </div>
                @endforeach
                <div>
                    <i class="fas fa-clock bg-gray"></i>
                </div>
            </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer"></div>
    </div>
    <!-- /.info-box -->
</div>
<script type="text/javascript">
    $(function () {
    });
</script>