@props(['title' => '', 'text' => '', 'button_text' => '', 'href' => '#'])
<div class="col-md-4">
    <div class="card mb-4 shadow-sm">
            <div class="card-header">
                <h4 class="my-0 font-weight-normal">{{ $title }}</h4>
            </div>
        <div class="card-body">
            <p class="card-text">{{ $text }}</p>
            <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                    <x-utils.view-button :href="$href" :text="__('Просмотреть')"/>
                </div>
            </div>
        </div>
    </div>
</div>
