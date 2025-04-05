<div class="row">
    <div class="col-md-2">
        @foreach($caseStudy->images as $image)
            <img src="{{ asset('storage/' . $image->image) }}" width="100%" style="padding:5px" />
        @endforeach
    </div>
    <div class="col-md-10">
        <img src="{{ asset('storage/' . $caseStudy->images[1]->image) }}" width="100%" style="padding:5px" />
    </div>
</div>