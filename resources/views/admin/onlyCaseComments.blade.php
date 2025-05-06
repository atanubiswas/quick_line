@if(count($caseComments) == 0)
        <div class="alert alert-info">No comments available for this case.</div>
    @else
        @php $currentDate = ''; @endphp
        @foreach($caseComments as $caseComment)
            @php $showTime = false; @endphp
            @if($currentDate != $caseComment->created_at_date)
                @php 
                    $currentDateObj = \Carbon\Carbon::parse($caseComment->created_at);
                    $currentDate = $caseComment->created_at_date;
                    $showTime = true;
                @endphp
            @endif

        @if($showTime === true)
        <div class="time-label">
            <span class="bg-gradient-purple">{{$currentDateObj->format('jS F - Y, l')}}</span>
        </div>
        @endif

        <div>
            <i class="{{$caseComment->icon}} {{$caseComment->icon_color}}"></i>
            <div class="timeline-item">
                <span class="time"><i class="fas fa-clock"></i> {{$caseComment->event_time}}</span>
                <h3 class="timeline-header"><img src="{{$caseComment->user->user_image}}" class="img-circle elevation-2 timeline-user-image" alt="User Image" /><a href="#">{{$caseComment->user->roles[0]->name}}'s</a> Comment on this Case.</h3>
                <div class="timeline-body">
                    {!! str_replace("_", " ", $caseComment->comment) !!}
                </div>
            </div>
        </div>
        @endforeach
        <div>
            <i class="fas fa-clock bg-gray"></i>
        </div>
    @endif