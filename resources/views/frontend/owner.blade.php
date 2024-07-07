@extends('layouts.frontend')

@section('content')
<main>
      <section
        class="hero-property mb-5"
        style="
          background-image: url('{{ asset('frontend/assets/images/bg-alt.jpg') }}');
          height: 50vh;
        "
      >
        <div class="container">
          <div class="row text-center" style="padding-top: 120px">
            <h3 class="text-white">List owners</h3>
          </div>
        </div>
      </section>
      <section class="container category" style="margin-bottom: 100px">
        <h3 class="text-center">Our owners</h3>
        <p class="text-center">
          We have professional owners that make your dream home comfortable
        </p>
        <hr />

        <div class="row mt-5">
        @foreach($owners as $owner)
          <div class="col-lg-4 mb-4">
            <div class="card py-5 h-100 border-0">
              <div class="mx-auto text-center">
                <img
                  width="110"
                  height="110"
                  style="object-fit: cover"
                  src="{{ Storage::url($owner->profile) }}"
                  class="mb-3 rounded-circle d-block mx-auto border border-warning"
                  alt=""
                />
                <span class="mb-1 d-block text-secondary">Listed By</span>
                <h5 class="mb-3">{{ $owner->name }}</h5>
                <hr />
                <ul class="list-unstyled mb-5">
                  <li
                    style="column-gap: 3rem"
                    class="text-secondary mb-3 d-flex justify-content-between"
                  >
                    <span class="fw-light">Phone : </span> {{ $owner->phone }}
                  </li>
                  <li
                    style="column-gap: 3rem"
                    class="text-secondary mb-3 d-flex justify-content-between"
                  >
                    <span class="fw-light">Fax : </span> {{ $owner->fax }}
                  </li>
                  <li
                    style="column-gap: 3rem"
                    class="text-secondary mb-3 d-flex justify-content-between"
                  >
                    <span class="fw-light">WhatsApp : </span> {{ $owner->whatsapp }}
                  </li>
                  <li
                    style="column-gap: 3rem"
                    class="text-secondary mb-3 d-flex justify-content-between"
                  >
                    <span class="fw-light">Email : </span> {{ $owner->email }}
                  </li>
                  <li
                    style="column-gap: 3rem"
                    class="text-secondary mb-3 d-flex justify-content-between"
                  >
                    <span class="fw-light">Properties : </span> {{ $owner->properties->count() }}
                  </li>
                </ul>
              </div>
              <a href="tel:{{ $owner->phone }}" target="_blank" class="w-75 p-3 text-center mx-auto btn btn-primary"
                >Contact Now</a
              >
            </div>
          </div>
        @endforeach
        </div>
      </section>
    </main>
@endsection