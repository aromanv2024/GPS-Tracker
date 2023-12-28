@extends ('domains.state.update-layout')

@section ('content')

<div class="box p-5 mt-5">
    <input type="search" class="form-control form-control-lg" placeholder="{{ __('state-update-merge.filter') }}" data-table-search="#state-update-merge-table" />
</div>

<form method="post">
    <input type="hidden" name="_action" value="updateMerge" />

    <div class="box p-5 mt-5">
        <div class="overflow-auto scroll-visible header-sticky">
            <table id="state-update-merge-table" class="table table-report font-medium font-semibold text-center whitespace-nowrap" data-table-sort data-table-pagination data-table-pagination-limit="10">
                <thead>
                    <tr>
                        <th class="text-left">{{ __('state-update-merge.name') }}</th>
                        <th class="text-left">{{ __('state-update-merge.alias') }}</th>
                        <th class="text-left">{{ __('state-update-merge.country') }}</th>
                        <th>{{ __('state-update-merge.select') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($list as $each)

                    @php ($link = route('state.update', $each->id))

                    <tr>
                        <td class="text-left"><a href="{{ $link }}" class="block">{{ $each->name }}</a></td>
                        <td class="text-left"><a href="{{ $link }}" class="block">{{ implode(', ', $each->alias ?? []) }}</a></td>
                        <td class="text-left">{{ $each->country->name }}</td>
                        <td class="w-1">
                            @if ($each->id !== $row->id)
                            <input type="checkbox" name="ids[]" value="{{ $each->id }}" />
                            @endif
                        </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="box p-5 mt-5">
        <div class="text-right">
            <button type="submit" class="btn btn-primary">{{ __('state-update-merge.merge') }}</button>
        </div>
    </div>
</form>

@stop
