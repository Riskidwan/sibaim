@extends('public.layouts.app')

@section('content')
<section class="py-5 bg-light min-vh-100" style="padding-top: 100px !important;">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h3 class="fw-bold text-dark mb-0">Pemberitahuan</h3>
                        <p class="text-muted small mb-0">Informasi terbaru mengenai permohonan Anda</p>
                    </div>
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <form action="{{ route('user.notifications.mark-all-read') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-primary rounded-pill">
                                <i class="fas fa-check-double me-1"></i> Tandai Semua Dibaca
                            </button>
                        </form>
                    @endif
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="list-group list-group-flush">
                        @forelse($notifications as $notification)
                            <div class="list-group-item list-group-item-action p-4 border-bottom {{ $notification->unread() ? 'bg-light border-start border-primary border-4' : '' }}">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="d-flex">
                                        <div class="me-3">
                                            @if($notification->unread())
                                                <div class="bg-primary rounded-circle" style="width: 10px; height: 10px; margin-top: 6px;"></div>
                                            @else
                                                <i class="fas fa-check-circle text-muted" style="font-size: 14px;"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <h6 class="mb-1 fw-bold {{ $notification->unread() ? 'text-primary' : 'text-dark' }}">
                                                Pembaruan Status Permohonan
                                            </h6>
                                            <p class="mb-1 text-secondary small" style="line-height: 1.5;">
                                                {{ $notification->data['message'] }}
                                            </p>
                                            <div class="d-flex align-items-center mt-2">
                                                <span class="text-muted small me-3">
                                                    <i class="far fa-clock me-1"></i> {{ $notification->created_at->diffForHumans() }}
                                                </span>
                                                <span class="badge bg-info-subtle text-info border border-info-subtle small fw-semibold">
                                                    {{ $notification->data['no_registrasi'] }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    @if($notification->unread())
                                        <form action="{{ route('user.notifications.read', $notification->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-link btn-sm p-0 text-decoration-none text-primary fw-bold" style="font-size: 0.75rem;">
                                                Tandai Dibaca
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="p-5 text-center">
                                <img src="{{ asset('img/no-data.svg') }}" alt="No Notifications" class="mb-3" style="width: 120px; opacity: 0.5;">
                                <h5 class="text-muted">Belum ada pemberitahuan</h5>
                                <p class="text-muted small">Anda akan menerima pemberitahuan di sini jika ada pembaruan pada permohonan Anda.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="mt-4 d-flex justify-content-center">
                    {{ $notifications->links() }}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
