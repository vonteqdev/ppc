@push('page_title')
    | Dashboard
@endpush
@push('navbar_header')
    test
@endpush
<x-app-layout>
<div class="row">
Hi s {{auth()->user()->first_name}} test
</div>
@push('js')
  <script src="{{ URL::asset('assets/js/plugins/chartjs.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/plugins/threejs.js') }}"></script>
  <script src="{{ URL::asset('assets/js/plugins/orbit-controls.js') }}"></script>
@endpush
</x-app-layout>
