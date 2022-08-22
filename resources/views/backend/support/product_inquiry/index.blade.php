@extends('backend.layouts.app')

@section('content')

<div class="card">
    <div class="card-header">
        <h5 class="mb-0 h6">{{translate('Product Inquiries')}}</h5>
    </div>
    <div class="card-body">
        <table class="table aiz-table mb-0" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th data-breakpoints="lg">#</th>
                    <th data-breakpoints="lg">{{ translate('Date') }}</th>
                    <th data-breakpoints="lg">{{translate('Name')}}</th>
                    <th>{{translate('Sender')}}</th>
                    <th width="10%">{{translate('Options')}}</th>
                </tr>
            </thead>
            <tbody>
                    @foreach ($conversations as $key => $conversation)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{ $conversation->created_at }}</td>
                        <td>{{ $conversation->name }}</td>
                        <td>{{ $conversation->email }}</td>
                        <td class="text-right">
                            <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('inquiries.admin_show', encrypt($conversation->id))}}" title="{{ translate('View') }}">
                                <i class="las la-eye"></i>
                            </a>
                            <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('inquiries.admin_destroy', encrypt($conversation->id))}}" title="{{ translate('Delete') }}">
                                <i class="las la-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection
