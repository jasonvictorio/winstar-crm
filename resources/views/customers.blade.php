@extends('adminlte.layout   ')

@section('title', 'Customers')

@section('content')
  <table-component
    api-endpoint="customers"
    display-property="name"
    :columns="[
      { property: 'name', label: 'Name' },
      { property: 'company', label: 'Company', relation: 'companies', relationDisplay: 'name' },
      { property: 'next_follow_up_date', label: 'Next follow up date' },
      { property: 'latest_contact_or_actions', label: 'Next follow up date' },
      { property: 'nature_of_contact', label: 'Next follow up date' },
      { property: 'notes', label: 'Next follow up date' },
      { property: 'first_contacted', label: 'Next follow up date' },
      { property: 'last_contacted', label: 'Next follow up date' },
      { property: 'latest_contact_or_actions', label: 'Next follow up date' },
      { property: 'latest_contact_or_actions', label: 'Next follow up date' },
      { property: 'latest_contact_or_actions', label: 'Next follow up date' },
      { property: 'latest_contact_or_actions', label: 'Next follow up date' },
      { property: 'latest_contact_or_actions', label: 'Next follow up date' },
      { property: 'latest_contact_or_actions', label: 'Next follow up date' },
      { property: 'latest_contact_or_actions', label: 'Next follow up date' },
      { property: 'latest_contact_or_actions', label: 'Next follow up date' },
      { property: 'latest_contact_or_actions', label: 'Next follow up date' },
      { property: 'latest_contact_or_actions', label: 'Next follow up date' },
    ]"
  />
@endsection
